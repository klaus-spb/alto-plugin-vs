<?php

class PluginVs_ModuleVs_EntityEventPair extends EntityORM
{
    protected $aRelations = array(
        'leftteamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'left_teamintournament_id'),
        'rightteamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'right_teamintournament_id'),
        'event' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityEvent', 'event_id')

    );

}

?>