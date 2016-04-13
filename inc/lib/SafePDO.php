<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (! class_exists ( 'SafePDO' )) {
	require CONFIG . 'app.php';
	require LIBRARY . 'Object.php';
	class SafePDO extends PDO {
		public static function exception_handler($exception) {
			// Output the exception details
			die ( 'Uncaught exception: ' . $exception->getMessage () );
		}
		public function __construct($dsn, $username = '', $password = '', $driver_options = array()) {
			
			// Temporarily change the PHP exception handler while we . . .
			set_exception_handler ( array (
					__CLASS__,
					'exception_handler' 
			) );
			
			// . . . create a PDO object
			parent::__construct ( $dsn, $username, $password, $driver_options );
			
			// Change the exception handler back to whatever it was before
			restore_exception_handler ();
		}
	}
}
// Connect to the database with defined constants
$db = new SafePDO ( 'mysql:host=' . $object->getDBHost () . ';dbname=' . $security->decode ( $object->getDatabase () ), $security->decode ( $object->getUsername () ), $security->decode ( $object->getPassword () ) );
