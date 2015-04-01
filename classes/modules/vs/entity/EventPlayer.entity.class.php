<?php

class PluginVs_ModuleVs_EntityEventPlayer extends EntityORM
{
    protected $aRelations = array(
        'teamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'teamintournament_id'),
        'event' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityEvent', 'event_id')

    );

}

?>