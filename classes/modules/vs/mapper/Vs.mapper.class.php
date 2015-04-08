<?php

class PluginVs_ModuleVs_MapperVs extends MapperORM
{
    public function GetAll($sql)
    {
        $sValue = null;

        $aRows = @$this->oDb->select($sql);
        if ($aRows) $sValue = $aRows;

        return $sValue;
    }
}

?>
