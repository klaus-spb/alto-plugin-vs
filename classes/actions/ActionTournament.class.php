<?php

class PluginTournament_ActionVs extends ActionPlugin
{

    /**
     * Main menu
     */
    protected $sMenuHeadItemSelect = 'tournament';
    /**
     * Menu
     */
    protected $sMenuItemSelect = 'tournament';
    /**
     * Submenu
     */
    protected $sMenuSubItemSelect = 'all';
    /**
     * Current user
     */
    protected $oUserCurrent = null;
    /**
     * Current tournament
     */
    protected $oTournament = null;
    /**
     * Game
     */
    protected $oGame = null;
    /**
     * User`s team
     */
    protected $myTeam = 0;
    /**
     * User`s TeamTournament
     */
    protected $myTeamTournament = 0;
    /**
     * Ss tournament admin
     */
    protected $isAdmin = null;

    /**
     * Init action
     */
    public function Init()
    {
        $this->SetDefaultEvent('index');

        $this->oUserCurrent = E::ModuleUser()->GetUserCurrent();
        $this->oTournament = E::Module('PluginVs\Vs')->GetTournamentByUrl(Router::GetActionEvent());

        /**
         * Check that we get tournament
         */
        if (!$this->oTournament) {
            return R::Action('error');
        }
        /**
         * Check the tournament have blog
         */
        if (!$this->oTournament->getBlog()) {
            return R::Action('error');
        }
        /**
         * Check rights for closed blog
         */
        if ($this->oTournament->getBlog() && $this->oTournament->getBlog()->GetBlogType()->IsPrivate()) {
            if (!$this->oUserCurrent || !in_array($this->oTournament->getBlog()->getId(), E::ModuleBlog()->GetAccessibleBlogsByUser($this->oUserCurrent))) {
                E::ModuleMessage()->AddErrorSingle($this->Lang_Get('blog_close_show'), $this->Lang_Get('not_access'));
                return R::Action('error');
            }
        }

        $this->oGame = $this->oTournament->getGame();
        $this->myTeamTournament = E::Module('PluginVs\Vs')->GetMyTeamTournament($this->oTournament);
        $this->myTeam = $this->myTeamTournament->getTeamId();
        $this->isAdmin = E::Module('PluginVs\Vs')->IsTournamentAdmin($this->oTournament);

        //$this->Viewer_AddWidget('right', 'tournamentdescription', array('plugin' => 'vs', 'oTournament' => $this->oTournament), 204);
        //$this->Viewer_AddWidget('right', 'tournamentsheduleloader', array('plugin' => 'vs', 'oTournament' => $this->oTournament, 'myteam' => $this->myTeam), 203);
        //$this->Viewer_AddWidget('right', 'tournamentteamtable', array('plugin' => 'vs', 'oTournament' => $this->oTournament), 202);

        $this->Viewer_Assign('oGame', $this->oGame);
        $this->Viewer_Assign('oTournament', $this->oTournament);

        if ($this->isAdmin) $this->Viewer_Assign('admin', 'yes');

        $this->Viewer_AddHtmlTitle($this->oTournament->getName());

    }

    /**
     * Регистрируем евенты
     */
    protected function RegisterEvent()
    {
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^players$/', 'EventPlayers');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^schedule$/', 'EventSchedule');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^rules$/', 'EventRules');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^events$/', 'EventEvents');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^admin$/', 'EventAdmin');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^stats$/', 'EventStats');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^po/', 'EventPo');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^stats_sh$/', 'EventStatsSh');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^player_stats$/', 'EventPlayerStats');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^match_comment$/', 'EventMatchComment');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^match_insert$/', 'EventMatchInsert');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^match/', 'EventMatch');
        $this->AddEventPreg('/^[\w\-\_]+$/i', 'EventMainPageTournament');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^[\w\-\_]+$/i', 'EventMainPageTournament');
    }

    protected function EventMainPageTournament()
    {
        $this->SetTemplateAction('index');
    }

    protected function EventPlayers()
    {

    }

    protected function EventSchedule()
    {

    }

    protected function EventRules()
    {

    }

    protected function EventEvents()
    {

    }

    protected function EventAdmin()
    {

    }

    protected function EventStats()
    {

    }

    protected function EventPo()
    {

    }

    protected function EventStatsSh()
    {

    }

    protected function EventPlayerStats()
    {

    }

    protected function EventMatchComment()
    {

    }

    protected function EventMatchInsert()
    {

    }

    protected function EventMatch()
    {

    }

    /**
     * Завершение работы экшена
     */
    public function EventShutdown()
    {
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
        $this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
        $this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
        $this->Viewer_Assign('oTournament', $this->oTournament);
        $this->Viewer_Assign('oBlog', $this->oTournament->getBlog());
        $this->Viewer_Assign('oGame', $this->oGame);
        $this->Viewer_Assign('tournament_id', $this->oTournament->getTournamentId());
        $this->Viewer_Assign('myteam', $this->myTeam);
        $this->Viewer_Assign('myteamtournament', $this->myTeamTournament);
    }
}

?>
