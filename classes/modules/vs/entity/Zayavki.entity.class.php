<?php

class PluginVs_ModuleVs_EntityZayavki extends EntityORM
{
    protected $aRelations = array(
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id')
    );
}

?>