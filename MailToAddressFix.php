<?php
/*
Plugin Name: Mail To Address Fix
Plugin URI:  http://github.com/sumbudy
Description: Due to some strange bug with PHPs built-in mail() function, this plugin filters wp_mail() to ensure that "to" addresses with a recipient name are removed.
Version:     1.0
Author:      Chris Kruse
Author URI:  http://github.com/sumbudy
License:     GPLv3
*/

class MailToAddressFix {

	public static function init() 
	{
		add_filter('wp_mail', array('MailToAddressFix', 'fix_to_address'));
	}

	public static function fix_to_address( $data ) 
	{
		$to = $data['to'];

		//to address provided?
		if( empty($to) )
			return $data;

		//check for multiple email addresses
		if( ! is_array($to) )
			$to = explode(',', $to);

		//trim addresses
		foreach( $to as $index => $address )
			$to[$index] = trim($address);

		//check for invalid addresses
		foreach( $to as $index => $address ) {
			$is_valid = filter_var($address, FILTER_VALIDATE_EMAIL);

			if( ! $is_valid ) {
				$parts = explode(' ', $address);
				$email = false;

				foreach( $parts as $part ) {
					if( strpos($part, '@') !== false )
						$email = $part;
				}

				//did we find an email
				if( ! $email )
					continue;

				//check for <
				if( strpos($email, '<') === 0 )
					$email = substr($email, 1);

				//check for >
				if( strpos($email, '>') === (strlen($email)-1) )
					$email = substr($email, 0, strlen($email)-1);

				$to[$index] = $email;

			}

		}

		//save filtered addresses and return
		$data['to'] = $to;
		return $data;
	}

}

