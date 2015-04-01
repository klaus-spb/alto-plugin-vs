<?php

class PluginVs_ModuleVs_EntityMatchVideo extends EntityORM
{

    protected $aRelations = array(
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'match' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityMatch', 'match_id')
    );

}

?>