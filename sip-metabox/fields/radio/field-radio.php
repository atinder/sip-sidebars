<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_radio extends SipMetaBox {

	public static function render($key,$value,$args){
		
		$name = $key . "[" . $args["id"] . "]";
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th><td>',$args['name']);

		foreach ($args['options'] as  $val) {
			$val = isset( $val ) ? $val : '0';
			$html .= sprintf('<input type="%s" name="%s" value="%s" %s />',$args['type'],$name,$val,checked( $value, $val, false ));

			$html .= sprintf( '<label> %s  </label>', $val );

		}
		$html .= '</td>';
		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';

		echo $html;
	}

	
}