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

    public function GetTableInfo($sTableName)
    {

        $sql
            = "SELECT COLUMN_NAME,
                      COLUMN_DEFAULT,
                      IS_NULLABLE,
                      DATA_TYPE
                FROM information_schema.columns
                WHERE table_name =  ? ";

        $aRows = $this->oDb->select(
            $sql,
            $sTableName
        );

        return $aRows;
    }
}

?>
