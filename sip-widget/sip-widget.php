<?php
/*
Plugin Name: Sip Widget Demo
Plugin URI: http://shopitpress.com
Author: atinder
Version: 1.0
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

require_once dirname(__FILE__) . '/abstract.class.sip.widget.php';

class SipWidgetDemo extends SipWidget{


	public function w_id(){ 
		return 'sip-widget-id';
	}

	public function w_name(){
		return	'Sip Widget Name';
	}

    /** Return the dashboard admin form */
    public function w_form($instance){
        $w_form = '<p>'.$this->w_form_input($instance, 'title').'</p>';
        $w_form .= '<p>'.$this->w_form_checkbox($instance, 'check').'</p>';
        $w_form .= '<p>'.$this->w_form_checkbox($instance, 'check2').'</p>';

        return $w_form;
    }

    /** Return the real widget content */
    public function w_content($instance){
        $w_content = 'This is My first widget using SipWidget class';
        $w_content .= 'check2 = ' . $instance['check2'];
        $w_content .= 'check1 = ' . $instance['check'];
        return $w_content;
    }    

    /** Widget Default Options, abstract */
    public function w_defaults(){
        return array(
            'title' => __($this->w_name()),
            'check' => '0',
            'check2' => '1'
        );
    }

}

SipWidgetDemo::w_init();