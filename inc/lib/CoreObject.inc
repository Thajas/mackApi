<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );
/**
 *
 * @abstract : CoreObject
 * @author : MontyKhanna
 *         Created : 2016-04-11
 *         Last Modified : 2016-04-11
 * @todo :
 *      
 */
abstract class CoreObject {
	/**
	 *
	 * @var : [array] $param
	 *     
	 */
	protected $param = [ ];
	/**
	 *
	 * @var : [string] $mode
	 *     
	 */
	protected $mode = null;
	/**
	 *
	 * @var : [string] $salt
	 *     
	 */
	protected $salt = null;
	/**
	 *
	 * @var : [string] $errorLevel
	 *     
	 */
	protected $errorLevel = null;
	/**
	 *
	 * @var : [string] $methodType
	 *     
	 */
	protected $methodType = null;
	/**
	 *
	 * @var : [string] $ds
	 *     
	 */
	protected $ds = null;
	/**
	 *
	 * @var : [string] $domainhost
	 *     
	 */
	protected $domainhost = null;
	/**
	 *
	 * @var : [string] $domainport
	 *     
	 */
	protected $domainport = null;
	/**
	 *
	 * @var : [string] $domainprotocol
	 *     
	 */
	protected $domainprotocol = null;
	/**
	 *
	 * @var : [string] $dbhost
	 *     
	 */
	protected $dbhost = null;
	/**
	 *
	 * @var : [string] $username
	 *     
	 */
	protected $username = null;
	/**
	 *
	 * @var : [string] $password
	 *     
	 */
	protected $password = null;
	/**
	 *
	 * @var : [string] $database
	 *     
	 */
	protected $database = null;
	/**
	 *
	 * @var : [string] $encoding
	 *     
	 */
	protected $encoding = null;
	/**
	 *
	 * @method : __construct()
	 *        
	 */
	protected function __construct() {
		$this->setMode ();
		$this->setSalt ();
		$this->setErrorLevel ();
		$this->setHttpMethod ();
		$this->ds = ($this->getMode ()) ? array_keys ( $this->param ['Datasources'] )[0] : array_keys ( $this->param ['Datasources'] )[1];
		$this->setDomainHost ();
		$this->setDomainPort ();
		$this->setDomainProtocol ();
		$this->setDBHost ();
		$this->setUsername ();
		$this->setPassword ();
		$this->setDatabase ();
		$this->setEncoding ();
		$this->displayErrors ();
	}
	/**
	 *
	 * @method : getMode
	 * @return : string
	 */
	protected function getMode() {
	}
	/**
	 *
	 * @method : getSalt
	 * @return : string
	 */
	protected function getSalt() {
	}
	/**
	 *
	 * @method : getErrorLevel
	 * @return : string
	 */
	protected function getErrorLevel() {
	}
	/**
	 *
	 * @method : getHttpMethod
	 * @return : string
	 */
	protected function getHttpMethod() {
	}
	/**
	 *
	 * @method : getDomainHost
	 * @return : string
	 */
	protected function getDomainHost() {
	}
	/**
	 *
	 * @method : getDomainPort
	 * @return : string
	 */
	protected function getDomainPort() {
	}
	/**
	 *
	 * @method : getDomainProtocol
	 * @return : string
	 */
	protected function getDomainProtocol() {
	}
	/**
	 *
	 * @method : getDBHost
	 * @return : string
	 */
	protected function getDBHost() {
	}
	/**
	 *
	 * @method : getUsername
	 * @return : string
	 */
	protected function getUsername() {
	}
	/**
	 *
	 * @method : getPassword
	 * @return : string
	 */
	protected function getPassword() {
	}
	/**
	 *
	 * @method : getDatabase
	 * @return : string
	 */
	protected function getDatabase() {
	}
	/**
	 *
	 * @method : getEncoding
	 * @return : string
	 */
	protected function getEncoding() {
	}
	/**
	 *
	 * @method : setMode
	 * @param
	 *        	: string
	 */
	protected function setMode() {
	}
	/**
	 *
	 * @method : setSalt
	 * @param
	 *        	: string
	 */
	protected function setSalt() {
	}
	/**
	 *
	 * @method : setErrorLevel
	 * @param
	 *        	: string
	 */
	protected function setErrorLevel() {
	}
	/**
	 *
	 * @method : setHttpMethod
	 * @param
	 *        	: string
	 */
	protected function setHttpMethod() {
	}
	/**
	 *
	 * @method : setDomainHost
	 * @param
	 *        	: string
	 */
	protected function setDomainHost() {
	}
	/**
	 *
	 * @method : setDomainPort
	 * @param
	 *        	: string
	 */
	protected function setDomainPort() {
	}
	/**
	 *
	 * @method : setDomainProtocol
	 * @param
	 *        	: string
	 */
	protected function setDomainProtocol() {
	}
	/**
	 *
	 * @method : setDBHost
	 * @param
	 *        	: string
	 */
	protected function setDBHost() {
	}
	/**
	 *
	 * @method : setUsername
	 * @param
	 *        	: string
	 */
	protected function setUsername() {
	}
	/**
	 *
	 * @method : setPassword
	 * @param
	 *        	: string
	 */
	protected function setPassword() {
	}
	/**
	 *
	 * @method : setDatabase
	 * @param
	 *        	: string
	 */
	protected function setDatabase() {
	}
	/**
	 *
	 * @method : setEncoding
	 * @param
	 *        	: string
	 */
	protected function setEncoding() {
	}
	/**
	 *
	 * @method : displayErrors
	 *        
	 *         This method is used to display error on basis of mode true/false.
	 */
	protected function displayErrors() {
	}
	/**
	 *
	 * @method : getClassFolder
	 * @return : directory path
	 */
	protected function getClassFolder() {
	}
	/**
	 *
	 * @method : handleControl
	 * @return : true/false
	 */
	protected function handleControl() {
	}
	/**
	 *
	 * @method : getParameters
	 * @return : array
	 */
	protected function getParameters() {
	}
}