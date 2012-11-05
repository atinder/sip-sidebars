<?php

/**
 * Sip Sidebars Class
 * @author Atinder <shopitpress.com>
 * @link http://shopitpress.com
 * @example sip-sidebars.php
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if(!class_exists('SipSidebars')){

	class SipSidebars{

		private $sidebars = array();

		public function __construct($sidebars=null){
			$this->setSidebars($sidebars);
			$this->register_sidebars();
		}

		/**
		 * Generate widget Id from name
		 */
		private function genWidgetId($name){
			return strtolower(preg_replace('/\s*/', '', $name ));
		}

		public function setSidebars($sidebars){
			$this->sidebars = $sidebars;
		}

		public function register_sidebars(){
			if ( function_exists( 'register_sidebar' ) ){

				foreach ($this->sidebars as $sidebar) {
					$sidebar = is_array($sidebar) ? $sidebar : array('name'=>$sidebar);
					$defaults = array(
							'id' => ($this->genWidgetId($sidebar['name']) ? $this->genWidgetId($sidebar['name']) : null),
							'description' => __( 'Drag widgets here to display them.' ),
							'before_widget' => '<div id="%1$s" class="widget %2$s">',
							'after_widget' => '</div>',
							'before_title' => '<h3 class="widget-title">',
						  	'after_title' => '</h3>'  	
						);
					$sidebar = wp_parse_args($sidebar,$defaults);
					register_sidebar($sidebar);
				}
				
			}

		}

	}

}