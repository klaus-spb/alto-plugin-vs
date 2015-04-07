{extends file="_index.tpl"}
{block name="layout_vars"}
    {$noSidebar=true}
    {$menu="tournament"}
{/block}

{block name="layout_content"}
    <div class="">
        <ul class="nav nav-pills">
            <li><strong></strong><a href="#" id="block_stream_topic"
                                    onclick="ls.au.toggle(this,'tournament', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.event_au}</a>
            </li>
            <li><a href="#" id="link_teams"
                   onclick="ls.au.toggle(this,'teams', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.teams}</a>
            </li>
            {*<li><a href="#" id="link_players" onclick="ls.au.toggle(this,'players', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.players}</a></li>
            *}
            <li><a href="#" id="link_playoff"
                   onclick="ls.au.toggle(this,'playoff', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.playoff}</a><em></em>
            </li>
            <li><a href="#" id="link_group"
                   onclick="ls.au.toggle(this,'group', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.groups}</a><em></em>
            </li>
            <li><a href="#" id="link_raspisanie"
                   onclick="ls.au.toggle(this,'raspisanie', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.schelude}</a><em></em>
            </li>
            <li><a href="#" id="link_penalty"
                   onclick="ls.au.toggle(this,'penalty', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.Penalty}</a><em></em>
            </li>
            <li><a href="#" id="link_award"
                   onclick="ls.au.toggle(this,'award', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.Awards}</a><em></em>
            </li>
            <li><a href="#" id="link_event"
                   onclick="ls.au.toggle(this,'event', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">{$aLang.plugin.vs.Events}</a><em></em>
            </li>

        </ul>

        <div class="block-content" id="div_au">
        </div>
    </div>
{literal}
    <script type="text/javascript">

    function SendFormSchedule() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['date1'] = $('#id-date-picker-1').val();
        params['date2'] = $('#id-date-picker-2').val();
        params['date3'] = $('#id-date-picker-3').val();
        params['date4'] = $('#id-date-picker-4').val();
        params['date5'] = $('#id-date-picker-5').val();
        params['date6'] = $('#id-date-picker-6').val();
        params['date7'] = $('#id-date-picker-7').val();
        if ($('#sparenno').is(':checked')) {
            params['sparenno'] = 1;
        } else {
            params['sparenno'] = 0;
        }
        params['obratka'] = $('#obratka').val();
        params['parentgroup_id'] = $('#parentgroup_id').val();
        params['group_id'] = $('#group_id').val();
        params['round_id'] = $('#round_id').val();
        ls.ajax(aRouter['ajax'] + 'au/createshedule/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Done', ' ');
                ls.au.toggle($('link_raspisanie'), 'raspisanie', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });

    }
    function update_ratings(team_id, what, el) {

        var params = {};

        params['team_id'] = team_id;
        params['what'] = what;
        params['val'] = $(el).val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/update_ratings/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
            }
        });

    }
    function update_tournament() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['known_teams'] = $('#known_teams').val();
        params['league_name'] = $('#league_name').val();
        params['league_pass'] = $('#league_pass').val();
        params['datezayavki'] = $('#datezayavki').val();
        params['datestart'] = $('#datestart').val();
        params['dateopenrasp'] = $('#dateopenrasp').val();
        params['win'] = $('#win').val();
        params['lose'] = $('#lose').val();
        if ($('#exist_o').is(':checked')) {
            params['exist_o'] = 1;
        } else {
            params['exist_o'] = 0;
        }
        params['win_o'] = $('#win_o').val();
        params['lose_o'] = $('#lose_o').val();
        if ($('#exist_b').is(':checked')) {
            params['exist_b'] = 1;
        } else {
            params['exist_b'] = 0;
        }
        params['win_b'] = $('#win_b').val();
        params['lose_b'] = $('#lose_b').val();
        params['penalty_stay'] = $('#penalty_stay').val();
        if ($('#exist_n').is(':checked')) {
            params['exist_n'] = 1;
        } else {
            params['exist_n'] = 0;
        }
        params['points_n'] = $('#points_n').val();
        if ($('#exist_yard').is(':checked')) {
            params['exist_yard'] = 1;
        } else {
            params['exist_yard'] = 0;
        }
        if ($('#zakryto').is(':checked')) {
            params['zakryto'] = 1;
        } else {
            params['zakryto'] = 0;
        }
        params['goals_teh_w'] = $('#goals_teh_w').val();
        params['goals_teh_l'] = $('#goals_teh_l').val();
        params['goals_teh_n'] = $('#goals_teh_n').val();
        if ($('#zavershen').is(':checked')) {
            params['zavershen'] = 1;
        } else {
            params['zavershen'] = 0;
        }
        if ($('#autosubmit').is(':checked')) {
            params['autosubmit'] = 1;
        } else {
            params['autosubmit'] = 0;
        }
        params['submithours'] = $('#submithours').val();
        params['prodlenie'] = $('#prodlenie').val();
        params['waitlist'] = $('#waitlist').val();
        params['prolong'] = $('#prolong').val();

        if ($('#show_full_stat_table').is(':checked')) {
            params['show_full_stat_table'] = 1;
        } else {
            params['show_full_stat_table'] = 0;
        }
        if ($('#show_parent_stat_table').is(':checked')) {
            params['show_parent_stat_table'] = 1;
        } else {
            params['show_parent_stat_table'] = 0;
        }
        if ($('#show_group_stat_table').is(':checked')) {
            params['show_group_stat_table'] = 1;
        } else {
            params['show_group_stat_table'] = 0;
        }
        if ($('#rating_lfrm').is(':checked')) {
            params['rating_lfrm'] = 1;
        } else {
            params['rating_lfrm'] = 0;
        }

        params['vznos'] = $('#vznos').val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/update_tournament/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
            }
        });
    }

    function upload_logo(logo_type) {
        //var params = new FormData($('#form_'+logo_type));
        //alert($('#form_'+logo_type).serialize());
        ls.ajaxSubmit(aRouter['ajax'] + 'au/upload_logo/', 'form_' + logo_type, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
                ls.au.toggle($('link_teams'), 'tournament', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });

            }
        });
    }

    function delete_logo(logo_type) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        params['logo_type'] = logo_type;
        ls.ajax(aRouter['ajax'] + 'au/delete_logo/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
                ls.au.toggle($('link_teams'), 'tournament', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });

            }
        });

    }

    function update_tournament_stat() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/tournamentrating/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Пересчитали', ' ');
            }
        });

    }

    function update_stattable(num) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round_id'] = $('#round_id').val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        if (params['round_id'] != 99999) {
            ls.ajax(aRouter['ajax'] + 'au/update_stattable/', params, function (result) {
                if (!result) {
                    ls.msg.error('Error', 'Please try again later');
                }
                if (result.bStateError) {
                    ls.msg.error(result.sMsgTitle, result.sMsg);
                } else {
                    ls.msg.notice('Пересчитали', ' ');
                }
            });

        }
    }
    function get_zayavki(tournament_id, user_id) {
        $('#zayavka').html('<img src="' + DIR_STATIC_SKIN + '/images/loader.gif" >');
        var params = {};
        params['tournament_id'] = tournament_id;
        params['user_id'] = user_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/zayavki/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                $('#zayavka').html(result.sText);
            }
        });

    }
    function get_change(tournament_id, user_id) {
        $('#zayavka').html('<img src="' + DIR_STATIC_SKIN + '/images/loader.gif" >');
        var params = {};
        params['tournament_id'] = tournament_id;
        params['user_id'] = user_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/change/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                $('#zayavka').html(result.sText);
            }
        });
    }

    function set_team(tournament_id, user_id, team_id) {
        //lsAU.toggle(this,'teams', { tournament: {/literal}{$oTournament->getTournamentId()} {literal}});

        var params = {};
        params['tournament_id'] = tournament_id;
        params['user_id'] = user_id;
        params['team_id'] = team_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/setteam/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'teams', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function add_player() {
        var params = {};
        params['user_login'] = $('#user').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/addplayer/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'teams', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function add_player_penalty() {
        var params = {};
        params['user_login'] = $('#user').val();
        params['why'] = $('#why').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/addplayerpenalty/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_penalty'), 'penalty', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function save_player_penalty() {
        var params = {};
        params['user_login'] = $('#user').val();
        params['why'] = $('#why').val();
        params['penalty_id'] = $('#penalty_id').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/saveplayerpenalty/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_penalty'), 'penalty', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }
    function delete_player_penalty(penalty_id) {
        var params = {};
        params['penalty_id'] = penalty_id;
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/deleteplayerpenalty/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_penalty'), 'penalty', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function edit_player_penalty(penalty_id) {
        ls.au.toggle($('link_penalty'), 'penalty', {
            {/literal}
            tournament: {$oTournament->getTournamentId()},
            penalty_id: penalty_id {literal}
        });
    }

    function add_award() {
        var params = {};
        params['medal_text'] = $('#medal_text').val();
        params['medal_link'] = $('#medal_link').val();
        params['teams'] = $('#teams').val();
        params['users'] = $('#users').val();
        params['playercards'] = $('#playercards').val();
        params['medal'] = $('#medal').val();
        params['weight'] = $('#weight').val();
        params['prise'] = $('#prise').val();

        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/addaward/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_award'), 'award', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function save_award() {
        var params = {};
        params['medal_text'] = $('#medal_text').val();
        params['medal_link'] = $('#medal_link').val();
        params['teams'] = $('#teams').val();
        params['users'] = $('#users').val();
        params['playercards'] = $('#playercards').val();
        params['medal'] = $('#medal').val();
        params['weight'] = $('#weight').val();
        params['prise'] = $('#prise').val();

        params['medal_id'] = $('#medal_id').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/saveaward/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_award'), 'award', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }
    function delete_award(medal_id) {
        var params = {};
        params['medal_id'] = medal_id;
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/deleteaward/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_award'), 'award', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function edit_award(medal_id) {
        ls.au.toggle($('link_award'), 'award', {
            {/literal}
            tournament: {$oTournament->getTournamentId()},
            medal_id: medal_id {literal}
        });
    }

    function add_event() {
        var params = {};
        params['event_name'] = $('#event_name').val();
        params['event_date'] = $('#event_date').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/addevent/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_event'), 'event', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function edit_event() {
        var params = {};
        params['event_id'] = $('#event_edit_id').val();
        params['event_name'] = $('#event_edit_name').val();
        params['event_date'] = $('#event_edit_date').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/editevent/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_event'), 'event', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function calc_event() {
        var params = {};
        params['event_id'] = $('#event_edit_id').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/calcevent/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice(result.sMsgTitle, result.sMsg);
                ls.au.toggle($('link_event'), 'event', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function delete_event() {
        var params = {};
        params['event_id'] = $('#event_edit_id').val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/deleteevent/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice(result.sMsgTitle, result.sMsg);
                ls.au.toggle($('link_event'), 'event', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function add_team(round_id, team) {
        var params = {};
        params['team'] = $('#' + team).val();
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        params['round_id'] = round_id;
        ls.ajax(aRouter['ajax'] + 'au/addteam/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'group', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }
    function delete_teamtournament(teamtournament) {
        var params = {};
        params['tournament_id'] = {/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        params['teamtournament_id'] = teamtournament;
        ls.ajax(aRouter['ajax'] + 'au/deleteteamtournament/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_group'), 'group', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function tehnarim() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'match/teh_massovo/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
                //ls.au.toggle($('link_teams'),'group', {{/literal} tournament: {$oTournament->getTournamentId()} {literal}});
            }
        });
    }
    function annulim() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'match/anul_massovo/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
                //ls.au.toggle($('link_teams'),'group', {{/literal} tournament: {$oTournament->getTournamentId()} {literal}});
            }
        });
    }
    function delete_team(tournament_id, user_id, team_id) {
        //lsAU.toggle(this,'teams', { tournament: {/literal}{$oTournament->getTournamentId()} {literal}});

        var params = {};
        params['tournament_id'] = tournament_id;
        params['user_id'] = user_id;
        params['team_id'] = team_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;


        ls.ajax(aRouter['ajax'] + 'au/deleteteam/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'teams', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });

    }
    function change_team(tournament_id, user_id, user2_id) {
        //lsAU.toggle(this,'teams', { tournament: {/literal}{$oTournament->getTournamentId()} {literal}});

        var params = {};
        params['tournament_id'] = tournament_id;
        params['user_id'] = user_id;
        params['user2_id'] = user2_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/changeteam/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'teams', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });

    }
    function delete_alone_teams() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/delete_alone_teams/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_teams'), 'teams', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });

    }
    function save_tournament() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()}{literal};
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/zayavki/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                $('#zayavka').html(result.sText);
            }
        });

    }
    function createround() {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round'] = $('#add_round').val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        if (params['round'] > 0) {
            ls.ajax(aRouter['ajax'] + 'au/createround/', params, function (result) {
                if (!result) {
                    ls.msg.error('Error', 'Please try again later');
                }
                if (result.bStateError) {
                    ls.msg.error(result.sMsgTitle, result.sMsg);
                } else {
                    ls.au.toggle($('link_playoff'), 'playoff', {
                        {/literal}
                        tournament: {$oTournament->getTournamentId()} {literal}
                    });
                }
            });

        }
    }

    function deleteround(round_po) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round'] = round_po;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        if (params['round'] > 0) {
            ls.ajax(aRouter['ajax'] + 'au/deleteround/', params, function (result) {
                if (!result) {
                    ls.msg.error('Error', 'Please try again later');
                }
                if (result.bStateError) {
                    ls.msg.error(result.sMsgTitle, result.sMsg);
                } else {
                    ls.au.toggle($('link_playoff'), 'playoff', {
                        {/literal}
                        tournament: {$oTournament->getTournamentId()} {literal}
                    });
                }
            });

        }
    }


    function saveparentgroup(el, teamintournament_id, round_id) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['group_id'] = $('#' + el).val();
        params['teamintournament_id'] = teamintournament_id;
        params['round_id'] = round_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/setparentgroup/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
            }
        });
    }

    function savegroup(el, teamintournament_id, round_id) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['group_id'] = $('#' + el).val();
        params['teamintournament_id'] = teamintournament_id;
        params['round_id'] = round_id;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
        ls.ajax(aRouter['ajax'] + 'au/setgroup/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
            }
        });
    }

    function saveround(el) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round_num'] = el;
        params['teamintournament_id'] = $('#' + el).val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;


        ls.ajax(aRouter['ajax'] + 'au/saveround/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.msg.notice('Сохранено', ' ');
            }
        });

    }

    function createraspisanie(num) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round'] = num;
        params['start_day'] = $('#' + num + 'start_day').val();
        params['matches_in_day'] = $('#' + num + 'matches_in_day').val();
        params['matches_between_day'] = $('#' + num + 'matches_between_day').val();
        params['matches_to_win'] = $('#' + num + 'matches_to_win').val();
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/createraspisanie/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_playoff'), 'playoff', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });


    }

    function deleteraspisanie(num) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round'] = num;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/deleteraspisanie/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_playoff'), 'playoff', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }

    function deletenotplayed(num) {
        var params = {};
        params['tournament_id'] ={/literal}{$oTournament->getTournamentId()} {literal};
        params['round'] = num;
        params['security_ls_key'] = LIVESTREET_SECURITY_KEY;

        ls.ajax(aRouter['ajax'] + 'au/deletenotplayed/', params, function (result) {
            if (!result) {
                ls.msg.error('Error', 'Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle, result.sMsg);
            } else {
                ls.au.toggle($('link_playoff'), 'playoff', {
                    {/literal}
                    tournament: {$oTournament->getTournamentId()} {literal}
                });
            }
        });
    }


    window.addEventListener("load", function (e) {
                document.addEventListener('DOMNodeInserted', function (e) {

                            if ($('#allusers') && $('#secret').val() == 0) {
                                $("#allusers").tablesorter();
                                $('#secret').val(1);
                            }
                        },
                        false);
            },
            false);

    </script>
{/literal}
{/block}
