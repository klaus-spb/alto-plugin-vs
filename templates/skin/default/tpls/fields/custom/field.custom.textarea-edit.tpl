{if $oField}
    <div class="form-group">
        <textarea placeholder="{$oField->GetDescription()}" name="{$oField->getFieldName()}"
                  id="{$oField->getFieldName()}" class="form-control" {if $onchange}onchange="{$onchange}"{/if}
                  rows="5">{$oObject->getProp($oField->getFieldName())|escape:'html'}</textarea>
    </div>
{/if}