{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}config_table/" class="btn btn-primary"><i class="icon icon-chevron-left"></i></a>
    </div>
{/block}

{block name="content-body"}
    <div class="span12">

        <div class="b-wbox">
            <div class="b-wbox-header">
                <div class="b-wbox-header-title">
                    {if $sMode=='edit'}
                        Edit
                    {else}
                        Add
                    {/if}
                </div>
            </div>
            <div class="b-wbox-content nopadding">
                <form action="" method="POST" class="form-horizontal uniform" enctype="multipart/form-data">
                    {hook run='plugin_config_table_form_add_begin'}
                    <input type="hidden" name="security_ls_key" value="{$ALTO_SECURITY_KEY}"/>

                    <div class="b-wbox-content nopadding">
                        <div class="control-group">
                            <label for="table" class="control-label">
                                table:
                            </label>

                            <div class="controls">
                                <select name="table_name" id="table_name" class="input-text input-width-300"
                                        {if $sMode=='edit'}disabled{/if}>
                                    {foreach from=Config::Get('plugin.vs.tables_can_be_configured') item=sTable}
                                        <option value="{$sTable}"
                                                {if $_aRequest.table_name==$sTable}selected{/if}>{$sTable|escape:'html'}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="field_type" class="control-label">
                                {$aLang.action.admin.contenttypes_type}:
                            </label>

                            <div class="controls">
                                <select name="field_type" id="field_type" onChange="selectfield(jQuery(this).val());"
                                        class="input-text input-width-300" {if $sMode=='edit'}disabled{/if}>
                                    <option value="float" {if $_aRequest.field_type=='float'}selected{/if}
                                            title="float">
                                        Дробное
                                    </option>
                                    <option value="int" {if $_aRequest.field_type=='int'}selected{/if} title="int">
                                        Целое
                                    </option>
                                    <option value="tinyint" {if $_aRequest.field_type=='tinyint'}selected{/if}
                                            title="tinyint">
                                        Чекбокс
                                    </option>
                                    <option value="varchar" {if $_aRequest.field_type=='varchar'}selected{/if}
                                            title="varchar">
                                        {$aLang.action.admin.contenttypes_field_textarea}</option>
                                    <option value="enum" {if $_aRequest.field_type=='enum'}selected{/if}
                                            title="{$aLang.action.admin.contenttypes_field_select_notice}">
                                        {$aLang.action.admin.contenttypes_field_select}</option>
                                    <option value="date" {if $_aRequest.field_type=='date'}selected{/if}
                                            title="{$aLang.action.admin.contenttypes_field_date_notice}">
                                        {$aLang.action.admin.contenttypes_field_date}</option>
                                    <option value="datetime" {if $_aRequest.field_type=='datetime'}selected{/if}
                                            title="datetime">
                                        datetime
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="field_name" class="control-label">
                                {$aLang.action.admin.contenttypes_name}:
                            </label>

                            <div class="controls">
                                <input type="text" id="field_name" name="field_name" value="{$_aRequest.field_name}"
                                       class="input-text" {if $sMode=='edit'}disabled{/if}>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="field_description" class="control-label">
                                {$aLang.action.admin.contenttypes_description}:
                            </label>

                            <div class="controls">
                                <input type="text" name="field_description" value="{$_aRequest.field_description}"
                                       class="input-text">
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="default_value" class="control-label">
                                Default value:
                            </label>

                            <div class="controls">
                                <input type="text" id="default_value" name="default_value"
                                       value="{$_aRequest.default_value}"
                                       class="input-text" {if $sMode=='edit'}disabled{/if}>
                            </div>
                        </div>
                        <div class="control-group">

                            <label for="null_enabled" class="control-label">
                                Null enabled?
                            </label>

                            <div class="controls">
                                <input type="checkbox" id="null_enabled" name="null_enabled"
                                       {if $_aRequest.null_enabled}checked{/if}{if $sMode=='edit'}disabled{/if}/>
                            </div>
                        </div>

                        <div class="control-group"
                             {if !$_aRequest.field_type || $_aRequest.field_type!='enum'}style="display:none;"{/if}
                             id="enum_inputval">
                            <label for="field_description" class="control-label">
                                {$aLang.action.admin.contenttypes_values}:
                            </label>

                            <div class="controls">
                                <textarea name="field_values" id="field_values" class="input-text"
                                          rows="5" {if $sMode=='edit'}disabled{/if}>{$_aRequest.field_values}</textarea>
                            </div>
                        </div>

                        <div class="control-group">

                            <label for="system" class="control-label">
                                Don`t show in tournament admin panel
                            </label>

                            <div class="controls">
                                <input type="checkbox" id="system" name="system"
                                       {if $_aRequest.system}checked{/if}/>
                            </div>
                        </div>




                        {hook run='plugin_config_table_form_add_end'}
                        <div class="form-actions">
                            <button id="submit_config_table_save" type="submit" class="btn btn-primary"
                                    name="submit_config_table_save" {if $sMode!='edit'}disabled{/if}>Save
                            </button>
                        </div>

                </form>
            </div>
        </div>

    </div>
    <script>
        {if $sMode!='edit'}
        {literal}
        $('#field_name').on('input', function () {
            check_field();
        });
        {/literal}
        {/if}
        {literal}
        function check_field() {

            $('#submit_config_table_save').enable(false);

            ls.ajax(aRouter['admin'] + 'ajax/check_field/', {
                'table': $('#table').val(),
                'field': $('#field_name').val()
            }, function (response) {
                if (!response.bStateError) {
                    $('#submit_config_table_save').enable(true);
                } else {
                    ls.msg.error(response.sMsgTitle, response.sMsg);
                }
            });
        }
        function selectfield(f) {
            $('#enum_inputval').css({'display': 'none'});
            $('#field_size').css({'display': 'none'});

            //для типа выпадающий список
            if (f == 'enum') {
                $('#enum_inputval').css({'display': 'block'});
                }

            if (f == 'float' || f == 'varchar') {
                $('#field_size').css({'display': 'block'});
            }
            return false;
            }
        {/literal}
    </script>
{/block}
