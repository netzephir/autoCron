<?php

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

require_once( 'application/third_party/smarty-3.1.30/libs/Smarty.class.php' );

class Smartyci extends Smarty
{

    public function __construct()
    {
        parent::__construct();

        $config =& get_config();
        $cache = 0;
        if(ENVIRONMENT === 'production')
        {
            $cache = 1;
        }
        $this->caching = $cache;
        $this->setTemplateDir( APPPATH . 'views' );
        $this->setCompileDir( APPPATH . 'views/smarty/templates_c' );
        $this->setConfigDir( APPPATH . 'third_party/smarty-3.1.30/configs' );
        $this->setCacheDir( APPPATH . 'views/smarty/cache' );
    }

    //if specified template is cached then display template and exit, otherwise, do nothing.
    public function useCached( $tpl, $cacheId = null )
    {
        if ( $this->isCached( $tpl, $cacheId ) )
        {
            $this->display( $tpl, $cacheId );
            exit();
        }
    }
}