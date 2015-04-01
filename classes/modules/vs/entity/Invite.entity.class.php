<?php

class PluginVs_ModuleVs_EntityInvite extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'playercard' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'playercard_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );
}


?>