
    {foreach $aFields as $oField}
        {include file="{Plugin::GetTemplateDir('Vs')}tpls/fields/custom/field.custom.`$oField->getFieldType()`-edit.tpl" oField=$oField oObject=$oTournament}

    {/foreach}



    {*
    <div class="form-group">
        <div class="input-group">
            <label class="input-group-addon" for="known_teams">Команды</label>
            <select name="known_teams" id="known_teams" onchange="update_tournament(); return false;" class="form-control">
                <OPTION value="0" {if $oTournament->getKnownTeams()==0}SELECTED{/if}>Команды не известны</OPTION>
                <OPTION value="1" {if $oTournament->getKnownTeams()==1}SELECTED{/if}>Команды известны</OPTION>
                <OPTION value="2" {if $oTournament->getKnownTeams()==2}SELECTED{/if}>Команды раздаются случайным образом
                </OPTION>
                <OPTION value="3" {if $oTournament->getKnownTeams()==3}SELECTED{/if}>Команды определяют игроки при внесении
                </OPTION>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Название лиги</span>
            <input type="text" name="league_name" id="league_name" value="{$oTournament->getLeagueName()}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Пароль лиги</span>
            <input type="text" name="league_pass" id="league_pass" value="{$oTournament->getLeaguePass()}" class="form-control">
        </div>
    </div>


    <div class="form-group">
        <div class="input-group">
            <label class="input-group-addon" for="waitlist">Лист ожидания</label>
            <select name="waitlist" id="waitlist" onchange="update_tournament(); return false;" class="form-control">
                <option value="0">-</option>
                {if $aTopics}
                    {foreach from=$aTopics item=oTopic name=el2}
                        <option value="{$oTopic->getTopicId()}"
                                {if $oTopic->getTopicId()== $oTournament->getWaitlistTopicId()}selected="selected"{/if}>{$oTopic->getTitle()}</option>
                    {/foreach}
                {/if}
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <label class="input-group-addon" for="prolongation">Топик продления</label>
            <select name="prolong" id="prolongation" onchange="update_tournament(); return false;" class="form-control">
                <option value="0">-</option>
                {if $aTopics}
                    {foreach from=$aTopics item=oTopic name=el2}
                        <option value="{$oTopic->getTopicId()}"
                                {if $oTopic->getTopicId()== $oTournament->getWaitlistTopicId()}selected="selected"{/if}>{$oTopic->getTitle()}</option>
                    {/foreach}
                {/if}
            </select>
        </div>
    </div>


    <div class="form-group">
        <div class="input-group charming-datepicker">
            <span class="input-group-addon">Дата старта</span>

            <div class="dropdown-menu"></div>
            <input class="date-picker form-control" data-toggle="dropdown" readonly="readonly"
                   name="date_start" id="date_start"
                   value="{$oTournament->getDateStart()|escape:'html'}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="input-group charming-datepicker">
            <span class="input-group-addon">Открыто расписание (включительно)</span>

            <div class="dropdown-menu"></div>
            <input class="date-picker form-control" data-toggle="dropdown" readonly="readonly"
                   name="date_open_schedule" id="date_open_schedule"
                   value="{$oTournament->getDateOpenSchedule()|escape:'html'}" class="form-control">
        </div>
    </div>


    <p>
        <input type="text" id="win" onchange="update_tournament(); return false;" value="{$oTournament->getWin()}" SIZE="4"
               maxlength="4"/> Очков за победу
    </p>

    <p>
        <input type="text" id="lose" onchange="update_tournament(); return false;" value="{$oTournament->getLose()}"
               SIZE="4" maxlength="4"/> Очков за поражение
    </p>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Возможен овертайм?</span>
            <input type="checkbox" id="exist_o" onchange="update_tournament(); return false;" class="checkbox" value="1"
            {if $oTournament->getExistO()}checked="yes"{/if} >
        </div>
    </div>

    <p>
        <input type="text" id="win_o" onchange="update_tournament(); return false;" value="{$oTournament->getWinO()}"
               SIZE="3" maxlength="3"/> Очков за победу в ОТ
    </p>

    <p>
        <input type="text" id="lose_o" onchange="update_tournament(); return false;" value="{$oTournament->getLoseO()}"
               SIZE="3" maxlength="3"/> Очков за поражение в ОТ
    </p>

    <p>
        <input type="checkbox" id="exist_b" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getExistB()}checked="yes"{/if} > Возможны буллиты?
    </p>

    <p>
        <input type="text" id="win_b" onchange="update_tournament(); return false;" value="{$oTournament->getWinB()}"
               SIZE="3" maxlength="3"/> Очков за победу по буллитам
    </p>

    <p>
        <input type="text" id="lose_b" onchange="update_tournament(); return false;" value="{$oTournament->getLoseB()}"
               SIZE="3" maxlength="3"/> Очков за поражение по буллитам
    </p>

    <p>
        <input type="text" id="penalty_stay" onchange="update_tournament(); return false;"
               value="{$oTournament->getPenaltyStay()}" SIZE="4" maxlength="4"/> Штраф за простой в боях (положительное
        число)
    </p>

    <p>
        <input type="checkbox" id="exist_n" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getExistN()}checked="yes"{/if} > Возможна ничья?
    </p>

    <p>
        <input type="text" id="points_n" onchange="update_tournament(); return false;" value="{$oTournament->getPointsN()}"
               SIZE="3" maxlength="3"/> Очков за ничью
    </p>

    <p>
        <input type="checkbox" id="zakryto" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getZakryto()}checked="yes"{/if} > Завершена подача заявок?
    </p>

    <p>
        <input type="text" id="goals_teh_w" onchange="update_tournament(); return false;"
               value="{$oTournament->getGoalsTehW()}" SIZE="3" maxlength="3"/> Голов в тех победе
    </p>

    <p>
        <input type="text" id="goals_teh_l" onchange="update_tournament(); return false;"
               value="{$oTournament->getGoalsTehL()}" SIZE="3" maxlength="3"/> Голов в тех поражении
    </p>

    <p>
        <input type="text" id="goals_teh_n" onchange="update_tournament(); return false;"
               value="{$oTournament->getGoalsTehN()}" SIZE="3" maxlength="3"/> Голов в тех ничьей
    </p>

    <p>
        <input type="checkbox" id="zavershen" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getZavershen()}checked="yes"{/if} > Турнир завершен?
    </p>

    <p>
        <input type="checkbox" id="autosubmit" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getAutosubmit()}checked="yes"{/if} > Вкл. автоподтверждение результата?
    </p>

    <p>
        <input type="checkbox" id="show_full_stat_table" onchange="update_tournament(); return false;" class="checkbox"
               value="1"
               {if $oTournament->getShowFullStatTable() || $oTournament->getShowFullStatTable()==null}checked="yes"{/if} >
        Показывать полную турнирную таблицу
    </p>

    <p>
        <input type="checkbox" id="show_parent_stat_table" onchange="update_tournament(); return false;" class="checkbox"
               value="1"
               {if $oTournament->getShowParentStatTable() || $oTournament->getShowParentStatTable()==null}checked="yes"{/if} >
        Показывать таблицы конференций
    </p>

    <p>
        <input type="checkbox" id="show_group_stat_table" onchange="update_tournament(); return false;" class="checkbox"
               value="1"
               {if $oTournament->getShowGroupStatTable() || $oTournament->getShowGroupStatTable()==null}checked="yes"{/if} >
        Показывать таблицы групп
    </p>

    <p>
        <input type="checkbox" id="rating_lfrm" onchange="update_tournament(); return false;" class="checkbox" value="1"
               {if $oTournament->getRatingLfrm()==1}checked="yes"{/if} > Рейтинг в таблице
    </p>

    <p>
        <input type="text" id="vznos" onchange="update_tournament(); return false;" value="{$oTournament->getVznos()}"
               SIZE="4" maxlength="4"/> Сумма взноса
    </p>

    <p>
        <input type="text" id="submithours" onchange="update_tournament(); return false;"
               value="{$oTournament->getSubmithours()}" SIZE="3" maxlength="3"/> Через сколько часов подтверждать?
    </p>

    <p><select class="w200" id="prodlenie" onchange="update_tournament(); return false;">
            <OPTION value="">-</OPTION>
            <OPTION value="weeks" {if $oTournament->getProdlenie()=='weeks'}SELECTED{/if}>Продлеваем неделями</OPTION>
            <OPTION value="days" {if $oTournament->getKnownTeams()=='days'}SELECTED{/if}>Продлеваем днями</OPTION>
        </select>
    </p>


    <br/>
    *}
