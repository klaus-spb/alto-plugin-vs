{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}config_table/add/" class="btn btn-primary"><i class="icon icon-plus"></i></a>
    </div>
{/block}

{block name="content-body"}
    <div class="span12">

        <div class="b-wbox">
            <div class="b-wbox-content nopadding">

                <table class="table table-striped table-condensed pages-list">
                    <thead>
                    <tr>

                        <th>table</th>
                        <th>field_name</th>
                        <th>field_description</th>
                        <th>field_type</th>
                        <th>sytem</th>
                        <th></th>

                    </tr>
                    </thead>

                    <tbody>
                    {foreach $aConfigTable as $oConfigTable}
                        <tr>

                            <td>{$oConfigTable->getTable()}</td>
                            <td>{$oConfigTable->getFieldName()}</td>
                            <td>{$oConfigTable->getFieldDescription()}</td>
                            <td>{$oConfigTable->getFieldType()}</td>
                            <td>{if $oConfigTable->getSystem()}*{/if}</td>

                            <td class="center">
                                <a href="{router page='admin'}config_table/edit/{$oConfigTable->getConfigTableId()}/"
                                   title="Edit" class="tip-top i-block">
                                    <i class="icon icon-note"></i>
                                </a>
                                {*<a href="#" title="Delete" class="tip-top i-block"
                                   onclick="return admin.confirmDelete('{$oConfigTable->getConfigTableId()}'); return false;">
                                    <i class="icon icon-trash"></i>
                                </a>*}
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
                message: 'Are you realy wonna delete ConfigTable "' + id + '"<br/>Please confirm',
                onConfirm: function () {
                    document.location = "{router page='admin'}config_table/delete/" + id + "/?security_ls_key={$ALTO_SECURITY_KEY}";
                }
            });
        }
    </script>
{/block}
