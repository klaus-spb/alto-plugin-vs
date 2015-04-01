<?php

class PluginVs_ModuleVs_EntityTeamTournament extends EntityORM
{
    protected $aRelations = array(
        'user1' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'player_id'),
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );

}

?>