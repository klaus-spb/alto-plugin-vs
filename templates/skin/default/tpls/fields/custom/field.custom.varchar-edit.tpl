{if $oField}
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">{$oField->GetDescription()}</span>
            <input type="text"
                   name="{$oField->getFieldName()}" id="{$oField->getFieldName()}"
                   value="{$oTournament->getProp($oField->getFieldName())|escape:'html'}" class="form-control">
        </div>
    </div>
{/if}
