<?php

class PluginVs_ModuleVs_EntityGame extends EntityORM
{
    protected $aRelations = array(
        'platform' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlatform', 'platform_id'),
        'sport' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntitySport', 'sport_id')
    );

}

?>