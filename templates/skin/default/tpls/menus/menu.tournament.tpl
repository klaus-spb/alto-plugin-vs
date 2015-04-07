{*<ul class="nav nav-pills mb-0">*}

<ul class="main nav navbar-nav">
    <li {if $sMenuSubItemSelect=="index" || $sMenuSubItemSelect==""}class="active"{/if}><a
                href="{$oTournament->getUrlFull()}">{$aLang.plugin.vs.Tournament}</a></li>

    {if $oTournament->getGametypeId()!=3}
        <li {if $sMenuSubItemSelect=="players"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}players/">{$aLang.plugin.vs.players}</a></li>
    {/if}

    <li {if $sMenuSubItemSelect=="stats"}class="active"{/if}><a
                href="{$oTournament->getUrlFull()}stats/">{$aLang.plugin.vs.standings}</a></li>



    {if $oTournament && ($oTournament->getGametypeId()==3 || $oTournament->getGametypeId()==7 ) }
        <li {if $sMenuSubItemSelect=="player_stats"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}player_stats/">{$aLang.plugin.vs.stats}</a></li>
    {/if}

    {if isset($po)}
        <li {if $sMenuSubItemSelect=="po"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}po/">{$aLang.plugin.vs.playoff}</a></li>
    {/if}

    <li {if $sMenuSubItemSelect=="shedule"}class="active"{/if}><a
                href="{$oTournament->getUrlFull()}shedule/">{$aLang.plugin.vs.schedule}</a></li>

    {if $oGame && $oGame->getSportId()!=4}
        <li {if $sMenuSubItemSelect=="events"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}events/">{$aLang.plugin.vs.games}</a></li>
    {/if}


    {if $oTournament->getGametypeId()==3}
        <li {if $sMenuSubItemSelect=="players"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}players/">{$aLang.plugin.vs.players}</a></li>
    {/if}
    {if $oGame && $oGame->getSportId()!=6}
        <li {if $sMenuSubItemSelect=="stats_sh"}class="active"{/if}><a
                    href="{$oTournament->getUrlFull()}stats_sh/">{$aLang.plugin.vs.shahmatka}</a></li>
    {/if}
    <li {if $sMenuSubItemSelect=="rules"}class="active"{/if}><a
                href="{$oTournament->getUrlFull()}rules/">{$aLang.plugin.vs.rules}</a></li>

    {if $bIsAdmin}
        <li {if $sMenuSubItemSelect=="admin"}class="active"{/if}><a href="{$oTournament->getUrlFull()}admin/">Admin</a>
        </li>
    {/if}


</ul>