<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (! class_exists ( 'Security' )) {
	class Security {
		public $key = null;
		public function __construct($salt = null) {
			$this->Key = $salt;
		}
		private function safe_b64encode($string) {
			$data = base64_encode ( $string );
			$data = str_replace ( array (
					'+',
					'/',
					'=' 
			), array (
					'-',
					'_',
					'' 
			), $data );
			
			return $data;
		}
		private function safe_b64decode($string) {
			$data = str_replace ( array (
					'-',
					'_' 
			), array (
					'+',
					'/' 
			), $string );
			$mod4 = strlen ( $data ) % 4;
			if ($mod4) {
				$data .= substr ( '====', $mod4 );
			}
			
			return base64_decode ( $data );
		}
		public function encode($value) {
			if (! $value) {
				return false;
			}
			$text = $value;
			$iv_size = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
			$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
			$crypttext = mcrypt_encrypt ( MCRYPT_RIJNDAEL_256, $this->Key, $text, MCRYPT_MODE_ECB, $iv );
			
			return trim ( $this->safe_b64encode ( $crypttext ) );
		}
		public function decode($value) {
			if (! $value) {
				return false;
			}
			$crypttext = $this->safe_b64decode ( $value );
			$iv_size = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
			$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
			$decrypttext = mcrypt_decrypt ( MCRYPT_RIJNDAEL_256, $this->Key, $crypttext, MCRYPT_MODE_ECB, $iv );
			
			return trim ( $decrypttext );
		}
		public function jsonEncode($text = null) {
			static $from = array (
					'\\',
					'/',
					"\n",
					"\t",
					"\r",
					"\b",
					"\f",
					'"' 
			);
			static $to = array (
					'\\\\',
					'\\/',
					'\\n',
					'\\t',
					'\\r',
					'\\b',
					'\\f',
					'\"' 
			);
			
			return str_replace ( $from, $to, $text );
		}
	}
	$security = new Security ( $object->getSalt () );
}
