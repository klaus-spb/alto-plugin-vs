<?php

class PluginVs_ModuleVs_EntityTournamentstat extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'round' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityRound', 'round_id'),
        'group' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGroup', 'group_id'),
        'parentgroup' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGroup', 'parentgroup_id'),
        'teamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'teamintournament_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );

}

?>