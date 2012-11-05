<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_multicheck extends SipMetaBox {

	public static function render($key,$value,$args){
		
		$name = $key . "[" . $args["id"] . "]";
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th><td>',$args['name']);

		foreach ( $args['options'] as $k => $label ) {

			$checked = isset( $value[$k] ) ? $value[$k] : '0';

			$html .= sprintf('<span> %s</span>',$label);

			$html .= sprintf('<input type="%s" name="%s" value="1" %s />','checkbox',$name . '[' . $k . ']' ,checked( '1', $checked, false ));
		}

		$html .= '</td>';

		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';

		echo $html;
	}

	
}