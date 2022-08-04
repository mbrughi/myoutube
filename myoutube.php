<?php

if (!defined('_PS_VERSION_')) 
    exit;

class mYoutube extends Module {

    public function __construct()
    {
        $this->name = 'myoutube';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Marco Brughi';
        $this->need_instance = 1;
        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('YouTube Video Embed', 'myoutube');
        $this->description = $this->l('This an example module to display an YouTube video.', 'myoutube');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?', 'myoutube');
    }

}	



