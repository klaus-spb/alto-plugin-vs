<?php

class PluginVs_ActionAdmin extends PluginVs_Inherits_ActionAdmin
{


    /**
     * Регистрация евентов
     */
    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEventPreg('/^ajax$/i', '/^check_field$/i', 'EventAjaxCheckField');

        $this->AddEvent('tournament', 'EventTournament');
        $this->AddEvent('config_table', 'EventConfigTable');

    }

    public function EventAjaxCheckField()
    {

        // * Устанавливаем формат ответа
        E::ModuleViewer()->SetResponseAjax('json');

        $sTableName = 'prefix_vs_' . F::StrUnderscore($this->GetPost('table'));
        $sFieldName = F::StrUnderscore($this->GetPost('field'));

        if (E::ModuleDatabase()->isFieldExists($sTableName, $sFieldName)) {
            E::ModuleMessage()->AddErrorSingle('such field exists', E::ModuleLang()->Get('attention'));
            return;
        }

    }

    /***********************************ConfigTable************************************/

    protected function EventConfigTable()
    {

        $this->sMainMenuItem = 'content';

        if ($this->GetParam(0) == 'add') {
            $this->_eventConfigTableEdit('add');
        } elseif ($this->GetParam(0) == 'edit') {
            $this->_eventConfigTableEdit('edit');
        } elseif ($this->GetParam(0) == 'delete') {
            $this->_eventConfigTableDelete();
        } else {
            $this->_eventConfigTableList();
        }
    }

    protected function _eventConfigTableEdit($sMode)
    {

        $this->_setTitle('ConfigTable ' . $this->GetParam(1));
        $this->SetTemplateAction('content/config_table_edit');
        E::ModuleViewer()->Assign('sMode', $sMode);

        if ($this->GetParam(0) == 'add' && F::isPost('submit_config_table_save')) {
            $this->SubmitAddConfigTable();
        }

        if ($this->GetParam(0) == 'edit') {
            if ($oConfigTableEdit = E::Module('PluginVs\Vs')->GetConfigTableByConfigTableId($this->GetParam(1))) {
                if (!F::isPost('submit_config_table_save')) {
                    $_REQUEST['config_table_id'] = $oConfigTableEdit->getConfigTableId();
                    $_REQUEST['table'] = $oConfigTableEdit->getTable();
                    $_REQUEST['field_name'] = $oConfigTableEdit->getFieldName();
                    $_REQUEST['field_description'] = $oConfigTableEdit->getFieldDescription();
                    $_REQUEST['field_type'] = $oConfigTableEdit->getFieldType();
                    $_REQUEST['field_options'] = $oConfigTableEdit->getFieldOptions();

                } else {
                    $this->SubmitEditConfigTable($oConfigTableEdit);
                }
                E::ModuleViewer()->Assign('oConfigTableEdit', $oConfigTableEdit);
            } else {
                E::ModuleMessage()->AddError('No such ConfigTable', E::ModuleLang()->Get('error'));
                $this->SetParam(0, null);
            }
        }
    }

    protected function SubmitAddConfigTable()
    {

        // * Проверяем корректность полей
        if (!$this->CheckConfigTableFields()) {
            return;
        }
        $sTableName = 'prefix_vs_' . F::StrUnderscore(F::GetRequest('table'));
        $sFieldName = F::StrUnderscore(F::GetRequest('field_name'));

        if (!E::ModuleDatabase()->isFieldExists($sTableName, $sFieldName)) {

            // * Заполняем свойства
            $oConfigTable = E::GetEntity('PluginVs_ModuleVs_EntityConfigTable');
            $oConfigTable->setConfigTableId(F::GetRequest('config_table_id'));
            $oConfigTable->setTable(F::GetRequest('table'));
            $oConfigTable->setFieldName(F::GetRequest('field_name'));
            $oConfigTable->setFieldDescription(F::GetRequest('field_description'));
            $oConfigTable->setFieldType(F::GetRequest('field_type'));
            $oConfigTable->setFieldOptions(F::GetRequest('field_options'));
            $oConfigTable->setDefaultValue(F::GetRequest('default_value'));
            $oConfigTable->setNullEnabled(F::GetRequest('null_enabled') ? 1 : 0);
        }
        $sFieldType = Config::Get('plugin.vs.field_types')[F::GetRequest('field_type')];
        /**
         * Добавляем страницу
         */
        if ($oConfigTable->Add()) {
            E::ModuleDatabase()->AddField($sTableName, $sFieldName, $sFieldType, F::GetRequest('default_value'), F::GetRequest('null_enabled') ? 1 : 0, $sAdditional = '', $aConfig = null);

            E::ModuleMessage()->AddNotice('Ok');
            $this->SetParam(0, null);
            R::Location('admin/config_table/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }

    /**
     * Проверка полей на корректность
     *
     * @return bool
     */
    protected function CheckConfigTableFields()
    {

        E::ModuleSecurity()->ValidateSendForm();

        $bOk = true;
        /*

        if (!F::CheckVal(F::GetRequest('config_table_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('table', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_name', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_description', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_type', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_options', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }
                        */

        E::ModuleHook()->Run('check_config_table_fields', array('bOk' => &$bOk));

        return $bOk;
    }

    protected function SubmitEditConfigTable($oConfigTableEdit)
    {

        // * Проверяем корректность полей
        if (!$this->CheckConfigTableFields()) {
            return;
        }

        $oConfigTableEdit->setFieldDescription(F::GetRequest('field_description'));


        // * Обновляем страницу
        if ($oConfigTableEdit->Save()) {
            R::Location('admin/config_table/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }

    protected function _eventConfigTableDelete()
    {

        if ($oConfigTable = E::Module('PluginVs\Vs')->GetConfigTableByConfigTableId($this->GetParam(1))) {
            $oConfigTable->Delete();
            $this->Message_AddNotice('Deleted', true);
            R::Location('admin/config_table/');
        } else {
            $this->Message_AddError(
                'Something wrong', $this->Lang_Get('error')
            );
        }

    }

    protected function _eventConfigTableList()
    {

        $this->_setTitle('ConfigTable');

        $nPage = $this->_getPageNum();
        $aConfigTable = E::Module('PluginVs\Vs')->GetConfigTableItemsByFilter(
            array(
                '#page' => 1,
                '#limit' => array(($nPage - 1) * Config::Get('admin.items_per_page'),
                    Config::Get('admin.items_per_page'))
            )
        );
        $aPaging = $this->Viewer_MakePaging(
            $aConfigTable['count'], $nPage, Config::Get('admin.items_per_page'), 4,
            Router::GetPath('admin') . 'config_table/'
        );

        E::ModuleViewer()->Assign('aConfigTable', $aConfigTable['collection']);
        E::ModuleViewer()->Assign('aPaging', $aPaging);


        $this->SetTemplateAction('content/config_table_list');
    }


    /***********************************ConfigTable************************************/

    /***********************************Tournament************************************/

    protected function EventTournament()
    {

        $this->sMainMenuItem = 'content';

        if ($this->GetParam(0) == 'add') {
            $this->_eventTournamentEdit('add');
        } elseif ($this->GetParam(0) == 'edit') {
            $this->_eventTournamentEdit('edit');
        } elseif ($this->GetParam(0) == 'delete') {
            $this->_eventTournamentDelete();
        } else {
            $this->_eventTournamentList();
        }
    }

    protected function _eventTournamentEdit($sMode)
    {

        $this->_setTitle('Tournament ' . $this->GetParam(1));
        $this->SetTemplateAction('content/tournament_edit');
        E::ModuleViewer()->Assign('sMode', $sMode);

        $aGames = E::Module('PluginVs\Vs')->GetGameItemsAll();
        $aTournamentTypes = E::Module('PluginVs\Vs')->GetTournamentTypeItemsAll();
        $aPlatforms = E::Module('PluginVs\Vs')->GetPlatformItemsAll();
        $aLeagues = E::Module('PluginVs\Vs')->GetLeagueItemsAll();

        E::ModuleViewer()->Assign('aGames', $aGames);
        E::ModuleViewer()->Assign('aTournamentTypes', $aTournamentTypes);
        E::ModuleViewer()->Assign('aPlatforms', $aPlatforms);
        E::ModuleViewer()->Assign('aLeagues', $aLeagues);

        $aResult = $this->Blog_GetBlogsByFilter(array('exclude_type' => 'personal'), array('blog_title' => 'asc'), 1, 500);
        $this->Viewer_Assign('aBlogs', $aResult['collection']);

        if ($this->GetParam(0) == 'add' && F::isPost('submit_tournament_save')) {
            $this->SubmitAddTournament();
        }

        if ($this->GetParam(0) == 'edit') {
            if ($oTournamentEdit = E::Module('PluginVs\Vs')->GetTournamentByTournamentId($this->GetParam(1))) {
                if (!F::isPost('submit_tournament_save')) {

                    $_REQUEST['tournament_id'] = $oTournamentEdit->getTournamentId();
                    $_REQUEST['game_id'] = $oTournamentEdit->getGameId();
                    $_REQUEST['platform_id'] = $oTournamentEdit->getPlatformId();
                    $_REQUEST['tournament_type_id'] = $oTournamentEdit->getTournamentTypeId();
                    $_REQUEST['league_id'] = $oTournamentEdit->getLeagueId();
                    $_REQUEST['blog_id'] = $oTournamentEdit->getBlogId();
                    $_REQUEST['name'] = $oTournamentEdit->getName();
                    $_REQUEST['brief'] = $oTournamentEdit->getBrief();
                    $_REQUEST['url'] = $oTournamentEdit->getUrl();

                } else {
                    $this->SubmitEditTournament($oTournamentEdit);
                }
                E::ModuleViewer()->Assign('oTournamentEdit', $oTournamentEdit);
            } else {
                E::ModuleMessage()->AddError('No such Tournament', E::ModuleLang()->Get('error'));
                $this->SetParam(0, null);
            }
        }
    }

    protected function SubmitAddTournament()
    {

        // * Проверяем корректность полей
        if (!$this->CheckTournamentFields()) {
            return;
        }
        // * Заполняем свойства
        $oTournament = E::GetEntity('PluginVs_ModuleVs_EntityTournament');
        $oTournament->setTournamentId(F::GetRequest('tournament_id'));
        $oTournament->setGameId(F::GetRequest('game_id'));
        $oTournament->setPlatformId(F::GetRequest('platform_id'));
        $oTournament->setTournamentTypeId(F::GetRequest('tournament_type_id'));
        $oTournament->setLeagueId(F::GetRequest('league_id'));
        $oTournament->setBlogId(F::GetRequest('blog_id'));
        $oTournament->setName(F::GetRequest('name'));
        $oTournament->setBrief(F::GetRequest('brief'));
        $oTournament->setUrl(F::GetRequest('url'));

        /**
         * Добавляем страницу
         */
        if ($oTournament->Add()) {
            E::ModuleMessage()->AddNotice('Ok');
            $this->SetParam(0, null);
            R::Location('admin/tournament/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }

    /**
     * Проверка полей на корректность
     *
     * @return bool
     */
    protected function CheckTournamentFields()
    {

        E::ModuleSecurity()->ValidateSendForm();

        $bOk = true;
        /*

        if (!F::CheckVal(F::GetRequest('tournament_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('game_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('gametype_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('league_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('blog_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('blog_url', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('name', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('brief', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('url', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('known_teams', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('league_name', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('league_pass', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('win', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('lose', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('win_o', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('lose_o', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('exist_o', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('win_b', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('lose_b', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('exist_b', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('points_n', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('penalty_stay', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('goals_teh_w', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('goals_teh_l', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('goals_teh_n', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('nichya', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('exist_n', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('zakryto', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('datestart', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('datezayavki', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('dateopenrasp', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('zavershen', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('autosubmit', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('submithours', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('prodlenie', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('waitlist_topic_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('prolong_topic_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('fond', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('vznos', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('vznos_dop', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('exist_yard', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('logo', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('topic_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('logo_small', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('logo_full', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('tournament_extra', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('site', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('ch_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('platform_id', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('enable_trades', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }
                                                                                                                        */

        E::ModuleHook()->Run('check_tournament_fields', array('bOk' => &$bOk));

        return $bOk;
    }

    protected function SubmitEditTournament($oTournamentEdit)
    {

        // * Проверяем корректность полей
        if (!$this->CheckTournamentFields()) {
            return;
        }
        $oTournamentEdit->setTournamentId(F::GetRequest('tournament_id'));
        $oTournamentEdit->setGameId(F::GetRequest('game_id'));
        $oTournamentEdit->setPlatformId(F::GetRequest('platform_id'));
        $oTournamentEdit->setTournamentTypeId(F::GetRequest('tournament_type_id'));
        $oTournamentEdit->setLeagueId(F::GetRequest('league_id'));
        $oTournamentEdit->setBlogId(F::GetRequest('blog_id'));
        $oTournamentEdit->setName(F::GetRequest('name'));
        $oTournamentEdit->setBrief(F::GetRequest('brief'));
        $oTournamentEdit->setUrl(F::GetRequest('url'));

        // * Обновляем страницу
        if ($oTournamentEdit->Save()) {
            R::Location('admin/tournament/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }

    protected function _eventTournamentDelete()
    {

        if ($oTournament = E::Module('PluginVs\Vs')->GetTournamentByTournamentId($this->GetParam(1))) {
            $oTournament->Delete();
            $this->Message_AddNotice('Deleted', true);
            R::Location('admin/tournament/');
        } else {
            $this->Message_AddError(
                'Something wrong', $this->Lang_Get('error')
            );
        }

    }

    protected function _eventTournamentList()
    {

        $this->_setTitle('Tournament');

        $nPage = $this->_getPageNum();
        $aTournament = E::Module('PluginVs\Vs')->GetTournamentItemsByFilter(
            array(
                '#page' => 1,
                '#limit' => array(($nPage - 1) * Config::Get('admin.items_per_page'),
                    Config::Get('admin.items_per_page'))
            )
        );
        $aPaging = $this->Viewer_MakePaging(
            $aTournament['count'], $nPage, Config::Get('admin.items_per_page'), 4,
            Router::GetPath('admin') . 'tournament/'
        );

        E::ModuleViewer()->Assign('aTournament', $aTournament['collection']);
        E::ModuleViewer()->Assign('aPaging', $aPaging);


        $this->SetTemplateAction('content/tournament_list');
    }


    /***********************************Tournament************************************/

}
