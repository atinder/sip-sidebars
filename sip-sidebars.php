<?php
/*
Plugin Name: Sip Sidebars Demo
Plugin URI: http://shopitpress.com
Author: atinder
Version: 1.0
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if(!class_exists('SipSidebars')){
require_once dirname(__FILE__) . '/class.sip.sidebars.php';
}
if(!class_exists('SipMetabox')){
	require_once dirname(__FILE__) . '/sip-metabox/class.sip.metabox.php';
}

class SipSidebarsDemo{

	public function __construct(){
		add_action( 'widgets_init', array($this,'config' ));
		if ( is_admin() )
		add_action( 'load-post.php', array('SipSidebarsDemo','call_metabox_class' ));
		add_action( 'load-post-new.php', array('SipSidebarsDemo','call_metabox_class' ));
	}
	public function config(){

		$sidebars[] = array(
							  'name' => __( 'Yea Right Sidebar' ),
							  'id' => 'right-sidebar'
							);

		$sidebars[] = array(
							  'name' => __( 'Test Left Hand Sidebar' ),
							  'id' => 'left-sidebar',
							  'description' => __( 'Widgets in this area will be shown on the right-hand side.' )
							);

		$sidebars_more = array('check','check2','check3');

		$sidebars = array_merge_recursive($sidebars,$sidebars_more);

		$wrapper = new SipSidebars($sidebars);

	}

	public function call_metabox_class(){

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$metaboxSidebars[] = $sidebar['name'];
		}
		array_unshift($metaboxSidebars, 'None');
		$meta_boxes[] = array(
					'id' => 'sip_sidebar_meta',
					'title' => 'Sidebar',
					'page' => 'post',
					'context' => 'side',
					'priority' => 'low',
					'fields' => array(
							array(
									'name' => 'Sidebar',
									'id' => 'sidebar',
									'type' => 'select',
									'std' => 'Sidebar',
									'options' => $metaboxSidebars
								)
							
						)
					);
		$sipMetabox = new SipMetaBox($meta_boxes,plugins_url('',__FILE__));

	}
}
new SipSidebarsDemo();

