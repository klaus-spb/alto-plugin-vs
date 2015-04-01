<?php

class PluginVs_ModuleVs_EntityMatchGoal extends EntityORM
{
    protected $aRelations = array(
        'team' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'team_id'),
        'matchgoal' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'goal'),
        'matchassist' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'assist'),
        'matchassist2' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlayerCard', 'assist2')
    );

}

?>