<?php
class Vps_Form_CardsRealModels_Model_WrapperModel extends Vps_Model_Db
{
    protected $_table;
    protected $_siblingModels;
    protected $_rowClass = 'Vps_Form_CardsRealModels_Model_WrapperModelRow';

    public function __construct($config = array())
    {
        $this->_siblingModels = array(
            'sibfirst' => 'Vps_Form_CardsRealModels_Model_FirstnameModel',
            'siblast' => 'Vps_Form_CardsRealModels_Model_LastnameModel'
        );

        $this->_table = new Vps_Form_CardsRealModels_Model_WrapperTable();

        parent::__construct($config);
    }
}