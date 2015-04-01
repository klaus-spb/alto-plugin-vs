<?php

class PluginVs_ModuleVs_EntityMatchPlayerStat extends EntityORM
{
    protected $aRelations = array(
        'playercard' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'playercard_id'),
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id')
    );

}

?>