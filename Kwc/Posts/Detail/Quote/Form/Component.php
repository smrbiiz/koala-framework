<?php
class Kwc_Posts_Detail_Quote_Form_Component extends Kwc_Posts_Write_Form_Component
{
    protected function _getPostsComponent()
    {
        return $this->getData()->parent->parent->parent->parent;
    }

    protected function _initForm()
    {
        parent::_initForm();
        $v = "[quote]\n" . $this->getData()->parent->parent->parent->row->content . "\n[/quote]\n";
        $this->_form->fields['content']->setDefaultValue($v);
    }
}
