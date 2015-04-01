<?php

class PluginVs_ModuleVs_EntityMapTournament extends EntityORM
{
    protected $aRelations = array(
        'map' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityMap', 'map_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );

}

?>