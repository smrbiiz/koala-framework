<?php
class Kwc_Newsletter_Admin extends Kwc_Directories_Item_Directory_Admin
{
    public function addResources(Kwf_Acl $acl)
    {
        parent::addResources($acl);

        if (!$acl->has('kwc_newsletter')) {
            $acl->add(new Kwf_Acl_Resource_MenuDropdown('kwc_newsletter',
                array('text'=>trlKwf('Newsletter'), 'icon'=>'email_open_image.png')), 'kwf_component_root');
        }

        $icon = Kwc_Abstract::getSetting($this->_class, 'componentIcon');
        $menuConfig = array('icon'=>$icon);

        $components = Kwf_Component_Data_Root::getInstance()
                ->getComponentsBySameClass($this->_class, array('ignoreVisible'=>true));
        foreach ($components as $c) {
            $menuConfig['text'] = trlKwf('Edit {0}', trlKwf('Newsletter'));
            if (count($components) > 1) {
                $subRoot = $c;
                while($subRoot = $subRoot->parent) {
                    if (Kwc_Abstract::getFlag($subRoot->componentClass, 'subroot')) break;
                }
                if ($subRoot) {
                    $menuConfig['text'] .= ' ('.$subRoot->name.')';
                }
            }
            $acl->add(new Kwf_Acl_Resource_Component_MenuUrl($c, $menuConfig), 'kwc_newsletter');
        }
    }

    public function setup()
    {
        $sql = "
            DROP TABLE IF EXISTS `kwc_newsletter`;
            CREATE TABLE IF NOT EXISTS `kwc_newsletter` (
              `id` smallint(6) NOT NULL auto_increment,
              `component_id` varchar(255) default NULL,
              `create_date` datetime NOT NULL,
              `status` enum('start','pause','stop','sending','finished') default NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

            DROP TABLE IF EXISTS `kwc_newsletter_log`;
            CREATE TABLE IF NOT EXISTS `kwc_newsletter_log` (
              `id` int(11) NOT NULL auto_increment,
              `newsletter_id` smallint(6) NOT NULL,
              `start` datetime NOT NULL,
              `stop` datetime NOT NULL,
              `count` smallint(6) NOT NULL,
              `countErrors` smallint(6) NOT NULL,
              PRIMARY KEY  (`id`),
              KEY `newsletter_id` (`newsletter_id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

            DROP TABLE IF EXISTS `kwc_newsletter_queue`;
            CREATE TABLE IF NOT EXISTS `kwc_newsletter_queue` (
              `id` int(11) NOT NULL auto_increment,
              `newsletter_id` smallint(6) NOT NULL,
              `recipient_model` varchar(255) NOT NULL,
              `recipient_id` varchar(255) NOT NULL,
              `searchtext` varchar(255) NOT NULL,
              `status` enum('queued','sending','userNotFound','sent','sendingError') NOT NULL default 'queued',
              `sent_date` timestamp NULL default NULL,
              PRIMARY KEY  (`id`),
              UNIQUE KEY `newsletter_id_2` (`newsletter_id`,`recipient_model`,`recipient_id`),
              KEY `newsletter_id` (`newsletter_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

            ALTER TABLE `kwc_newsletter_queue`
              ADD CONSTRAINT `kwc_newsletter_queue_ibfk_1` FOREIGN KEY (`newsletter_id`) REFERENCES `kwc_newsletter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

            CREATE TABLE IF NOT EXISTS `kwc_newsletter_subscribers` (
            `id` int(10) unsigned NOT NULL auto_increment,
            `gender` enum('','female','male') NOT NULL,
            `title` varchar(255) NOT NULL,
            `firstname` varchar(255) NOT NULL,
            `lastname` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `format` enum('','html','text') NOT NULL,
            `subscribe_date` datetime NOT NULL,
            `unsubscribed` tinyint(1) NOT NULL,
            `activated` tinyint( 1 ) NOT NULL DEFAULT '0',
            PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB ;

        ";
        //Kwf_Registry::get('db')->query($sql);
    }
}