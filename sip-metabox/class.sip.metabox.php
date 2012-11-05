<?php

/**
 * Sip Metabox Class
 * @author Atinder <shopitpress.com>
 * @link http://shopitpress.com
 * @example sip-metabox.php
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if(!class_exists('SipMetaBox')){

	class SipMetaBox{

		/**
		 * MetaBoxes Array
		 *
		 * @var array
		 */
		private $_meta_boxes = array();

		/**
		 * Class Directory
		 */
		private $dir;

		/**
		 * PagesArray
		 */
		private $pagesArray;

		/**
		 * root_path
		 */
		protected $root_path;

		// Default Constructor
		public function __construct($meta_boxes,$root_path){	

			$this->setMetaboxes($meta_boxes);
			$this->root_path = $root_path;
			$this->pagesArray = $this->createPagesArray($this->_meta_boxes);

			add_action('add_meta_boxes', array($this,'add_meta_box'));
			add_action('save_post', array($this,'save_post'));
			add_action('admin_enqueue_scripts',array($this,'enqueue'));
		}

		/**
		 * Set Metaboxes
		 *
		 * @param array   $_meta_boxes Metaboxes array
		 */
		public function setMetaboxes($meta_boxes){

			$this->_meta_boxes = $meta_boxes;

		}

		public function createPagesArray($meta_boxes){
			foreach ($meta_boxes as $metabox) {
				$pageArray[] = $metabox['page'];
			}
			return $pageArray;
		}
		/**
		 * Loop through metaboxes array and generate each metabox holder
		 */
		public function add_meta_box(){

			$this->dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));

			foreach ($this->_meta_boxes as $meta_box) {

				add_meta_box($meta_box['id'],$meta_box['title'],array($this,'create_metabox'),$meta_box['page'],$meta_box['context'],$meta_box['priority'],$meta_box['fields']);
			}


		}

		/**
		 * Function to create metabox content
		 */
		public function create_metabox($post,$meta_box){

			// Use nonce for verification
	 		wp_nonce_field( plugin_basename( __FILE__ ), 'at_nonce' );
			
			echo '<table class="widefat at-metabox-table">';

			$value = get_post_meta( $post->ID, $meta_box['id'], false );

			foreach ($meta_box ['args'] as $field) {
			
				$field_class = 'Sip_field_' . $field['type'];
				
				if(!class_exists($field_class) && file_exists($this->dir.'fields/'.$field['type'].'/field-'.$field['type'].'.php')){
					require_once($this->dir.'fields/'.$field['type'].'/field-'.$field['type'].'.php');
				}

				if(class_exists($field_class)){
					$val = isset($value[0][$field['id']]) ? $value[0][$field['id']] :  $field['std'];
					$render = call_user_func_array(array($field_class,'render'),array($meta_box['id'],$val,$field));
				}

			}

			echo '</table>';


		}

		/**
		 * Function to save post metaboxes
		 */
		public function save_post($post_id){

			// verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			    return;

		 	// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times 

			if ( !isset( $_POST['at_nonce'] ) || !wp_verify_nonce( $_POST['at_nonce'], plugin_basename( __FILE__ ) ) )
			    return;

			// Check permissions
			if ( 'page' == $_POST['post_type'] ) {
	   			if ( !current_user_can( 'edit_page', $post_id ) )
	       		return;
	  		}
	  		else{
	    		if ( !current_user_can( 'edit_post', $post_id ) )
	      		return;
	  		}
			foreach ($this->_meta_boxes as $meta_box) {
				if(isset($_POST[$meta_box['id']])){
					$temp = implode('', $_POST[$meta_box['id']]);
					if(!empty($temp) ){
						update_post_meta( $post_id, $meta_box['id'], $_POST[$meta_box['id']]);
					}
					else{
						delete_post_meta($post_id, $meta_box['id']);
					}
				}
			}

		}

		/**
		 * Enqueue required scripts or styles
		 */
		public function enqueue(){

			$screen = get_current_screen();

			// Enqueue scripts and styles for registered pages (post types) only
			if ( 'post' != $screen->base || ! in_array( $screen->post_type, $this->pagesArray ) )
				return;

    		wp_enqueue_style( 'sip-metabox-class', $this->root_path . '/css/style.css');
    		wp_enqueue_script( 'sip-metabox-class', $this->root_path . '/js/custom.js');

		}

	}
}