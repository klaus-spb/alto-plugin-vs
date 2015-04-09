<?php

class PluginVs_ModuleVs_EntityConfigTable extends EntityORM
{
    public function GetDescription($sLang = null)
    {

        return $this->getLangTextProp('field_description', $sLang);
    }

}

?>