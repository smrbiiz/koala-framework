<?php
class Kwc_Advanced_DownloadsTree_Component extends Kwc_Abstract_Composite_Component
{
    public static function getSettings()
    {
        $ret = parent::getSettings();
        $ret['componentName'] = trlKwf('Downloads');
        $ret['componentIcon'] = new Kwf_Asset('application_side_tree');

        $ret['assetsAdmin']['files'][] = 'kwf/Kwc/Advanced/DownloadsTree/AdminPanel.js';
        $ret['assets']['files'][] = 'kwf/Kwc/Advanced/DownloadsTree/Component.js';
        $ret['assets']['dep'][] = 'KwfAutoTree';
        $ret['assets']['dep'][] = 'KwfAutoGrid';
        $ret['assets']['dep'][] = 'ExtBorderLayout';
        $ret['assets']['dep'][] = 'ExtDate';
        $ret['projectsModel'] = 'Kwc_Advanced_DownloadsTree_Projects';
        $ret['downloadsModel'] = 'Kwc_Advanced_DownloadsTree_Downloads';

        $ret['plugins'] = array('Kwc_Rotary_Password_Component');
        $ret['flags']['hasResources'] = true;

        $ret['panelWidth'] = 490;
        $ret['panelHeight'] = 500;

        $ret['extConfig'] = 'Kwc_Advanced_DownloadsTree_ExtConfig';
        return $ret;
    }

    public function getTemplateVars()
    {
        $ret = parent::getTemplateVars();
        $ret['options'] = $this->_getOptions();
        return $ret;
    }

    protected function _getOptions()
    {
        $ret['componentId'] = $this->getData()->componentId;
        $ret['projectsUrl'] = Kwc_Admin::getInstance(get_class($this))->getControllerUrl('ViewProjects');
        $ret['downloadsUrl'] = Kwc_Admin::getInstance(get_class($this))->getControllerUrl('ViewDownloads');
        $ret['width'] = $this->_getSetting('panelWidth');
        $ret['height'] = $this->_getSetting('panelHeight');
        if (!Kwf_Controller_Front::getInstance() instanceof Kwf_Controller_Front_Component)
            throw new Kwf_Exception('Front Controller must be instance of Kwf_Controller_Front_Component');
        return $ret;
    }

    public function hasContent()
    {
        $projects = Kwf_Model_Abstract::getInstance($this->_getSetting('projectsModel'));
        $select = $projects->select()
            ->whereEquals('component_id', $this->getData()->componentId);
        $downloads = Kwf_Model_Abstract::getInstance($this->_getSetting('downloadsModel'));
        foreach ($projects->getRows($select) as $project) {
            $select = $downloads->select()
                ->whereEquals('visible' , 1)
                ->whereEquals('project_id', $project->id);
            if ($downloads->countRows($select) > 0) return true;
        }
        return false;
    }
}