<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_textarea extends SipMetaBox {

	public static function render($key,$value,$args){
		
		$html = '';

		$html .= sprintf('<tr><th>%s</th>',$args['name']);

		$html .= sprintf('<td><textarea rows="5" cols="40" class="large-text" type="%s" name="%s">%s</textarea></td>',$args['type'],$key . '[' . $args['id'] .']',$value);

		if(isset($args['desc'])){
			$html .= sprintf('<td>%s</td>',$args['desc']);
		}
		$html .= '</tr>';

		echo $html;
	}

	
}