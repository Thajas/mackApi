<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (! class_exists ( 'Object' )) {
	require LIBRARY . 'CoreObject.php';
	class Object extends CoreObject {
		public function __construct() {
			$this->param = func_get_args ()[0];
			parent::__construct ();
		}
		public function getMode() {
			return $this->mode;
		}
		public function getSalt() {
			return $this->salt;
		}
		public function getErrorLevel() {
			return $this->errorLevel;
		}
		public function getHttpMethod() {
			return $this->methodType;
		}
		public function getDomainHost() {
			return $this->domainhost;
		}
		public function getDomainPort() {
			return $this->domainport;
		}
		public function getDomainProtocol() {
			return $this->domainprotocol;
		}
		public function getDBHost() {
			return $this->dbhost;
		}
		public function getUsername() {
			return $this->username;
		}
		public function getPassword() {
			return $this->password;
		}
		public function getDatabase() {
			return $this->database;
		}
		public function getEncoding() {
			return $this->encoding;
		}
		public function getView($data = null, $error = true) {
			require_once VIEW . 'Api.jsp';
		}
		public function setMode() {
			$this->mode = ($this->param ['debug'] !== '') ? $this->param ['debug'] : $this->getMode ();
		}
		public function setSalt() {
			$this->salt = ($this->param ['Security'] ['salt'] !== '') ? $this->param ['Security'] ['salt'] : $this->getSalt ();
		}
		public function setErrorLevel() {
			$this->errorLevel = ($this->param ['Error'] ['errorLevel'] !== '') ? $this->param ['Error'] ['errorLevel'] : $this->getErrorLevel ();
		}
		public function setHttpMethod() {
			$this->methodType = ($this->param ['Http'] ['method'] !== '') ? $this->param ['Http'] ['method'] : $this->getHttpMethod ();
		}
		public function setDomainHost() {
			$this->domainhost = ($this->param ['Domain'] [$this->ds] ['host'] !== '') ? $this->param ['Domain'] [$this->ds] ['host'] : $this->getDomainHost ();
		}
		public function setDomainPort() {
			$this->domainport = ($this->param ['Domain'] [$this->ds] ['port'] !== '') ? $this->param ['Domain'] [$this->ds] ['port'] : $this->getDomainPort ();
		}
		public function setDomainProtocol() {
			$this->domainprotocol = ($this->param ['Domain'] [$this->ds] ['protocol'] !== '') ? $this->param ['Domain'] [$this->ds] ['protocol'] : $this->getDomainProtocol ();
		}
		public function setDBHost() {
			$this->dbhost = ($this->param ['Datasources'] [$this->ds] ['host'] !== '') ? $this->param ['Datasources'] [$this->ds] ['host'] : $this->getDBHost ();
		}
		public function setUsername() {
			$this->username = ($this->param ['Datasources'] [$this->ds] ['username'] !== '') ? $this->param ['Datasources'] [$this->ds] ['username'] : $this->getUsername ();
		}
		public function setPassword() {
			$this->password = ($this->param ['Datasources'] [$this->ds] ['password'] !== '') ? $this->param ['Datasources'] [$this->ds] ['password'] : $this->getPassword ();
		}
		public function setDatabase() {
			$this->database = ($this->param ['Datasources'] [$this->ds] ['database'] !== '') ? $this->param ['Datasources'] [$this->ds] ['database'] : $this->getDatabase ();
		}
		public function setEncoding() {
			$this->encoding = ($this->param ['Datasources'] [$this->ds] ['encoding'] !== '') ? $this->param ['Datasources'] [$this->ds] ['encoding'] : $this->getEncoding ();
		}
		public function displayErrors() {
			if ($this->getMode ()) {
				$err = $this->getErrorLevel ();
				error_reporting ( $err );
				ini_set ( 'display_errors', 'on' );
			} else {
				error_reporting ( 0 );
				ini_set ( 'display_errors', 'off' );
			}
		}
		public function getClassFolder() {
			$dir = scandir ( CLASSES );
			if ($_SERVER ['REQUEST_METHOD'] === $this->getHttpMethod ()) {
				$uri = ucfirst ( end ( explode ( '/', explode ( '?', $_SERVER ['REQUEST_URI'] )['0'] ) ) ) . 'Api';
				foreach ( $dir as $dirValues ) {
					if ($dirValues === $uri) {
						return $dirValues;
					}
				}
			}
		}
		// public function handleControl() {
		// if (strtotime ( date ( 'Ymd' ) ) <= strtotime ( '20160307' )) {
		// return true;
		// } else {
		// return false;
		// }
		// }
		public function getParameters() {
			if ($this->getHttpMethod () == 'GET') {
				return $_GET;
			} else if ($this->getHttpMethod () == 'POST') {
				return $_POST;
			}
		}
	}
	$params = new ArrayIterator ( $app );
	$app = [ ];
	$params = $params->getArrayCopy ();
	$object = new Object ( $params );
	$params = [ ];
	require LIBRARY . 'Security.php';
}		
