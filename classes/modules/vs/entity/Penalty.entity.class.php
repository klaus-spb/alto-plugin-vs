<?php

class PluginVs_ModuleVs_EntityPenalty extends EntityORM
{
    protected $aRelations = array(
        'match' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityMatch', 'match_id'),
        'player' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id')
    );
}

?>