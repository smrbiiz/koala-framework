<?php
class Kwc_Basic_Table_Trl_ExtConfig extends Kwc_Basic_Table_ExtConfig
{
    protected function _getConfig()
    {
        $ret = parent::_getConfig();
        unset($ret['settings'], $ret['xlsImportTable']);
        return $ret;
    }
}
