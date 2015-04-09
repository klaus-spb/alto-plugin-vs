<?php

class PluginVs_ActionAjax extends PluginVs_Inherit_ActionAjax
{


    public function Init()
    {
        parent::Init();
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEventPreg('/^admins$/i', '/^tournament$/', 'EventAdminsTournament');
    }

    protected function EventAdminsTournament()
    {

        $this->Viewer_AssignAjax('sText', '123');

        $oViewer = $this->Viewer_GetLocalViewer();

        if (func_check(getRequest('tournament', null, 'post'), 'id', 1, 11)) $tournament_id = getRequest('tournament', null, 'post');

        $oTournament = E::Module('PluginVs\Vs')->GetTournamentByTournamentId($tournament_id);

        $aFilter = array(
            'topic_publish' => 1,
            'blog_id' => $oTournament->getBlogId(),
        );
        $aTopics = $this->Topic_GetTopicsByFilter($aFilter);

        $aLeagues = E::Module('PluginVs\Vs')->GetLeagueItemsByFilter(array(
            'name <>' => ''
        ));

        $aFields = E::Module('PluginVs\Vs')->GetConfigTableItemsByFilter(array(
            'table' => 'tournament',
            'system' => '0'
        ));

        $oViewer->Assign('aLeagues', $aLeagues);
        $oViewer->Assign('aFields', $aFields);
        $oViewer->Assign('oTournament', $oTournament);
        $oViewer->Assign('aTopics', $aTopics['collection']);

        if (in_array($this->oUserCurrent->getUserId(), Config::Get('plugin.vs.super_admins'))) {
            $oViewer->Assign('bIsSuperAdmin', true);
        }
        $sTextResult = $oViewer->Fetch(Plugin::GetTemplateDir(__CLASS__) . "tpls/admins/tournament.tpl");
        $this->Viewer_AssignAjax('sText', $sTextResult);

    }
}