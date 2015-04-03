<?php

class PluginVs_ModuleVs_EntityPlayerTeam extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'player_card' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'player_card_id'),
    );

}

?>