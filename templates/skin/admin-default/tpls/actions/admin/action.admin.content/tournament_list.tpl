{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}tournament/add/" class="btn btn-primary"><i class="icon icon-plus"></i></a>
    </div>
{/block}

{block name="content-body"}
    <div class="span12">

    <div class="b-wbox">
        <div class="b-wbox-content nopadding">

            <table class="table table-striped table-condensed pages-list">
                <thead>
                <tr>

                    <th>tournament_id</th>
                    <th>game_id</th>
                    <th>gametype_id</th>
                    <th>league_id</th>
                    <th>blog_id</th>
                    <th>blog_url</th>
                    <th>name</th>
                    <th>brief</th>
                    <th>url</th>
                    <th>known_teams</th>
                    <th>league_name</th>
                    <th>league_pass</th>
                    <th>win</th>
                    <th>lose</th>
                    <th>win_o</th>
                    <th>lose_o</th>
                    <th>exist_o</th>
                    <th>win_b</th>
                    <th>lose_b</th>
                    <th>exist_b</th>
                    <th>points_n</th>
                    <th>penalty_stay</th>
                    <th>goals_teh_w</th>
                    <th>goals_teh_l</th>
                    <th>goals_teh_n</th>
                    <th>nichya</th>
                    <th>exist_n</th>
                    <th>zakryto</th>
                    <th>datestart</th>
                    <th>datezayavki</th>
                    <th>dateopenrasp</th>
                    <th>zavershen</th>
                    <th>autosubmit</th>
                    <th>submithours</th>
                    <th>prodlenie</th>
                    <th>waitlist_topic_id</th>
                    <th>prolong_topic_id</th>
                    <th>fond</th>
                    <th>vznos</th>
                    <th>vznos_dop</th>
                    <th>exist_yard</th>
                    <th>logo</th>
                    <th>topic_id</th>
                    <th>logo_small</th>
                    <th>logo_full</th>
                    <th>tournament_extra</th>
                    <th>site</th>
                    <th>ch_id</th>
                    <th>platform_id</th>
                    <th>enable_trades</th>
                    <th>game</th>
                    <th>game_type</th>
                    <th>blog</th>
                    <th>waitlist</th>
                    <th>prolong</th>
                    <th>gametype</th>

                </tr>
                </thead>

                <tbody>
                {foreach $aTournament as $oTournament}
                    <tr>

                        <td>                        {$oTournament->getTournamentId()}
                        </td>
                        <td>                        {$oTournament->getGameId()}
                        </td>
                        <td>                        {$oTournament->getGametypeId()}
                        </td>
                        <td>                        {$oTournament->getLeagueId()}
                        </td>
                        <td>                        {$oTournament->getBlogId()}
                        </td>
                        <td>                        {$oTournament->getBlogUrl()}
                        </td>
                        <td>                        {$oTournament->getName()}
                        </td>
                        <td>                        {$oTournament->getBrief()}
                        </td>
                        <td>                        {$oTournament->getUrl()}
                        </td>
                        <td>                        {$oTournament->getKnownTeams()}
                        </td>
                        <td>                        {$oTournament->getLeagueName()}
                        </td>
                        <td>                        {$oTournament->getLeaguePass()}
                        </td>
                        <td>                        {$oTournament->getWin()}
                        </td>
                        <td>                        {$oTournament->getLose()}
                        </td>
                        <td>                        {$oTournament->getWinO()}
                        </td>
                        <td>                        {$oTournament->getLoseO()}
                        </td>
                        <td>                        {$oTournament->getExistO()}
                        </td>
                        <td>                        {$oTournament->getWinB()}
                        </td>
                        <td>                        {$oTournament->getLoseB()}
                        </td>
                        <td>                        {$oTournament->getExistB()}
                        </td>
                        <td>                        {$oTournament->getPointsN()}
                        </td>
                        <td>                        {$oTournament->getPenaltyStay()}
                        </td>
                        <td>                        {$oTournament->getGoalsTehW()}
                        </td>
                        <td>                        {$oTournament->getGoalsTehL()}
                        </td>
                        <td>                        {$oTournament->getGoalsTehN()}
                        </td>
                        <td>                        {$oTournament->getNichya()}
                        </td>
                        <td>                        {$oTournament->getExistN()}
                        </td>
                        <td>                        {$oTournament->getZakryto()}
                        </td>
                        <td>                        {$oTournament->getDatestart()}
                        </td>
                        <td>                        {$oTournament->getDatezayavki()}
                        </td>
                        <td>                        {$oTournament->getDateopenrasp()}
                        </td>
                        <td>                        {$oTournament->getZavershen()}
                        </td>
                        <td>                        {$oTournament->getAutosubmit()}
                        </td>
                        <td>                        {$oTournament->getSubmithours()}
                        </td>
                        <td>                        {$oTournament->getProdlenie()}
                        </td>
                        <td>                        {$oTournament->getWaitlistTopicId()}
                        </td>
                        <td>                        {$oTournament->getProlongTopicId()}
                        </td>
                        <td>                        {$oTournament->getFond()}
                        </td>
                        <td>                        {$oTournament->getVznos()}
                        </td>
                        <td>                        {$oTournament->getVznosDop()}
                        </td>
                        <td>                        {$oTournament->getExistYard()}
                        </td>
                        <td>                        {$oTournament->getLogo()}
                        </td>
                        <td>                        {$oTournament->getTopicId()}
                        </td>
                        <td>                        {$oTournament->getLogoSmall()}
                        </td>
                        <td>                        {$oTournament->getLogoFull()}
                        </td>
                        <td>                        {$oTournament->getTournamentExtra()}
                        </td>
                        <td>                        {$oTournament->getSite()}
                        </td>
                        <td>                        {$oTournament->getChId()}
                        </td>
                        <td>                        {$oTournament->getPlatformId()}
                        </td>
                        <td>                        {$oTournament->getEnableTrades()}
                        </td>
                        <td>{if $oTournament->getGame()}                        {$oTournament->getGame()->getGameId()}
                            {/if}                        </td>
                        <td>{if $oTournament->getGameType()}                        {$oTournament->getGameType()->getGameTypeId()}
                            {/if}                        </td>
                        <td>{if $oTournament->getBlog()}                        {$oTournament->getBlog()->getBlogId()}
                            {/if}                        </td>
                        <td>{if $oTournament->getWaitlist()}                        {$oTournament->getWaitlist()->getWaitlistTopicId()}
                            {/if}                        </td>
                        <td>{if $oTournament->getProlong()}                        {$oTournament->getProlong()->getProlongTopicId()}
                            {/if}                        </td>
                        <td>{if $oTournament->getGametype()}                        {$oTournament->getGametype()->getGametypeId()}
                            {/if}                        </td>

                        <td class="center">
                            <a href="{router page='admin'}tournament/edit/{$oTournament->getTournamentId()}/"
                               title="Edit" class="tip-top i-block">
                                <i class="icon icon-note"></i>
                            </a>
                            <a href="#" title="Delete" class="tip-top i-block"
                               onclick="return admin.confirmDelete('{$oTournament->getTournamentId()}'); return false;">
                                <i class="icon icon-trash"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>

    {include file="inc.paging.tpl"}

    </div>
    <script>
        var admin = admin || {};

        admin.confirmDelete = function (id) {
            ls.modal.confirm({
                title: 'Delete',
                message: 'Are you realy wonna delete Tournament "' + id + '"<br/>Please confirm',
                onConfirm: function () {
                    document.location = "{router page='admin'}tournament/delete/" + id + "/?security_ls_key={$ALTO_SECURITY_KEY}";
                }
            });
        }
    </script>
{/block}
