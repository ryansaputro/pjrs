<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
/* HybridAuth Guide: http://hybridauth.github.io/hybridauth/userguide.html
/* ------------------------------------------------------------------------- */

$config =
	array(

		'Hauth_base_url' => 'social_auth/endpoint',

		"providers" => array (

			"Google" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "968829059525-qu9dk9l3e4docpnsb2nm8qj47ipvtjb8.apps.googleusercontent.com", "secret" => "q8rj_s8bG7n9aK93tyTRtz8C" ),
			),

			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "238339393314375", "secret" => "3c55baf6c338c0b461a313f7f452b517" ),
				"scope"   => "email, public_profile, user_birthday",
			),

			"Twitter" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Yahoo" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"Live" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"MySpace" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"OpenID" => array (
				"enabled" => false
			),

			"LinkedIn" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"AOL"  => array (
				"enabled" => false
			),
		),

		"debug_mode" => (ENVIRONMENT != 'production'),
		"debug_file" => APPPATH.'logs/hybridauth'.date('Y-m-d').'.php',
	);
