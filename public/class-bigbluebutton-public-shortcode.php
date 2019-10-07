<?php

class Bigbluebutton_Public_Shortcode {

    /**
     * Register bigbluebutton shortcode.
     * 
     * @since   3.0.0
     * 
     */
    public function register_shortcodes() {
		add_shortcode('bigbluebutton', array($this, 'display_bigbluebutton_shortcode'));
    }
    
    /**
     * Handle shortcode attributes.
     * 
     * @since   3.0.0
     * 
     * @param   Array   $atts       Parameters in the shortcode.
     * @param   String  $content    Content of the shortcode.
     * 
     * @return  String  $content    Content of the shortcode with rooms and recordings.
     */
    public function display_bigbluebutton_shortcode($atts = [], $content = null) {
		$rooms = array();
		$type = 'room';
		$author = get_the_author_meta('ID');
		$display_helper = new BigbluebuttonDisplayHelper(plugin_dir_path(__FILE__));
		$tokens_string = "";

		foreach ($atts as $key => $param) {
			if ($key == 'type' && $param == 'recording') {
				$type = 'recording';
			} else if ($key == 'token') {
				$tokens_string = $param;
			}
		}

		if ($type == 'room') {
			$content .= BigbluebuttonTokensHelper::join_form_from_tokens_string($display_helper, $tokens_string, $author);
		} else if ($type == 'recording') {
			$content .= BigbluebuttonTokensHelper::recordings_table_from_tokens_string($display_helper, $tokens_string, $author);
		}
		return $content;
    }
}