{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}tournament/" class="btn btn-primary"><i class="icon icon-chevron-left"></i></a>
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
                    {hook run='plugin_tournament_form_add_begin'}
                    <input type="hidden" name="security_ls_key" value="{$ALTO_SECURITY_KEY}"/>
                    <input type="hidden" name="tournament_id" value="{$_aRequest.tournament_id}"/>


                    <div class="control-group">
                        <label for="game_id" class="control-label">game_id</label>

                        <div class="controls">
                            <select name="game_id" id="game_id">
                                {foreach from=$aGames item=oGame}
                                    <option value="{$oGame->getGameId()}"
                                            {if $_aRequest.game_id==$oGame->getGameId()}selected{/if}>{$oGame->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="platform_id" class="control-label">platform_id</label>

                        <div class="controls">
                            <select name="platform_id" id=platform_idblog_id">
                                {foreach from=$aPlatforms item=oPlatform}
                                    <option value="{$oPlatform->getPlatformId()}"
                                            {if $_aRequest.platform_id==$oPlatform->getPlatformId()}selected{/if}>{$oPlatform->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="tournament_type_id" class="control-label">tournament_type_id</label>

                        <div class="controls">
                            <select name="tournament_type_id" id="tournament_type_id">
                                {foreach from=$aTournamentTypes item=oTournamentType}
                                    <option value="{$oTournamentType->getTournamentTypeId()}"
                                            {if $_aRequest.tournament_type_id==$oTournamentType->getTournamentTypeId()}selected{/if}>{$oTournamentType->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="league_id" class="control-label">league_id</label>

                        <div class="controls">
                            <select name="league_id" id="league_id">
                                <option value="0">-</option>
                                {foreach from=$aLeagues item=oLeague}
                                    <option value="{$oLeague->getLeagueId()}"
                                            {if $_aRequest.game_id==$oLeague->getLeagueId()}selected{/if}>{$oLeague->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="blog_id" class="control-label">blog_id</label>

                        <div class="controls">
                            <select name="blog_id" id="blog_id">
                                {foreach from=$aBlogs item=oBlog}
                                    <option value="{$oBlog->getBlogId()}"
                                            {if $_aRequest.blog_id==$oBlog->getBlogId()}selected{/if}>{$oBlog->getTitle()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="name" class="control-label">name</label>

                        <div class="controls">
                            <input type="text" id="name" class="input-text" name="name"
                                   value="{if $_aRequest.name}{$_aRequest.name|strip_tags|escape:'html'}{/if}"/>

                        </div>
                    </div>

                    <div class="control-group">
                        <label for="brief" class="control-label">brief</label>

                        <div class="controls">
                            <input type="text" id="brief" class="input-text" name="brief"
                                   value="{if $_aRequest.brief}{$_aRequest.brief|strip_tags|escape:'html'}{/if}"/>

                        </div>
                    </div>

                    <div class="control-group">
                        <label for="url" class="control-label">url</label>

                        <div class="controls">
                            <input type="text" id="url" class="input-text" name="url"
                                   value="{if $_aRequest.url}{$_aRequest.url|strip_tags|escape:'html'}{/if}"/>

                        </div>
                    </div>
                    <div class="control-group">
                        <label for="url" class="control-label">admins</label>

                        <div class="controls">
                            <input type="text" class="input-wide js-autocomplete-users-sep" id="admins" name="admins"
                                   value="{if $_aRequest.admins}{$_aRequest.admins|strip_tags|escape:'html'}{/if}"/>
                        </div>
                    </div>



                    {hook run='plugin_tournament_form_add_end'}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"
                                name="submit_tournament_save">Save
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
{/block}
