<?php

class PluginVs_ActionAjax extends PluginVs_Inherit_ActionAjax
{
    protected $oUserCurrent = null;

    public function Init()
    {
        parent::Init();
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEventPreg('/^admins$/i', '/^tournament$/', 'EventAdminsTournament');
        $this->AddEventPreg('/^admins$/i', '/^update_tournament$/', 'EventUpdateTournament');
    }

    protected function EventUpdateTournament()
    {
        if (F::CheckVal(F::GetRequest('tournament_id', null, 'post'), 'id', 1, 11)) $tournament_id = F::GetRequest('tournament_id', null, 'post');


        if ($oTournament = E::Module('PluginVs\Vs')->GetTournamentByTournamentId($tournament_id)) {

            $aFields = E::Module('PluginVs\Vs')->GetConfigTableItemsByFilter(array(
                'table_name' => 'tournament',
                'system' => '0'
            ));

            foreach ($aFields as $oField) {
                $value = strip_tags(F::GetRequest($oField->getFieldName(), null, 'post'));
                if ($oField->getFieldType() == 'date') {
                    list($d, $m, $y) = explode('.', $value);
                    if (@checkdate($m, $d, $y)) {
                        $value = $y . '-' . $m . '-' . $d;
                    }
                }
                $oTournament->setProp($oField->getFieldName(), $value);
            }


            $oTournament->Save();
        }

    }

    protected function EventAdminsTournament()
    {

        $this->Viewer_AssignAjax('sText', '123');

        $oViewer = $this->Viewer_GetLocalViewer();

        if (F::CheckVal(F::GetRequest('tournament', null, 'post'), 'id', 1, 11)) $tournament_id = F::GetRequest('tournament', null, 'post');

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
            'table_name' => 'tournament',
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