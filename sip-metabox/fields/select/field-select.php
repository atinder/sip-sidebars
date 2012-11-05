<?php

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_select extends SipMetaBox {

	public static function render($key,$value,$args){
		
		$checked = isset( $value ) ? $value : '0';
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th>',$args['name']);

		$html .= sprintf('<td><select name="%s">',$key . '[' . $args['id'] . ']');

		foreach ($args['options'] as $k => $val) {
			
			$html .= sprintf('<option value="%s" %s />%s</option>',$val,selected( $val, $value, false ),$val);

		}

		$html .= '</select></td>';

		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';

		echo $html;
	}

	
}