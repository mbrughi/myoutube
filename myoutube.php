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

    public function install()
    {
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        return parent::install() &&
            $this->registerHook('displayHome') && Configuration::updateValue('youtube_video_url', 'wlsdMpnDBn8');
    }

    public function uninstall()
    {
        if (!parent::uninstall() || !Configuration::deleteByName('youtube_video_url'))
            return false;
        return true;
    }
    
    public function hookDisplayHome($params)
    {
        // < assign variables to template >
        $this->context->smarty->assign(
            array('youtube_url' => Configuration::get('youtube_video_url'))
        );
        return $this->display(__FILE__, 'youtube_video.tpl');
    }      

    public function displayForm()
    {
        // < init fields for form array >
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('YouTube Module'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('URL of the YouTube video'),
                    'name' => 'youtube_video_url',
                    'lang' => false,
                    'size' => 20,
                    'required' => true
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        // < load helperForm >
        $helper = new HelperForm();

        // < module, token and currentIndex >
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // < title and toolbar >
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        // < load current value >
        $helper->fields_value['youtube_video_url'] = Configuration::get('youtube_video_url');

        return $helper->generateForm($fields_form);
    } 

    public function getContent()
    {
        $output = null;


        // < here we check if the form is submited for this module >
        if (Tools::isSubmit('submit'.$this->name)) {
            $youtube_url = strval(Tools::getValue('youtube_video_url'));

            // < make some validation, check if we have something in the input >
            if (!isset($youtube_url))
                $output .= $this->displayError($this->l('Please insert something in this field.'));
            else
            {
                // < this will update the value of the Configuration variable >
                Configuration::updateValue('youtube_video_url', $youtube_url);


                // < this will display the confirmation message >
                $output .= $this->displayConfirmation($this->l('Video URL updated!'));
            }
        }
        return $output.$this->displayForm();
    }      
    
    
}	



