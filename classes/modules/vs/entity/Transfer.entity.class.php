<?php

class PluginVs_ModuleVs_EntityTransfer extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'playercard' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'playercard_id'),
        'who_user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'who'),
    );
}


?>