<?php

class PluginVs_ModuleVs_EntityEvent extends EntityORM
{
    protected $aRelations = array(
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id')
    );

}

?>