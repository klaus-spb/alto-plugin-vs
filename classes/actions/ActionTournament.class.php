<?php

class PluginVs_ActionTournament extends ActionPlugin
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
    protected $nMyTeamId = 0;
    /**
     * User`s TeamTournament
     */
    protected $oMyTeamTournament = null;
    /**
     * Ss tournament admin
     */
    protected $bIsAdmin = false;

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
        $this->oMyTeamTournament = E::Module('PluginVs\Vs')->GetMyTeamTournament($this->oTournament);
        if ($this->oMyTeamTournament) $this->nMyTeamId = $this->oMyTeamTournament->getTeamId();
        $this->bIsAdmin = E::Module('PluginVs\Vs')->IsTournamentAdmin($this->oTournament);

        //E::ModuleViewer()->AddWidget('right', 'tournamentdescription', array('plugin' => 'vs', 'oTournament' => $this->oTournament), 204);
        //E::ModuleViewer()->AddWidget('right', 'tournamentsheduleloader', array('plugin' => 'vs', 'oTournament' => $this->oTournament, 'oTeamTournament' => $this->oMyTeamTournament), 203);
        //E::ModuleViewer()->AddWidget('right', 'tournamentteamtable', array('plugin' => 'vs', 'oTournament' => $this->oTournament), 202);

        E::ModuleViewer()->Assign('oGame', $this->oGame);
        E::ModuleViewer()->Assign('oTournament', $this->oTournament);


        E::ModuleViewer()->AddHtmlTitle($this->oTournament->getName());

    }

    /**
     * Завершение работы экшена
     */
    public function EventShutdown()
    {
        /**
         * Загружаем переменные в шаблон
         */
        E::ModuleViewer()->Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
        E::ModuleViewer()->Assign('sMenuItemSelect', $this->sMenuItemSelect);
        E::ModuleViewer()->Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
        E::ModuleViewer()->Assign('oTournament', $this->oTournament);
        E::ModuleViewer()->Assign('oBlog', $this->oTournament->getBlog());
        E::ModuleViewer()->Assign('oGame', $this->oGame);
        E::ModuleViewer()->Assign('tournament_id', $this->oTournament->getTournamentId());
        E::ModuleViewer()->Assign('nMyTeamId', $this->nMyTeamId);
        E::ModuleViewer()->Assign('oMyTeamTournament', $this->oMyTeamTournament);
        E::ModuleViewer()->Assign('bIsAdmin', $this->bIsAdmin);
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
        $this->sMenuSubItemSelect = "index";

        $iPage = $this->_getPageNum();

        $aResult = E::Module('PluginVs\Vs')->GetTopicsByTournament($iPage, 10, $this->oTournament->getTournamentId());

        $aTopics = $aResult['collection'];
        /**
         * Формируем постраничность
         */

        $aPaging = E::ModuleViewer()->MakePaging($aResult['count'], $iPage, 10, 4, $this->oTournament->getUrlFull());
        /**
         * Загружаем переменные в шаблон
         */
        E::ModuleViewer()->Assign('aTopics', $aTopics);
        E::ModuleViewer()->Assign('aPaging', $aPaging);

        $Indexmatches = E::Module('PluginVs\Vs')->StreamReadMainPage(10, 0, $this->oTournament->getTournamentId(), 0, 0,
            0, 0);
        E::ModuleViewer()->Assign('Indexmatches', $Indexmatches);

        $this->SetTemplateAction('index');
    }

    protected function _getPageNum($nNumParam = null)
    {

        $nPage = 1;
        if (!is_null($nNumParam) && preg_match("/^page(\d+)$/i", $this->GetParam(intval($nNumParam)), $aMatch)) {
            $nPage = $aMatch[1];
        } elseif (preg_match("/^page(\d+)$/i", $this->GetLastParam(), $aMatch)) {
            $nPage = $aMatch[1];
        }
        return $nPage;
    }

    protected function EventPlayers()
    {

    }

    protected function EventSchedule()
    {

    }

    protected function EventRules()
    {
        $this->sMenuSubItemSelect = "rules";
        E::ModuleViewer()->AddHtmlTitle('Rules');

        $oTournamentRules = E::Module('PluginVs\Vs')->GetTournamentRulesByTournamentId($this->oTournament->getTournamentId());
        E::ModuleViewer()->Assign('oTournamentRules', $oTournamentRules);

        if (R::GetParam(1) == 'edit' && $this->isAdmin) {
            if (F::isPost('submit_topic_publish')) {
                $oTournamentRules->setRulesSource(F::GetRequestStr('topic_text'));
                $oTournamentRules->setRulesText(E::ModuleText()->Parser(F::GetRequestStr('topic_text')));
                $oTournamentRules->Save();
            }
            $this->SetTemplateAction('tournament_rules_edit');
        } else {
            $this->SetTemplateAction('tournament_rules');
        }

    }

    protected function EventEvents()
    {

    }

    protected function EventAdmin()
    {
        $this->sMenuSubItemSelect = "admin";
        E::ModuleViewer()->AddHtmlTitle('Admin');

        $this->SetTemplateAction('tournament_admin');

        if ($this->isAdmin) {
            $this->SetTemplateAction('tournament_admin');
        } else {
            return R::Action('error');
        }
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
}

?>
