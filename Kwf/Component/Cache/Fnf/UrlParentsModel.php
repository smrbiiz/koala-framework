<?php
class Kwf_Component_Cache_FnF_UrlParentsModel extends Kwf_Component_Cache_Mysql_UrlParentsModel
{
    public function __construct(array $config = array())
    {
        $config['proxyModel'] = new Kwf_Model_FnF(array(
            'primaryKey' => 'id',
            'columns' => array('id', 'page_id', 'parent_page_id'),
        ));
        parent::__construct($config);
    }
}