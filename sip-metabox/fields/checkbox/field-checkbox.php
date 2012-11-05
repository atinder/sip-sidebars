<?php

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_checkbox extends SipMetaBox {

	public static function render($key,$value,$args){
		
		$checked = isset( $value ) ? $value : '0';
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th>',$args['name']);

		$html .= sprintf('<td><input type="%s" name="%s" value="1" %s /></td>',$args['type'],$key . '[' . $args['id'] .']',checked( '1', $checked, false ));

		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';

		echo $html;
	}

	
}