Пересчитать турнирку за раунд
<select class="w200" id="round_id" onchange="update_stattable(); return false;">
    <OPTION value="99999">-</OPTION>
    {foreach from=$aRound item=oRound name=el2}
        <OPTION value="{$oRound->getRoundId()}">{$oRound->getBrief()}</OPTION>
    {/foreach}
</select>
{if $bIsSuperAdmin}
    <br/>
    Команды лиги
    <select class="w200" id="league_id">
        {foreach from=$aLeagues item=oLeague name=el2}
            <OPTION value="{$oLeague->getLeagueId()}">{$oLeague->getName()} ({$oLeague->getBrief()})</OPTION>
        {/foreach}

    </select>
    <a href="#" id=""
       onclick="ls.au.simple_toggles(this,'setteams', {literal}{{/literal} tournament: {$oTournament->getTournamentId()}, league:$('#league_id').val() {literal}}{/literal}); return false;">Добавить
        команды</a>

{/if}
    {*
    <p>
        <label for="tournament_small_logo">Загрузить маленькое лого (32x32):</label>

        <form method="post" id="form_small_logo" enctype="multipart/form-data">
        <input type="file" name="tournament_small_logo" id="tournament_small_logo" class="input-text"
               onchange="upload_logo('small_logo'); return false;"/>
        <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}">
        <input type="hidden" name="tournament_id" value="{$oTournament->getTournamentId()}">
        <input type="hidden" name="logo_type" value="small_logo">
    </form>
    <div id="brand_box_image">
        {if $oTournament->getLogoSmall()}
            <br/>
            <a href="{$oTournament->getLogoSmall()}" rel="[photoset]" title="" class="photoset-image"><img
                        src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"
                        alt="" width="32"/></a>
            <label><input onchange="delete_logo('small_logo'); return false;" type="checkbox"
                          id="tournament_small_logo_delete" name="tournament_small_logo_delete" value="on"
                          class="input-checkbox"> Удалить маленький лого</label>
        {/if}
    </div>
    </p>
    <p>
        <label for="tournament_full_logo">Загрузить Большое лого (200x200):</label>

        <form method="post" id="form_full_logo" enctype="multipart/form-data">
        <input type="file" name="tournament_full_logo" id="tournament_full_logo" class="input-text"
               onchange="upload_logo('full_logo'); return false;"/>
        <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}">
        <input type="hidden" name="tournament_id" value="{$oTournament->getTournamentId()}">
        <input type="hidden" name="logo_type" value="full_logo">
    </form>
    <div id="brand_box_image">
        {if $oTournament->getLogoFull()}
            <br/>
            <a href="{$oTournament->getLogoFull()}" rel="[photoset]" title="" class="photoset-image"><img
                        src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoFull()}"
                        alt=""/></a>
            <label><input onchange="delete_logo('small_logo'); return false;" type="checkbox"
                          id="tournament_full_logo_delete" name="tournament_full_logo_delete" value="on"
                          class="input-checkbox"> Удалить большое лого</label>
        {/if}
    </div>
    </p>

    *}