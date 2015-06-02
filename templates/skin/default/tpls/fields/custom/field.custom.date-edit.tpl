{if $oField}
    <div class="form-group">
        <div class="input-group charming-datepicker">
            <span class="input-group-addon">{$oField->GetDescription()}</span>

            <div class="dropdown-menu"></div>
            <input class="date-picker form-control" data-toggle="dropdown" readonly="readonly"
                   name="{$oField->getFieldName()}" id="{$oField->getFieldName()}"
                   value="{$oObject->getProp($oField->getFieldName())|date_format:"%d.%m.%Y"}"
                   {if $onchange}onchange="{$onchange}" {/if} class="form-control">
        </div>
    </div>
{/if}
