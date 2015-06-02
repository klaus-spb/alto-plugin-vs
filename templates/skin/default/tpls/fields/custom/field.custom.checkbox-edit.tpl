{if $oField}
    <div class="checkbox mal0 fs-small">
        <label>
            <input {if $oObject->getProp($oField->getFieldName())}checked{/if} type="checkbox"
                   id="{$oField->getFieldName()}"
                   name="{$oField->getFieldName()}" {if $onchange}onchange="{$onchange}"{/if}
                   value="1"/> {$oField->GetDescription()}

        </label>
    </div>
{/if}
