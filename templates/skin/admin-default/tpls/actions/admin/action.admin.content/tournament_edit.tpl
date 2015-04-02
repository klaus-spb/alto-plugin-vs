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


    <div class="control-group">
        <label for="tournament_id" class="control-label">tournament_id</label>

        <div class="controls">
            <input type="text" id="tournament_id" class="input-text" name="tournament_id"
                   value="{if $_aRequest.tournament_id}{$_aRequest.tournament_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="game_id" class="control-label">game_id</label>

        <div class="controls">
            <input type="text" id="game_id" class="input-text" name="game_id"
                   value="{if $_aRequest.game_id}{$_aRequest.game_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="gametype_id" class="control-label">gametype_id</label>

        <div class="controls">
            <input type="text" id="gametype_id" class="input-text" name="gametype_id"
                   value="{if $_aRequest.gametype_id}{$_aRequest.gametype_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="league_id" class="control-label">league_id</label>

        <div class="controls">
            <input type="text" id="league_id" class="input-text" name="league_id"
                   value="{if $_aRequest.league_id}{$_aRequest.league_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="blog_id" class="control-label">blog_id</label>

        <div class="controls">
            <input type="text" id="blog_id" class="input-text" name="blog_id"
                   value="{if $_aRequest.blog_id}{$_aRequest.blog_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="blog_url" class="control-label">blog_url</label>

        <div class="controls">
            <input type="text" id="blog_url" class="input-text" name="blog_url"
                   value="{if $_aRequest.blog_url}{$_aRequest.blog_url|strip_tags|escape:'html'}{/if}"/>

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
        <label for="known_teams" class="control-label">known_teams</label>

        <div class="controls">
            <input type="text" id="known_teams" class="input-text" name="known_teams"
                   value="{if $_aRequest.known_teams}{$_aRequest.known_teams|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="league_name" class="control-label">league_name</label>

        <div class="controls">
            <input type="text" id="league_name" class="input-text" name="league_name"
                   value="{if $_aRequest.league_name}{$_aRequest.league_name|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="league_pass" class="control-label">league_pass</label>

        <div class="controls">
            <input type="text" id="league_pass" class="input-text" name="league_pass"
                   value="{if $_aRequest.league_pass}{$_aRequest.league_pass|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="win" class="control-label">win</label>

        <div class="controls">
            <input type="text" id="win" class="input-text" name="win"
                   value="{if $_aRequest.win}{$_aRequest.win|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="lose" class="control-label">lose</label>

        <div class="controls">
            <input type="text" id="lose" class="input-text" name="lose"
                   value="{if $_aRequest.lose}{$_aRequest.lose|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="win_o" class="control-label">win_o</label>

        <div class="controls">
            <input type="text" id="win_o" class="input-text" name="win_o"
                   value="{if $_aRequest.win_o}{$_aRequest.win_o|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="lose_o" class="control-label">lose_o</label>

        <div class="controls">
            <input type="text" id="lose_o" class="input-text" name="lose_o"
                   value="{if $_aRequest.lose_o}{$_aRequest.lose_o|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="exist_o" class="control-label">exist_o</label>

        <div class="controls">
            <input type="text" id="exist_o" class="input-text" name="exist_o"
                   value="{if $_aRequest.exist_o}{$_aRequest.exist_o|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="win_b" class="control-label">win_b</label>

        <div class="controls">
            <input type="text" id="win_b" class="input-text" name="win_b"
                   value="{if $_aRequest.win_b}{$_aRequest.win_b|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="lose_b" class="control-label">lose_b</label>

        <div class="controls">
            <input type="text" id="lose_b" class="input-text" name="lose_b"
                   value="{if $_aRequest.lose_b}{$_aRequest.lose_b|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="exist_b" class="control-label">exist_b</label>

        <div class="controls">
            <input type="text" id="exist_b" class="input-text" name="exist_b"
                   value="{if $_aRequest.exist_b}{$_aRequest.exist_b|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="points_n" class="control-label">points_n</label>

        <div class="controls">
            <input type="text" id="points_n" class="input-text" name="points_n"
                   value="{if $_aRequest.points_n}{$_aRequest.points_n|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="penalty_stay" class="control-label">penalty_stay</label>

        <div class="controls">
            <input type="text" id="penalty_stay" class="input-text" name="penalty_stay"
                   value="{if $_aRequest.penalty_stay}{$_aRequest.penalty_stay|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="goals_teh_w" class="control-label">goals_teh_w</label>

        <div class="controls">
            <input type="text" id="goals_teh_w" class="input-text" name="goals_teh_w"
                   value="{if $_aRequest.goals_teh_w}{$_aRequest.goals_teh_w|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="goals_teh_l" class="control-label">goals_teh_l</label>

        <div class="controls">
            <input type="text" id="goals_teh_l" class="input-text" name="goals_teh_l"
                   value="{if $_aRequest.goals_teh_l}{$_aRequest.goals_teh_l|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="goals_teh_n" class="control-label">goals_teh_n</label>

        <div class="controls">
            <input type="text" id="goals_teh_n" class="input-text" name="goals_teh_n"
                   value="{if $_aRequest.goals_teh_n}{$_aRequest.goals_teh_n|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="nichya" class="control-label">nichya</label>

        <div class="controls">
            <input type="text" id="nichya" class="input-text" name="nichya"
                   value="{if $_aRequest.nichya}{$_aRequest.nichya|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="exist_n" class="control-label">exist_n</label>

        <div class="controls">
            <input type="text" id="exist_n" class="input-text" name="exist_n"
                   value="{if $_aRequest.exist_n}{$_aRequest.exist_n|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="zakryto" class="control-label">zakryto</label>

        <div class="controls">
            <input type="text" id="zakryto" class="input-text" name="zakryto"
                   value="{if $_aRequest.zakryto}{$_aRequest.zakryto|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="datestart" class="control-label">datestart</label>

        <div class="controls">
            <input type="text" id="datestart" class="input-text" name="datestart"
                   value="{if $_aRequest.datestart}{$_aRequest.datestart|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="datezayavki" class="control-label">datezayavki</label>

        <div class="controls">
            <input type="text" id="datezayavki" class="input-text" name="datezayavki"
                   value="{if $_aRequest.datezayavki}{$_aRequest.datezayavki|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="dateopenrasp" class="control-label">dateopenrasp</label>

        <div class="controls">
            <input type="text" id="dateopenrasp" class="input-text" name="dateopenrasp"
                   value="{if $_aRequest.dateopenrasp}{$_aRequest.dateopenrasp|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="zavershen" class="control-label">zavershen</label>

        <div class="controls">
            <input type="text" id="zavershen" class="input-text" name="zavershen"
                   value="{if $_aRequest.zavershen}{$_aRequest.zavershen|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="autosubmit" class="control-label">autosubmit</label>

        <div class="controls">
            <input type="text" id="autosubmit" class="input-text" name="autosubmit"
                   value="{if $_aRequest.autosubmit}{$_aRequest.autosubmit|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="submithours" class="control-label">submithours</label>

        <div class="controls">
            <input type="text" id="submithours" class="input-text" name="submithours"
                   value="{if $_aRequest.submithours}{$_aRequest.submithours|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="prodlenie" class="control-label">prodlenie</label>

        <div class="controls">
            <input type="text" id="prodlenie" class="input-text" name="prodlenie"
                   value="{if $_aRequest.prodlenie}{$_aRequest.prodlenie|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="waitlist_topic_id" class="control-label">waitlist_topic_id</label>

        <div class="controls">
            <input type="text" id="waitlist_topic_id" class="input-text" name="waitlist_topic_id"
                   value="{if $_aRequest.waitlist_topic_id}{$_aRequest.waitlist_topic_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="prolong_topic_id" class="control-label">prolong_topic_id</label>

        <div class="controls">
            <input type="text" id="prolong_topic_id" class="input-text" name="prolong_topic_id"
                   value="{if $_aRequest.prolong_topic_id}{$_aRequest.prolong_topic_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="fond" class="control-label">fond</label>

        <div class="controls">
            <input type="text" id="fond" class="input-text" name="fond"
                   value="{if $_aRequest.fond}{$_aRequest.fond|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="vznos" class="control-label">vznos</label>

        <div class="controls">
            <input type="text" id="vznos" class="input-text" name="vznos"
                   value="{if $_aRequest.vznos}{$_aRequest.vznos|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="vznos_dop" class="control-label">vznos_dop</label>

        <div class="controls">
            <input type="text" id="vznos_dop" class="input-text" name="vznos_dop"
                   value="{if $_aRequest.vznos_dop}{$_aRequest.vznos_dop|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="exist_yard" class="control-label">exist_yard</label>

        <div class="controls">
            <input type="text" id="exist_yard" class="input-text" name="exist_yard"
                   value="{if $_aRequest.exist_yard}{$_aRequest.exist_yard|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="logo" class="control-label">logo</label>

        <div class="controls">
            <input type="text" id="logo" class="input-text" name="logo"
                   value="{if $_aRequest.logo}{$_aRequest.logo|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="topic_id" class="control-label">topic_id</label>

        <div class="controls">
            <input type="text" id="topic_id" class="input-text" name="topic_id"
                   value="{if $_aRequest.topic_id}{$_aRequest.topic_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="logo_small" class="control-label">logo_small</label>

        <div class="controls">
            <input type="text" id="logo_small" class="input-text" name="logo_small"
                   value="{if $_aRequest.logo_small}{$_aRequest.logo_small|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="logo_full" class="control-label">logo_full</label>

        <div class="controls">
            <input type="text" id="logo_full" class="input-text" name="logo_full"
                   value="{if $_aRequest.logo_full}{$_aRequest.logo_full|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="tournament_extra" class="control-label">tournament_extra</label>

        <div class="controls">
            <input type="text" id="tournament_extra" class="input-text" name="tournament_extra"
                   value="{if $_aRequest.tournament_extra}{$_aRequest.tournament_extra|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="site" class="control-label">site</label>

        <div class="controls">
            <input type="text" id="site" class="input-text" name="site"
                   value="{if $_aRequest.site}{$_aRequest.site|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="ch_id" class="control-label">ch_id</label>

        <div class="controls">
            <input type="text" id="ch_id" class="input-text" name="ch_id"
                   value="{if $_aRequest.ch_id}{$_aRequest.ch_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="platform_id" class="control-label">platform_id</label>

        <div class="controls">
            <input type="text" id="platform_id" class="input-text" name="platform_id"
                   value="{if $_aRequest.platform_id}{$_aRequest.platform_id|strip_tags|escape:'html'}{/if}"/>

        </div>
    </div>

    <div class="control-group">
        <label for="enable_trades" class="control-label">enable_trades</label>

        <div class="controls">
            <input type="text" id="enable_trades" class="input-text" name="enable_trades"
                   value="{if $_aRequest.enable_trades}{$_aRequest.enable_trades|strip_tags|escape:'html'}{/if}"/>

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
