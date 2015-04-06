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

        $sTableName = Config::Get('db.table.prefix') . 'vs_' . F::StrUnderscore($this->GetPost('table'));
        $sFieldName = F::StrUnderscore($this->GetPost('field'));

        $aFields = E::Module('PluginVs\Vs')->ShowColumnsFromTable($sTableName);

        if (in_array($sFieldName, $aFields)) {
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
                    $_REQUEST['field_size'] = $oConfigTableEdit->getFieldSize();
                    $_REQUEST['value_default'] = $oConfigTableEdit->getValueDefault();
                    $_REQUEST['field_options'] = $oConfigTableEdit->getFieldOptions();
                    $_REQUEST['field_sort'] = $oConfigTableEdit->getFieldSort();
                    $_REQUEST['field_required'] = $oConfigTableEdit->getFieldRequired();

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


    protected function SubmitEditConfigTable($oConfigTableEdit)
    {

        // * Проверяем корректность полей
        if (!$this->CheckConfigTableFields()) {
            return;
        }
        $oConfigTableEdit->setConfigTableId(F::GetRequest('config_table_id'));
        $oConfigTableEdit->setTable(F::GetRequest('table'));
        $oConfigTableEdit->setFieldName(F::GetRequest('field_name'));
        $oConfigTableEdit->setFieldDescription(F::GetRequest('field_description'));
        $oConfigTableEdit->setFieldType(F::GetRequest('field_type'));
        $oConfigTableEdit->setFieldSize(F::GetRequest('field_size'));
        $oConfigTableEdit->setValueDefault(F::GetRequest('value_default'));
        $oConfigTableEdit->setFieldOptions(F::GetRequest('field_options'));
        $oConfigTableEdit->setFieldSort(F::GetRequest('field_sort'));
        $oConfigTableEdit->setFieldRequired(F::GetRequest('field_required'));

        // * Обновляем страницу
        if ($oConfigTableEdit->Save()) {
            R::Location('admin/config_table/');
        } else {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'));
        }
    }


    protected function SubmitAddConfigTable()
    {

        // * Проверяем корректность полей
        if (!$this->CheckConfigTableFields()) {
            return;
        }
        // * Заполняем свойства
        $oConfigTable = E::GetEntity('PluginVs_ModuleVs_EntityConfigTable');
        $oConfigTable->setConfigTableId(F::GetRequest('config_table_id'));
        $oConfigTable->setTable(F::GetRequest('table'));
        $oConfigTable->setFieldName(F::GetRequest('field_name'));
        $oConfigTable->setFieldDescription(F::GetRequest('field_description'));
        $oConfigTable->setFieldType(F::GetRequest('field_type'));
        $oConfigTable->setFieldSize(F::GetRequest('field_size'));
        $oConfigTable->setValueDefault(F::GetRequest('value_default'));
        $oConfigTable->setFieldOptions(F::GetRequest('field_options'));
        $oConfigTable->setFieldSort(F::GetRequest('field_sort'));
        $oConfigTable->setFieldRequired(F::GetRequest('field_required'));

        /**
         * Добавляем страницу
         */
        if ($oConfigTable->Add()) {
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

        if (!F::CheckVal(F::GetRequest('field_size', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('value_default', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_options', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_sort', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }

        if (!F::CheckVal(F::GetRequest('field_required', null, 'post'), 'text', 1, 50000)) {
            E::ModuleMessage()->AddError('Panic', E::ModuleLang()->Get('error'));
            $bOk = false;
        }
                        */

        E::ModuleHook()->Run('check_config_table_fields', array('bOk' => &$bOk));

        return $bOk;
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

        if ($this->GetParam(0) == 'add' && F::isPost('submit_tournament_save')) {
            $this->SubmitAddTournament();
        }

        if ($this->GetParam(0) == 'edit') {
            if ($oTournamentEdit = E::Module('PluginVs\Vs')->GetTournamentByTournamentId($this->GetParam(1))) {
                if (!F::isPost('submit_tournament_save')) {

                    $_REQUEST['tournament_id'] = $oTournamentEdit->getTournamentId();
                    $_REQUEST['game_id'] = $oTournamentEdit->getGameId();
                    $_REQUEST['gametype_id'] = $oTournamentEdit->getGametypeId();
                    $_REQUEST['league_id'] = $oTournamentEdit->getLeagueId();
                    $_REQUEST['blog_id'] = $oTournamentEdit->getBlogId();
                    $_REQUEST['blog_url'] = $oTournamentEdit->getBlogUrl();
                    $_REQUEST['name'] = $oTournamentEdit->getName();
                    $_REQUEST['brief'] = $oTournamentEdit->getBrief();
                    $_REQUEST['url'] = $oTournamentEdit->getUrl();
                    $_REQUEST['known_teams'] = $oTournamentEdit->getKnownTeams();
                    $_REQUEST['league_name'] = $oTournamentEdit->getLeagueName();
                    $_REQUEST['league_pass'] = $oTournamentEdit->getLeaguePass();
                    $_REQUEST['win'] = $oTournamentEdit->getWin();
                    $_REQUEST['lose'] = $oTournamentEdit->getLose();
                    $_REQUEST['win_o'] = $oTournamentEdit->getWinO();
                    $_REQUEST['lose_o'] = $oTournamentEdit->getLoseO();
                    $_REQUEST['exist_o'] = $oTournamentEdit->getExistO();
                    $_REQUEST['win_b'] = $oTournamentEdit->getWinB();
                    $_REQUEST['lose_b'] = $oTournamentEdit->getLoseB();
                    $_REQUEST['exist_b'] = $oTournamentEdit->getExistB();
                    $_REQUEST['points_n'] = $oTournamentEdit->getPointsN();
                    $_REQUEST['penalty_stay'] = $oTournamentEdit->getPenaltyStay();
                    $_REQUEST['goals_teh_w'] = $oTournamentEdit->getGoalsTehW();
                    $_REQUEST['goals_teh_l'] = $oTournamentEdit->getGoalsTehL();
                    $_REQUEST['goals_teh_n'] = $oTournamentEdit->getGoalsTehN();
                    $_REQUEST['nichya'] = $oTournamentEdit->getNichya();
                    $_REQUEST['exist_n'] = $oTournamentEdit->getExistN();
                    $_REQUEST['zakryto'] = $oTournamentEdit->getZakryto();
                    $_REQUEST['datestart'] = $oTournamentEdit->getDatestart();
                    $_REQUEST['datezayavki'] = $oTournamentEdit->getDatezayavki();
                    $_REQUEST['dateopenrasp'] = $oTournamentEdit->getDateopenrasp();
                    $_REQUEST['zavershen'] = $oTournamentEdit->getZavershen();
                    $_REQUEST['autosubmit'] = $oTournamentEdit->getAutosubmit();
                    $_REQUEST['submithours'] = $oTournamentEdit->getSubmithours();
                    $_REQUEST['prodlenie'] = $oTournamentEdit->getProdlenie();
                    $_REQUEST['waitlist_topic_id'] = $oTournamentEdit->getWaitlistTopicId();
                    $_REQUEST['prolong_topic_id'] = $oTournamentEdit->getProlongTopicId();
                    $_REQUEST['fond'] = $oTournamentEdit->getFond();
                    $_REQUEST['vznos'] = $oTournamentEdit->getVznos();
                    $_REQUEST['vznos_dop'] = $oTournamentEdit->getVznosDop();
                    $_REQUEST['exist_yard'] = $oTournamentEdit->getExistYard();
                    $_REQUEST['logo'] = $oTournamentEdit->getLogo();
                    $_REQUEST['topic_id'] = $oTournamentEdit->getTopicId();
                    $_REQUEST['logo_small'] = $oTournamentEdit->getLogoSmall();
                    $_REQUEST['logo_full'] = $oTournamentEdit->getLogoFull();
                    $_REQUEST['tournament_extra'] = $oTournamentEdit->getTournamentExtra();
                    $_REQUEST['site'] = $oTournamentEdit->getSite();
                    $_REQUEST['ch_id'] = $oTournamentEdit->getChId();
                    $_REQUEST['platform_id'] = $oTournamentEdit->getPlatformId();
                    $_REQUEST['enable_trades'] = $oTournamentEdit->getEnableTrades();

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
        $oTournament->setGametypeId(F::GetRequest('gametype_id'));
        $oTournament->setLeagueId(F::GetRequest('league_id'));
        $oTournament->setBlogId(F::GetRequest('blog_id'));
        $oTournament->setBlogUrl(F::GetRequest('blog_url'));
        $oTournament->setName(F::GetRequest('name'));
        $oTournament->setBrief(F::GetRequest('brief'));
        $oTournament->setUrl(F::GetRequest('url'));
        $oTournament->setKnownTeams(F::GetRequest('known_teams'));
        $oTournament->setLeagueName(F::GetRequest('league_name'));
        $oTournament->setLeaguePass(F::GetRequest('league_pass'));
        $oTournament->setWin(F::GetRequest('win'));
        $oTournament->setLose(F::GetRequest('lose'));
        $oTournament->setWinO(F::GetRequest('win_o'));
        $oTournament->setLoseO(F::GetRequest('lose_o'));
        $oTournament->setExistO(F::GetRequest('exist_o'));
        $oTournament->setWinB(F::GetRequest('win_b'));
        $oTournament->setLoseB(F::GetRequest('lose_b'));
        $oTournament->setExistB(F::GetRequest('exist_b'));
        $oTournament->setPointsN(F::GetRequest('points_n'));
        $oTournament->setPenaltyStay(F::GetRequest('penalty_stay'));
        $oTournament->setGoalsTehW(F::GetRequest('goals_teh_w'));
        $oTournament->setGoalsTehL(F::GetRequest('goals_teh_l'));
        $oTournament->setGoalsTehN(F::GetRequest('goals_teh_n'));
        $oTournament->setNichya(F::GetRequest('nichya'));
        $oTournament->setExistN(F::GetRequest('exist_n'));
        $oTournament->setZakryto(F::GetRequest('zakryto'));
        $oTournament->setDatestart(F::GetRequest('datestart'));
        $oTournament->setDatezayavki(F::GetRequest('datezayavki'));
        $oTournament->setDateopenrasp(F::GetRequest('dateopenrasp'));
        $oTournament->setZavershen(F::GetRequest('zavershen'));
        $oTournament->setAutosubmit(F::GetRequest('autosubmit'));
        $oTournament->setSubmithours(F::GetRequest('submithours'));
        $oTournament->setProdlenie(F::GetRequest('prodlenie'));
        $oTournament->setWaitlistTopicId(F::GetRequest('waitlist_topic_id'));
        $oTournament->setProlongTopicId(F::GetRequest('prolong_topic_id'));
        $oTournament->setFond(F::GetRequest('fond'));
        $oTournament->setVznos(F::GetRequest('vznos'));
        $oTournament->setVznosDop(F::GetRequest('vznos_dop'));
        $oTournament->setExistYard(F::GetRequest('exist_yard'));
        $oTournament->setLogo(F::GetRequest('logo'));
        $oTournament->setTopicId(F::GetRequest('topic_id'));
        $oTournament->setLogoSmall(F::GetRequest('logo_small'));
        $oTournament->setLogoFull(F::GetRequest('logo_full'));
        $oTournament->setTournamentExtra(F::GetRequest('tournament_extra'));
        $oTournament->setSite(F::GetRequest('site'));
        $oTournament->setChId(F::GetRequest('ch_id'));
        $oTournament->setPlatformId(F::GetRequest('platform_id'));
        $oTournament->setEnableTrades(F::GetRequest('enable_trades'));

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
        $oTournamentEdit->setGametypeId(F::GetRequest('gametype_id'));
        $oTournamentEdit->setLeagueId(F::GetRequest('league_id'));
        $oTournamentEdit->setBlogId(F::GetRequest('blog_id'));
        $oTournamentEdit->setBlogUrl(F::GetRequest('blog_url'));
        $oTournamentEdit->setName(F::GetRequest('name'));
        $oTournamentEdit->setBrief(F::GetRequest('brief'));
        $oTournamentEdit->setUrl(F::GetRequest('url'));
        $oTournamentEdit->setKnownTeams(F::GetRequest('known_teams'));
        $oTournamentEdit->setLeagueName(F::GetRequest('league_name'));
        $oTournamentEdit->setLeaguePass(F::GetRequest('league_pass'));
        $oTournamentEdit->setWin(F::GetRequest('win'));
        $oTournamentEdit->setLose(F::GetRequest('lose'));
        $oTournamentEdit->setWinO(F::GetRequest('win_o'));
        $oTournamentEdit->setLoseO(F::GetRequest('lose_o'));
        $oTournamentEdit->setExistO(F::GetRequest('exist_o'));
        $oTournamentEdit->setWinB(F::GetRequest('win_b'));
        $oTournamentEdit->setLoseB(F::GetRequest('lose_b'));
        $oTournamentEdit->setExistB(F::GetRequest('exist_b'));
        $oTournamentEdit->setPointsN(F::GetRequest('points_n'));
        $oTournamentEdit->setPenaltyStay(F::GetRequest('penalty_stay'));
        $oTournamentEdit->setGoalsTehW(F::GetRequest('goals_teh_w'));
        $oTournamentEdit->setGoalsTehL(F::GetRequest('goals_teh_l'));
        $oTournamentEdit->setGoalsTehN(F::GetRequest('goals_teh_n'));
        $oTournamentEdit->setNichya(F::GetRequest('nichya'));
        $oTournamentEdit->setExistN(F::GetRequest('exist_n'));
        $oTournamentEdit->setZakryto(F::GetRequest('zakryto'));
        $oTournamentEdit->setDatestart(F::GetRequest('datestart'));
        $oTournamentEdit->setDatezayavki(F::GetRequest('datezayavki'));
        $oTournamentEdit->setDateopenrasp(F::GetRequest('dateopenrasp'));
        $oTournamentEdit->setZavershen(F::GetRequest('zavershen'));
        $oTournamentEdit->setAutosubmit(F::GetRequest('autosubmit'));
        $oTournamentEdit->setSubmithours(F::GetRequest('submithours'));
        $oTournamentEdit->setProdlenie(F::GetRequest('prodlenie'));
        $oTournamentEdit->setWaitlistTopicId(F::GetRequest('waitlist_topic_id'));
        $oTournamentEdit->setProlongTopicId(F::GetRequest('prolong_topic_id'));
        $oTournamentEdit->setFond(F::GetRequest('fond'));
        $oTournamentEdit->setVznos(F::GetRequest('vznos'));
        $oTournamentEdit->setVznosDop(F::GetRequest('vznos_dop'));
        $oTournamentEdit->setExistYard(F::GetRequest('exist_yard'));
        $oTournamentEdit->setLogo(F::GetRequest('logo'));
        $oTournamentEdit->setTopicId(F::GetRequest('topic_id'));
        $oTournamentEdit->setLogoSmall(F::GetRequest('logo_small'));
        $oTournamentEdit->setLogoFull(F::GetRequest('logo_full'));
        $oTournamentEdit->setTournamentExtra(F::GetRequest('tournament_extra'));
        $oTournamentEdit->setSite(F::GetRequest('site'));
        $oTournamentEdit->setChId(F::GetRequest('ch_id'));
        $oTournamentEdit->setPlatformId(F::GetRequest('platform_id'));
        $oTournamentEdit->setEnableTrades(F::GetRequest('enable_trades'));

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
