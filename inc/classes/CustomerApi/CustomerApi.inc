<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (! class_exists ( 'CustomerApi' )) {
	require CLASSES . 'Device/DeviceDetect.inc';
	class CustomerApi {
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
		public function __destruct() {
			$this->obj = null;
			$this->pdo = null;
			$this->detect = null;
		}
		public function getAction() {
			return $this->action;
		}
		public function setAction() {
			$this->action = ($this->obj->getParameters ()['action'] !== null) ? $this->obj->getParameters ()['action'] : $this->getAction ();
		}
		public function customerSearch() {
			if ($this->detect->getDevice () === 2) // Mobile
				$keyword = $this->obj->getParameters ()['keyword'];
			$query = "SELECT cus.name, cus.address_one, cus.address_two, cus.state, cus.city,
                        cus.ticket_no, cus.entry_time, cus.initiated_by, cus.meeting_trigger,
                        cus.meeting_type, cus.duration, cus.req_created
                        FROM customers as cus
                        WHERE true
                        AND cus.status = 't' AND cus.is_delete IS true AND cus.name like ?";
			$conn = $this->pdo->prepare ( $query );
			$conn->bindParam ( 1, $keyword, 2 );
			$conn->execute ();
			$result = $conn->fetchAll ( 2 );
			header('Content-Type: application/json');
			if (count ( $result ) > 0) {
				echo json_encode ( array (
						'status' => 1,
						'data' => array_filter ( $result [0] ) 
				), JSON_PRETTY_PRINT );
			} else {
				echo json_encode ( array (
						'status' => 0,
						'error_code' => 400,
						'message' => 'Invalid search keyword' 
				), JSON_PRETTY_PRINT );
			}
			exit();
		}
		public function customerRegister() {
			echo "From customer register";
		}
	}
	$customerapi = new CustomerApi ( $object, $db, $detect );
	$customerapi->$actionValue [$customerapi->getAction ()] ();
}
