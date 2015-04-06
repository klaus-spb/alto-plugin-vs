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
                        <th>tournament_type_id</th>
                        <th>blog_id</th>
                        <th>platform_id</th>
                        <th>name</th>
                        <th>url</th>
                        <th></th>

                    </tr>
                    </thead>

                    <tbody>
                    {foreach $aTournament as $oTournament}
                        <tr>

                            <td>{$oTournament->getTournamentId()}</td>
                            <td>{if $oTournament->getGame()}{$oTournament->getGame()->getName()}{/if}</td>
                            <td>{if $oTournament->getTournamentType()}{$oTournament->getTournamentType()->getName()}{/if}</td>
                            <td>{if $oTournament->getBlog()}{$oTournament->getBlog()->getTitle()}{/if}</td>
                            <td>{if $oTournament->getPlatform()}{$oTournament->getPlatform()->getName()}{/if}</td>
                            <td><a href="{$oTournament->getUrlFull()}" target="_blank">{$oTournament->getName()}</a>
                            </td>
                            <td>{$oTournament->getUrl()}</td>

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
