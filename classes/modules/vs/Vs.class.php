<?php

class PluginVs_ModuleVs extends ModuleORM
{
    /**
     * Current mapper
     */
    protected $oMapper;
    /**
     * Current user
     */
    protected $oUserCurrent = null;

    public function Init()
    {
        parent::Init();
        $this->oMapper = E::GetMapper(__CLASS__);
        $this->oUserCurrent = E::ModuleUser()->GetUserCurrent();
    }

    public function GetMyTeamTournament($oTournament)
    {
        $nTeamTournament = 0;
        if ($this->oUserCurrent) {

            $sKey = "user_" . $this->oUserCurrent->GetUserId() . "_teamtournament_" . $oTournament->getTournamentId();

            if (false === ($nTeamTournament = $this->Cache_Get($sKey))) {

                if ($oTeamTournament = E::Module('PluginVs\Vs')->GetTeamTournamentByFilter(array(
                    'tournament_id' => $oTournament->getTournamentId(),
                    'player_id' => $this->oUserCurrent->GetUserId()
                ))
                ) {
                    $nTeamTournament = $oTeamTournament->getId();
                }


                if ($nTeamTournament == 0 && $oTournament->getGameType()->getType() == 'team') {
                    if ($oPlayerTeamTournament = E::Module('PluginVs\Vs')->GetPlayerTeamTournamentByFilter(array(
                        'tournament_id' => $oTournament->getTournamentId(),
                        'user_id' => $this->oUserCurrent->GetUserId()
                    ))
                    ) {
                        if ($oTeamTournament = E::Module('PluginVs\Vs')->GetTeamTournamentByFilter(array(
                            'tournament_id' => $oTournament->getTournamentId(),
                            'team_id' => $oPlayerTournament->getTeamId()
                        ))
                        ) {
                            $nTeamTournament = $oTeamTournament->getId();
                        }
                    }
                }
                $this->Cache_Set($nTeamTournament, $sKey, array("PluginVs_ModuleVs_EntityTeamTournament_save", "PluginVs_ModuleVs_EntityPlayerTournament_save"), 60 * 60 * 24 * 1);
            }
        }
        return $nTeamTournament;
    }

    public function IsTournamentAdmin($oTournament)
    {
        $admin = false;
        if ($this->oUserCurrent) {
            if ($this->oUserCurrent->isAdministrator()) return true;

            $sKey = "user_" . $this->oUserCurrent->GetUserId() . "_tournament_admin_" . $oTournament->getTournamentId();

            if (false === ($myTeam = $this->Cache_Get($sKey))) {
                $admin = false;
                if ($this->User_IsAuthorization()) {
                    $aTournamentAdmin = E::Module('PluginVs\Vs')->GetTournamentAdminItemsByFilter(array(
                        'tournament_id' => $oTournament->getTournamentId(),
                        'user_id' => $this->oUserCurrent->GetUserId(),
                        '#page' => 'count',
                        'expire >=' => date("Y-m-d")
                    ));
                    if ($aTournamentAdmin['count'] > 0) $admin = true;
                }
                $this->Cache_Set($admin, $sKey, array("PluginVs_ModuleVs_EntityTournamentAdmin_save"), 60 * 60 * 24);
            }

        }
        return $admin;

    }

    public function GetTopicsByTournament($iPage, $iPerPage, $tournament_id, $bAddAccessible = false)
    {
        $aFilter = array(
            'tournament_id' => $tournament_id,
            'topic_publish' => 1,
            'order' => array('t.topic_sticky desc', 't.topic_date_add desc')
        );

        if ($this->oUserCurrent && $bAddAccessible) {
            $aOpenBlogs = E::ModuleBlog()->GetAccessibleBlogsByUser($this->oUserCurrent);
            if (count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
        }

        return E::ModuleTopic()->GetTopicsByFilter($aFilter, $iPage, $iPerPage);
    }
}

?>
