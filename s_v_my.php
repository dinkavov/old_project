<?php
//save default
if ( ! function_exists( 'scllgn_get_default_options' ) ) {
	function scllgn_get_default_options( $is_network_admin = false ) {
		global $scllgn_plugin_info;

		$default_options = array(
			'button_display_google'					=> 'long',
			'button_display_facebook'				=> 'long',
			'button_display_twitter'				=> 'long',
			'button_display_linkedin'				=> 'long',
			'linkedin_button_name'					=> __( 'Sign in with LinkedIn', 'social-login-bws' ),
			'twitter_button_name'					=> __( 'Sign in with Twitter', 'social-login-bws' ),
			'facebook_button_name'					=> __( 'Sign in with Facebook', 'social-login-bws' ),
			'google_button_name'					=> __( 'Sign in with Google', 'social-login-bws' ),
			'allow_registration'					=> 'default'
		);






/* Prepare and return login button for specified provider */
if ( ! function_exists( 'scllgn_get_button' ) ) {
	function scllgn_get_button( $provider = '', $echo = false ) {
		global $scllgn_options, $scllgn_providers, $pagenow;

		$button = '';
		if ( 'google' == $provider ) {
			$client  = scllgn_google_client();
			$authUrl = urldecode( $client->createAuthUrl() );
			$dashicon_for_button = 	'dashicons-googleplus';
			$button_html = $scllgn_options['button_display_google'];
			$button_text = $scllgn_options['google_button_name'];
		} elseif ( 'facebook' == $provider ) {
			scllgn_facebook_client();
			$facebook_redirect = plugin_dir_url( __FILE__ ) . 'facebook_callback.php';
			$url = 'https://www.facebook.com/dialog/oauth';
			$params = array(
				'client_id'     => $scllgn_options['facebook_client_id'],
				'redirect_uri'  => $facebook_redirect,
				'response_type' => 'code',
				'scope'         => 'email'
			);
			$authUrl = $url . '?' . http_build_query( $params, null, '&' );
			$dashicon_for_button = 	'dashicons-facebook';
			$button_html = $scllgn_options['button_display_facebook'];
			$button_text = $scllgn_options['facebook_button_name'];
		} elseif ( 'twitter' == $provider ) {
			scllgn_twitter_client();
			$authUrl = 'https://api.twitter.com/oauth/authorize?include_email=true&oauth_token=' . $_SESSION['twitter_oauth_token'];
			$dashicon_for_button = 	'dashicons-twitter';
			$button_html = $scllgn_options['button_display_twitter'];
			$button_text = $scllgn_options['twitter_button_name'];
		} elseif ( 'linkedin' == $provider ) {
			scllgn_linkedin_client();
			$oauth_nonce = md5( uniqid( rand(), true ) );
			$_SESSION['linkedin_redirect'] = plugin_dir_url( __FILE__ ) . 'linkedin_callback.php';
			$url = 'https://www.linkedin.com/oauth/v2/authorization';
			$params = array(
				'response_type' => 'code',
				'client_id' 	=> $scllgn_options['linkedin_client_id'],
				'redirect_uri' 	=> $_SESSION['linkedin_redirect'],
				'state' 		=> $oauth_nonce,
				'scope' 		=> 'r_basicprofile,r_emailaddress'
			);
			$authUrl = $url . '?' . urldecode( http_build_query( $params ) );
			$dashicon_for_button = 	'bws-icons';
			$button_html = $scllgn_options['button_display_linkedin'];
			$button_text = $scllgn_options['linkedin_button_name'];
		}
		if( 'long' == $button_html ) {
			$button .=	sprintf(
				'<a href="%1$s" class="scllgn_login_button scllgn_button_%2$s scllgn_login_button_long scllgn_%5$s_button" id="scllgn_%5$s_button" data-scllgn-position="%2$s" data-scllgn-provider="%5$s">' .
					'<span class="dashicons %3$s""></span>' .
					'<span class="scllgn_button_text">%4$s</span>' .
				'</a>',
				$authUrl,
				$scllgn_options['loginform_buttons_position'],
				$dashicon_for_button,
				$button_text,
				$provider
			);	
		} elseif ( 'short' == $button_html ) {
			$button .=	sprintf(
				'<a href="%1$s" class="scllgn_login_button scllgn_login_button_icon scllgn_%5$s_button_admin scllgn_login_button_short scllgn_button_%2$s scllgn_%5$s_button" data-scllgn-position="%2$s" data-scllgn-provider="%5$s" id="scllgn_%5$s_button">' .
					'<span class="dashicons %3$s scllgn_span_icon"></span>' .
				'</a>',
				$authUrl,
				$scllgn_options['loginform_buttons_position'],
				$dashicon_for_button,
				$button_text,
				$provider
			);	
		}
		$button_text = apply_filters( 'scllgn_button_text', $button_text );
		$button = apply_filters( 'scllgn_' . $provider . '_button', $button );
		$button = apply_filters( 'scllgn_button', $button );

		if ( $echo ) {
			echo $button;
		}
		return $button;
	}
}

/* Adding Sign In buttons to the Login form page */
if ( ! function_exists( 'scllgn_login_form' ) ) {
	function scllgn_login_form() {
		global $scllgn_options, $scllgn_providers;

		if ( ! is_user_logged_in() ) {
			scllgn_display_all_buttons( 'login_form' );
			$buttons_short = $buttons_long = array();

			foreach ( $scllgn_providers as $provider => $provider_name ) {
				if ( ! empty( $scllgn_options["{$provider}_is_enabled"] ) && ! empty( $scllgn_options["login_form"] ) ) {
					if ( 'long' == $scllgn_options["button_display_{$provider}"] ) {
						$buttons_long[ $provider ] = scllgn_get_button( $provider );
					} else {
						$buttons_short[ $provider ] = scllgn_get_button( $provider );
					}
				}
			}
		}
	}
}

/* Adding Sign In buttons to the Register form page */
if ( ! function_exists( 'scllgn_register_form' ) ) {
	function scllgn_register_form() {
		global $scllgn_options, $scllgn_providers;
		if ( ! is_user_logged_in() && ! empty( $scllgn_options["register_form"] ) && 'deny' != $scllgn_options["allow_registration"] ) {
		scllgn_display_all_buttons( 'register_form' );
		$buttons_short = $buttons_long = array();

			foreach ( $scllgn_providers as $provider => $provider_name ) {
				if ( ! empty( $scllgn_options["{$provider}_is_enabled"] ) && ! empty( $scllgn_options["register_form"] ) ) {
					if ( 'long' == $scllgn_options["button_display_{$provider}"] ) {
						$buttons_long[ $provider ] = scllgn_get_button( $provider );
					} else {
						$buttons_short[ $provider ] = scllgn_get_button( $provider );
					}
				}
			}
		}
	}
}


/* Display all available buttons */
if ( ! function_exists( 'scllgn_display_all_buttons' ) ) {
	function scllgn_display_all_buttons( $form = '' ) {
		global $scllgn_options, $scllgn_providers;

		if ( ! is_user_logged_in() ) {
			$buttons_short = $buttons_long = array();

			foreach ( $scllgn_providers as $provider => $provider_name ) {
				if ( ! empty( $scllgn_options["{$provider}_is_enabled"] ) && ! empty( $scllgn_options["login_form"] ) ) {
					if ( 'long' == $scllgn_options["button_display_{$provider}"] ) {
						$buttons_long[ $provider ] = scllgn_get_button( $provider );
					} else {
						$buttons_short[ $provider ] = scllgn_get_button( $provider );
					}
				}
			}

			if ( 'comment_form' == $form ) {
				$buttons_long = apply_filters( 'scllgn_sort_comment_buttons', $buttons_long );
				$buttons_short = apply_filters( 'scllgn_sort_comment_buttons', $buttons_short );
			}
			
			if ( 'login_form' == $form ) {
				$buttons_long = apply_filters( 'scllgn_sort_login_buttons', $buttons_long );
				$buttons_short = apply_filters( 'scllgn_sort_login_buttons', $buttons_short );
			}

			if ( 'register_form' == $form ) {
				$buttons_long = apply_filters( 'scllgn_sort_register_buttons', $buttons_long );
				$buttons_short = apply_filters( 'scllgn_sort_register_buttons', $buttons_short );
			}
			
			if ( ! empty( $buttons_short ) ) {
				$buttons_short = implode( '', $buttons_short );
				printf(
					'<div class="scllgn_buttons_block">%s</div>',
					$buttons_short
				);
			}
			if ( ! empty( $buttons_long ) ) {
				$buttons_long = implode( '', $buttons_long );
				printf(
					'<div class="scllgn_buttons_block">%s</div>',
					$buttons_long
				);
			}
		}
	}
}


add_action( 'scllgn_display_all_buttons', 'scllgn_display_all_buttons' );

?>