<?php

class PluginVs_ModuleVs_EntityPlayerTournament extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'player_card' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'player_card_id'),
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );
}


?>