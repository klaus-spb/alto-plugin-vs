<?php

class PluginVs_ModuleVs_EntityPlayerStat extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'round' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityRound', 'round_id'),
        'group' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGroup', 'group_id'),
        'game' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGame', 'game_id'),
        'gametype' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGameType', 'gametype_id'),
        'parentgroup' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGroup', 'parentgroup_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );

}

?>