<?php
/* Custom Shortcodes For Layout
*  For giving clients more flexiblity in customizing
*  their content layout. Currently uses Bootstrap 3.
*  Incomplete and slated for removal.
*
*  Version 0.2
*/

add_action( 'init', 'add_shortcodes' );

function add_shortcodes() {
	add_shortcode('full', 'ask_full');
	add_shortcode('three_fourth', 'ask_three_fourth');
	add_shortcode('half', 'ask_half');
	//add_shortcode('three_eighth', 'ask_three_eighth');
	add_shortcode('one_third', 'ask_one_third');
	add_shortcode('one_fourth', 'ask_one_fourth');
	//add_shortcode('one_fifth', 'ask_one_fifth');
	add_shortcode('two_third', 'ask_two_third');
	//add_shortcode('subscribe', 'ask_subscribe');
}

function clean($pattern, $text){
	$searchfor = array('<p>'.$pattern, $pattern.'</p>', $pattern.'<br />', '<p></div>', '</div></p>', '<br /></div>', '<p><div', '</div><br />', "<br />\n</div>", "<br /><div", "<br />\n<div");
	$replacewith = array($pattern, $pattern, $pattern, '</div>', '</div>', '</div>', '<div', '</div>', '</div>', '<div', '<div');
	$out = str_replace($searchfor, $replacewith, $text);
	return $out;
}

function ask_full( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-12 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-12 '.$class.'">', $out);
}

function ask_three_fourth( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-9 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-9 '.$class.'">', $out);
}

function ask_half( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-6 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-6 '.$class.'">', $out);
}

function ask_three_eighth( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="three_eighth '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="three_eighth '.$class.'">', $out);
}

function ask_one_third( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-4 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-4 '.$class.'">', $out);
}

function ask_one_fourth( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-3 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-3 '.$class.'">', $out);
}

function ask_one_fifth( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="one_fifth '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="one_fifth '.$class.'">', $out);
}

function ask_two_third( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'class' => ''
      ), $atts ) );
	$out = '<div class="col-sm-8 '.$class.'">'.do_shortcode($content).'</div>';
	return clean('<div class="col-sm-8 '.$class.'">', $out);
}

//function ask_subscribe($atts, $content = null) {
//	extract(shortcode_atts(array(
//		'title' => '',
//	), $atts));
//	global $data;
//
//	$out = '';
//
//	if ($data['subscription_form'])
//	$out .= '<div class="emailSubscribe"><h4>'.$title.'</h4>'.do_shortcode('[contact-form-7 id="'.$data['subscription_form'].'"]').'</div>';
//
//	return $out;
//}
?>
