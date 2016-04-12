<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (! class_exists ( 'LoginApi' )) {
	require CLASSES . 'Device/DeviceDetect.inc';
	class LoginApi {
		private $obj = null;
		private $pdo = null;
		private $detect = null;
		private $action = null;
		public function __construct() {
			if (func_num_args () === 3)
				$this->obj = func_get_args ()['0'];
			$this->pdo = func_get_args ()['1'];
			$this->detect = func_get_args ()['2'];
			$this->setAction ();
		}
		public function getAction() {
			return $this->action;
		}
		public function setAction() {
			$this->action = ($this->obj->getParameters ()['action'] !== null) ? $this->obj->getParameters ()['action'] : $this->getAction ();
		}
		public function Login() {
			if ($this->detect->getDevice () === 2) // Mobile
				$username = $this->obj->getParameters ()['username']; // 'testone';
			$password = md5 ( $this->obj->getParameters ()['password'] ); // 'dea404003c3a80819f73187842f5d1de';
			$query = 'SELECT log.id, log.username, usr.email, usr.first_name, usr.last_name,
                        usr.contact, usr.state,usr.city, usr.address_one, usr.address_two
                        FROM logins as log
                        JOIN users as usr ON log.id = usr.logins_id
                        WHERE true
                        AND (log.username = ? OR usr.email = ?)
                        AND log.password = ?';
			$conn = $this->pdo->prepare ( $query );
			$conn->bindParam ( 1, $username, 2 );
			$conn->bindParam ( 2, $username, 2 );
			$conn->bindParam ( 3, $password, 2 );
			$conn->execute ();
			$result = $conn->fetchAll ( 2 );
			if (count ( $result ) > 0) {
				echo json_encode ( $result [0] );
			} else {
				echo 'Invalid username or password';
			}
		}
		public function Logout() {
			echo "From Logout";
		}
	}
	$loginApi = new LoginApi ( $object, $db, $detect );
	$loginApi->$actionValue [$loginApi->getAction ()] ();
}
