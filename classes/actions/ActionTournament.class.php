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
        $this->AddEvent('index', 'EventIndex');

    }

    protected function EventIndex()
    {

    }

    /**
     * Завершение работы экшена
     */
    public function EventShutdown()
    {

    }
}

?>
