<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_text extends SipMetaBox {

	public static function render($key, $value, $args ){
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th>',$args['name']);

		$html .= sprintf('<td><input class="large-text" type="%s" name="%s" value="%s" /></td>',$args['type'],$key . '[' . $args['id'] .']',( $value ? $value : $args['std']));

		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';
		
		echo $html;
	}

}