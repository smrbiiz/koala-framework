<?php
class Kwf_Assets_Modernizr_TestProviderList extends Kwf_Assets_ProviderList_Abstract
{
    public function __construct()
    {
        parent::__construct(array(
            new Kwf_Assets_Modernizr_Provider(),
            new Kwf_Assets_Provider_Ini(dirname(__FILE__).'/ProviderTestDependencies.ini'),
        ));
    }
}