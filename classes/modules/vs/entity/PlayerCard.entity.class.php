<?php

class PluginVs_ModuleVs_EntityPlayerCard extends EntityORM
{
    protected $aRelations = array(
        'platform' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityPlatform', 'platform_id'),
        'sport' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntitySport', 'sport_id'),
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id')
    );

    public function getFotoUrl()
    {
        return $this->getFoto() ? $this->getFoto() : 'http://virtualsports.ru/templates/skin/virtsports/images/Arshavin.png';
    }

    public function getFullFio()
    {
        return $this->getFamily() . ' ' . $this->getName();
    }

}

?>