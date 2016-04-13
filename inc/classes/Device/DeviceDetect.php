<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

if (!class_exists('Device_Detect')) {
	require LIBRARY . 'MobileDetect.php';
	class Device_Detect extends Mobile_Detect{

		/**
		 * 2015-11-10 -> Eduardo Salom -> Added Edge Browser support
		 *
		 * File: Browser.php
		 * Author: Chris Schuld (http://chrisschuld.com/)
		 * Last Modified: July 4th, 2014
		 * @version 1.9
		 * @package PegasusPHP
		 *
		 * Copyright (C) 2008-2010 Chris Schuld  (chris@chrisschuld.com)
		 *
		 * This program is free software; you can redistribute it and/or
		 * modify it under the terms of the GNU General Public License as
		 * published by the Free Software Foundation; either version 2 of
		 * the License, or (at your option) any later version.
		 *
		 * This program is distributed in the hope that it will be useful,
		 * but WITHOUT ANY WARRANTY; without even the implied warranty of
		 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		 * GNU General Public License for more details at:
		 * http://www.gnu.org/copyleft/gpl.html
		 *
		 *
		 * Typical Usage:
		 *
		 *   $browser = new Browser();
		 *   if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
		 *    echo 'You have FireFox version 2 or greater';
		 *   }
		 *
		 * User Agents Sampled from: http://www.useragentstring.com/
		 *
		 * This implementation is based on the original work from Gary White
		 * http://apptools.com/phptools/browser/
		 *
		 */
		private $_agent = '';
		private $_browser_name = '';
		private $_version = '';
		private $_platform = '';
		private $_os = '';
		private $_is_aol = false;
		private $_is_mobile = false;
		private $_is_tablet = false;
		private $_is_robot = false;
		private $_aol_version = '';

		const VERSION_UNKNOWN = 'unknown';

		/**
		 * Available Devices
		 * @var array
		 */
		private $devices = array(
			'0' => 'Unknown',
			'1' => 'Desktop',
			'2' => 'Mobile',
			'3' => 'Tablet'
		);

		/**
		 * This array contains all available browsers
		 * @var array
		 */
		private $browser = array(
			'OPERA' => 'Opera', 'OPERA_MINI'=> 'Opera Mini', 'WEBTV' => 'WebTV', 'IE' => 'Internet Explorer', 'KONQUEROR' => 'Konqueror',
			'ICAB' => 'Icab', 'OMNIWEB' => 'OmniWeb', 'FIREBIRD' => 'Firebird', 'FIREFOX' => 'Firefox', 'ICEWEASEL' => 'Iceweasel',
			'SHIRETOKO' => 'Shiretoko', 'MOZILLA' => 'Mozilla', 'AMAYA' => 'Amaya', 'LYNX' => 'Lynx', 'SAFARI' => 'Safari', 'IPHONE' => 'iPhone',
			'IPOD' => 'iPod', 'IPAD' => 'iPad', 'CHROME' => 'Chrome', 'ANDROID' => 'Android', 'GOOGLEBOT' => 'GoogleBot', 'SLURP' => 'Yahoo! Slurp',
			'W3C_VALIDATOR' => 'w3C Validator', 'BLACKBERRY' => 'BlackBerry', 'ICECAT' => 'iceCat', 'NOKIA_S60' => 'Nokia S60 OS Browser',
			'NOKIA' => 'Nokia Browser', 'MSN' => 'MSN Browser', 'MSNBOT' => 'MSN Bot', 'EDGE' => 'Edge', 'NETSCAPE_NAVIGATOR' => 'Netscape Navigator',
			'GALEON' => 'Galeon', 'NETPOSITIVE' => 'NetPositive', 'PHOENIX' => 'Phoenix', 'POCKET_IE' => 'Pocket Internet Explorer',
			'UNKNOWN' => 'Unknown'
		);

		/**
		 * This array contains all available platforms
		 * @var array
		 */
		private $platform = array(
			'WINDOWS' => 'Windows', 'WINDOWS_CE' => 'Windows CE', 'APPLE' => 'Apple', 'OS2' => 'OS/2',
			'BEOS' => 'BeOS', 'IPHONE' => 'iPhone', 'IPOD' => 'iPod', 'IPAD' => 'iPad', 'BLACKBERRY' => 'BlackBerry',
			'NOKIA' => 'Nokia', 'FREEBSD' => 'FreeBSD', 'OPENBSD' => 'OpenBSD', 'NETBSD' => 'NetBSD', 'SUNOS' => 'SunOS', 'LINUX' => 'Linux',
			'OPENSOLARIS' => 'OpenSolaris', 'ANDROID' => 'Android', 'ANDROID_TABLET' => 'Android Tablet',
			'XBOX' => 'Xbox', 'XBOX_ONE' => 'Xbox One', 'PLAYSTATION' => 'PlayStation', 'PLAYSTATION_4' => 'PlayStation 4',
			'UNKNOWN' => 'Unknown'
		);

		/**
		 * Contains a relation devices => related platforms
		 * @var array
		 */
		private $platform_devices = array(
			'1' => array('Windows', 'Windows CE', 'Apple', 'OS/2', 'BeOS', 'FreeBSD', 'OpenBSD', 'SunOS', 'Linux', 'OpenSolaris', 'Xbox', 'Xbox One', 'PlayStation', 'PlayStation 4'),
			'2' => array('iPhone', 'iPod', 'BlackBerry', 'Nokia', 'Android'),
			'3' => array('iPad', 'Android Tablet')
		);

		const OPERATING_SYSTEM_UNKNOWN = 'unknown';

		/**
		 * @param string $useragent
		 */
		public function __construct(
			array $headers = null,
			$userAgent = null
		){
			parent::__construct($headers, $userAgent);
		}

		/**
		 * Reset all properties
		 */
		public function reset() {
			$this->_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$this->_browser_name = $this->browser['UNKNOWN'];
			$this->_version = self::VERSION_UNKNOWN;
			$this->_platform = $this->platform['UNKNOWN'];
			$this->_os = self::OPERATING_SYSTEM_UNKNOWN;
			$this->_is_aol = false;
			$this->_is_mobile = false;
			$this->_is_tablet = false;
			$this->_is_robot = false;
			$this->_aol_version = self::VERSION_UNKNOWN;
		}

		/**
		 * Check to see if the specific browser is valid
		 * @param string $browserName
		 * @return True if the browser is the specified browser
		 */
		function isBrowser($browserName) { return( 0 == strcasecmp($this->_browser_name, trim($browserName))); }

		/**
		 * The name of the browser.  All return types are from the class contants
		 * @return string Name of the browser
		 */
		public function getBrowser() { return $this->_browser_name; }
		/**
		 * Set the name of the browser
		 * @param $browser The name of the Browser
		 */
		public function setBrowser($browser) { return $this->_browser_name = $browser; }
		/**
		 * The name of the platform.  All return types are from the class contants
		 * @return string Name of the browser
		 */
		public function getPlatform() { return $this->_platform; }
		/**
		 * Set the name of the platform
		 * @param $platform The name of the Platform
		 */
		public function setPlatform($platform) { return $this->_platform = $platform; }
		/**
		 * The version of the browser.
		 * @return string Version of the browser (will only contain alpha-numeric characters and a period)
		 */
		public function getVersion() { return $this->_version; }
		/**
		 * Set the version of the browser
		 * @param $version The version of the Browser
		 */
		public function setVersion($version) { $this->_version = preg_replace('/[^0-9,.,a-z,A-Z-]/','',$version); }
		/**
		 * The version of AOL.
		 * @return string Version of AOL (will only contain alpha-numeric characters and a period)
		 */
		public function getAolVersion() { return $this->_aol_version; }
		/**
		 * Set the version of AOL
		 * @param $version The version of AOL
		 */
		public function setAolVersion($version) { $this->_aol_version = preg_replace('/[^0-9,.,a-z,A-Z]/','',$version); }
		/**
		 * Is the browser from AOL?
		 * @return boolean True if the browser is from AOL otherwise false
		 */
		public function isAol() { return $this->_is_aol; }
		/**
		 * Is the browser from a mobile device?
		 * @return boolean True if the browser is from a mobile device otherwise false
		 */
		/*
		public function isMobile() { return $this->_is_mobile; }
		*/
		/**
		 * Is the device from a tablet device?
		 * @return boolean True if the browser is from a table device otherwise false
		 */
		/*
		public function isTablet() { return $this->_is_tablet; }
		*/
		/**
		 * Is the browser from a robot (ex Slurp,GoogleBot)?
		 * @return boolean True if the browser is from a robot otherwise false
		 */
		public function isRobot() { return $this->_is_robot; }
		/**
		 * Set the browser to be from AOL
		 * @param $isAol
		 */
		public function setAol($isAol) { $this->_is_aol = $isAol; }
		/**
		 * Set the Browser to be mobile
		 * @param boolean $value is the browser a mobile brower or not
		 */
		protected function setMobile($value=true) { $this->_is_mobile = $value; }
		/**
		 * Set the device to be tablet
		 * @param boolean $value is the device a tablet device or not
		 */
		protected function setTablet($value=true) { $this->_is_tablet = $value; }
		/**
		 * Set the Browser to be a robot
		 * @param boolean $value is the browser a robot or not
		 */
		protected function setRobot($value=true) { $this->_is_robot = $value; }
		/**
		 * Get the user agent value in use to determine the browser
		 * @return string The user agent from the HTTP header
		 */
		public function getUserAgent() { return $this->_agent; }
		/**
		 * Set the user agent value (the construction will use the HTTP header value - this will overwrite it)
		 * @param $agent_string The value for the User Agent
		 */
		public function setUserAgent($agent_string) {
			$this->reset();
			if($agent_string != null && strlen($agent_string) > 0){
				$this->_agent = $agent_string;
			}
			$this->determine();
		}
		/**
		 * Used to determine if the browser is actually "chromeframe"
		 * @since 1.7
		 * @return boolean True if the browser is using chromeframe
		 */
		public function isChromeFrame() {
			return( strpos($this->_agent,"chromeframe") !== false );
		}
		/**
		 * Returns a formatted string with a summary of the details of the browser.
		 * @return string formatted string with a summary of the browser
		 */
		public function __toString() {
			return "<strong>Browser Name:</strong>{$this->getBrowser()}<br/>\n" .
			"<strong>Browser Version:</strong>{$this->getVersion()}<br/>\n" .
			"<strong>Browser User Agent String:</strong>{$this->getUserAgent()}<br/>\n" .
			"<strong>Platform:</strong>{$this->getPlatform()}<br/>";
		}
		/**
		 * Protected routine to calculate and determine what the browser is in use (including platform)
		 */
		protected function determine() {
			$this->checkPlatform();
			$this->checkBrowsers();
			$this->checkForAol();
		}
		/**
		 * Protected routine to determine the browser type
		 * @return boolean True if the browser was detected otherwise false
		 */
		protected function checkBrowsers() {
			/**
			 * @todo add checkBrowserEdge() method
			 */
			return (
				// well-known, well-used
				// Special Notes:
				// (1) Opera must be checked before FireFox due to the odd
				//     user agents used in some older versions of Opera
				// (2) WebTV is strapped onto Internet Explorer so we must
				//     check for WebTV before IE
				// (3) (deprecated) Galeon is based on Firefox and needs to be
				//     tested before Firefox is tested
				// (4) OmniWeb is based on Safari so OmniWeb check must occur
				//     before Safari
				// (5) Netscape 9+ is based on Firefox so Netscape checks
				//     before FireFox are necessary
				$this->checkBrowserWebTv() ||
				$this->checkBrowserInternetExplorer() ||
				$this->checkBrowserOpera() ||
				$this->checkBrowserGaleon() ||
				$this->checkBrowserNetscapeNavigator9Plus() ||
				$this->checkBrowserEdge() ||
				$this->checkBrowserFirefox() ||
				$this->checkBrowserChrome() ||
				$this->checkBrowserOmniWeb() ||

				// common mobile
				$this->checkBrowserAndroid() ||
				$this->checkBrowseriPad() ||
				$this->checkBrowseriPod() ||
				$this->checkBrowseriPhone() ||
				$this->checkBrowserBlackBerry() ||
				$this->checkBrowserNokia() ||

				// common bots
				$this->checkBrowserGoogleBot() ||
				$this->checkBrowserMSNBot() ||
				$this->checkBrowserSlurp() ||

				// WebKit base check (post mobile and others)
				$this->checkBrowserSafari() ||

				// everyone else
				$this->checkBrowserNetPositive() ||
				$this->checkBrowserFirebird() ||
				$this->checkBrowserKonqueror() ||
				$this->checkBrowserIcab() ||
				$this->checkBrowserPhoenix() ||
				$this->checkBrowserAmaya() ||
				$this->checkBrowserLynx() ||

				$this->checkBrowserShiretoko() ||
				$this->checkBrowserIceCat() ||
				$this->checkBrowserW3CValidator() ||
				$this->checkBrowserMozilla() /* Mozilla is such an open standard that you must check it last */
			);
		}

		/**
		 * Determine if the user is using a BlackBerry (last updated 1.7)
		 * @return boolean True if the browser is the BlackBerry browser otherwise false
		 */
		protected function checkBrowserBlackBerry() {
			if( stripos($this->_agent,'blackberry') !== false ) {
				$aresult = explode("/",stristr($this->_agent,"BlackBerry"));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->_browser_name = $this->browser['BLACKBERRY'];
				$this->setMobile(true);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the user is using an AOL User Agent (last updated 1.7)
		 * @return boolean True if the browser is from AOL otherwise false
		 */
		protected function checkForAol() {
			$this->setAol(false);
			$this->setAolVersion(self::VERSION_UNKNOWN);

			if( stripos($this->_agent,'aol') !== false ) {
				$aversion = explode(' ',stristr($this->_agent, 'AOL'));
				$this->setAol(true);
				$this->setAolVersion(preg_replace('/[^0-9\.a-z]/i', '', $aversion[1]));
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is the GoogleBot or not (last updated 1.7)
		 * @return boolean True if the browser is the GoogletBot otherwise false
		 */
		protected function checkBrowserGoogleBot() {
			if( stripos($this->_agent,'googlebot') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'googlebot'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion(str_replace(';','',$aversion[0]));
				$this->_browser_name = $this->browser['GOOGLEBOT'];
				$this->setRobot(true);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is the MSNBot or not (last updated 1.9)
		 * @return boolean True if the browser is the MSNBot otherwise false
		 */
		protected function checkBrowserMSNBot() {
			if( stripos($this->_agent,"msnbot") !== false ) {
				$aresult = explode("/",stristr($this->_agent,"msnbot"));
				$aversion = explode(" ",$aresult[1]);
				$this->setVersion(str_replace(";","",$aversion[0]));
				$this->_browser_name = $this->browser['MSNBOT'];
				$this->setRobot(true);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is the W3C Validator or not (last updated 1.7)
		 * @return boolean True if the browser is the W3C Validator otherwise false
		 */
		protected function checkBrowserW3CValidator() {
			if( stripos($this->_agent,'W3C-checklink') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'W3C-checklink'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->_browser_name = $this->browser['W3C_VALIDATOR'];
				return true;
			}
			else if( stripos($this->_agent,'W3C_Validator') !== false ) {
				// Some of the Validator versions do not delineate w/ a slash - add it back in
				$ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->_agent);
				$aresult = explode('/',stristr($ua,'W3C_Validator'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->_browser_name = $this->browser['W3C_VALIDATOR'];
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is the Yahoo! Slurp Robot or not (last updated 1.7)
		 * @return boolean True if the browser is the Yahoo! Slurp Robot otherwise false
		 */
		protected function checkBrowserSlurp() {
			if( stripos($this->_agent,'slurp') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Slurp'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->_browser_name = $this->browser['SLURP'];
				$this->setRobot(true);
				$this->setMobile(false);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Internet Explorer or not (last updated 1.7)
		 * @return boolean True if the browser is Internet Explorer otherwise false
		 */
		protected function checkBrowserInternetExplorer() {

			// Test for v1 - v1.5 IE
			if( stripos($this->_agent,'microsoft internet explorer') !== false ) {
				$this->setBrowser($this->browser['IE']);
				$this->setVersion('1.0');
				$aresult = stristr($this->_agent, '/');
				if( preg_match('/308|425|426|474|0b1/i', $aresult) ) {
					$this->setVersion('1.5');
				}
				return true;
			}
			// Test for versions > 1.5
			else if( stripos($this->_agent,'msie') !== false && stripos($this->_agent,'opera') === false ) {
				// See if the browser is the odd MSN Explorer
				if( stripos($this->_agent,'msnb') !== false ) {
					$aresult = explode(' ',stristr(str_replace(';','; ',$this->_agent),'MSN'));
					$this->setBrowser( $this->browser['MSN'] );
					$this->setVersion(str_replace(array('(',')',';'),'',$aresult[1]));
					return true;
				}
				$aresult = explode(' ',stristr(str_replace(';','; ',$this->_agent),'msie'));
				$this->setBrowser( $this->browser['IE'] );
				$this->setVersion(str_replace(array('(',')',';'),'',$aresult[1]));
				return true;
			}
			// Test for Pocket IE
			else if( stripos($this->_agent,'mspie') !== false || stripos($this->_agent,'pocket') !== false ) {
				$aresult = explode(' ',stristr($this->_agent,'mspie'));
				$this->setPlatform( $this->platform['WINDOWS_CE'] );
				$this->setBrowser( $this->browser['POCKET_IE'] );
				$this->setMobile(true);

				if( stripos($this->_agent,'mspie') !== false ) {
					$this->setVersion($aresult[1]);
				}
				else {
					$aversion = explode('/',$this->_agent);
					$this->setVersion($aversion[1]);
				}
				return true;
			}elseif(stripos($this->_agent, 'trident') !== false){
				/**
				 * Window Phone check
				 */
				if(stripos($this->_agent, 'iemobile') !== false){
					$tmp = explode('/', stristr($this->_agent, 'iemobile'));
					$tmp = explode(';', $tmp[1]);
					$this->setVersion($tmp[0]);
				}else{
					$tmp = explode('rv:', stristr($this->_agent, 'trident'));
					$tmp = explode(')', $tmp[1]);
					if(isset($tmp[0])){
						$this->setVersion($tmp[0]);
					}else{
						$this->setVersion(self::VERSION_UNKNOWN);
					}
				}
				$this->setBrowser($this->browser['IE']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Opera or not (last updated 1.7)
		 * @return boolean True if the browser is Opera otherwise false
		 */
		protected function checkBrowserOpera() {
			if( stripos($this->_agent,'opera mini') !== false ) {
				$resultant = stristr($this->_agent, 'opera mini');
				if( preg_match('/\//',$resultant) ) {
					$aresult = explode('/',$resultant);
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$aversion = explode(' ',stristr($resultant,'opera mini'));
					$this->setVersion($aversion[1]);
				}
				$this->_browser_name = $this->browser['OPERA_MINI'];
				$this->setMobile(true);
				return true;
			}
			else if( stripos($this->_agent,'opera') !== false ) {
				$resultant = stristr($this->_agent, 'opera');
				if( preg_match('/Version\/(10.*)$/',$resultant,$matches) ) {
					$this->setVersion($matches[1]);
				}
				else if( preg_match('/\//',$resultant) ) {
					$aresult = explode('/',str_replace("("," ",$resultant));
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$aversion = explode(' ',stristr($resultant,'opera'));
					$this->setVersion(isset($aversion[1])?$aversion[1]:"");
				}
				$this->_browser_name = $this->browser['OPERA'];
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Chrome or not (last updated 1.7)
		 * @return boolean True if the browser is Chrome otherwise false
		 */
		protected function checkBrowserChrome() {
			if( stripos($this->_agent,'Chrome') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Chrome'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['CHROME']);
				return true;
			}
			return false;
		}


		/**
		 * Determine if the browser is WebTv or not (last updated 1.7)
		 * @return boolean True if the browser is WebTv otherwise false
		 */
		protected function checkBrowserWebTv() {
			if( stripos($this->_agent,'webtv') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'webtv'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['WEBTV']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is NetPositive or not (last updated 1.7)
		 * @return boolean True if the browser is NetPositive otherwise false
		 */
		protected function checkBrowserNetPositive() {
			if( stripos($this->_agent,'NetPositive') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'NetPositive'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion(str_replace(array('(',')',';'),'',$aversion[0]));
				$this->setBrowser($this->browser['NETPOSITIVE']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Galeon or not (last updated 1.7)
		 * @return boolean True if the browser is Galeon otherwise false
		 */
		protected function checkBrowserGaleon() {
			if( stripos($this->_agent,'galeon') !== false ) {
				$aresult = explode(' ',stristr($this->_agent,'galeon'));
				$aversion = explode('/',$aresult[0]);
				$this->setVersion($aversion[1]);
				$this->setBrowser($this->browser['GALEON']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Konqueror or not (last updated 1.7)
		 * @return boolean True if the browser is Konqueror otherwise false
		 */
		protected function checkBrowserKonqueror() {
			if( stripos($this->_agent,'Konqueror') !== false ) {
				$aresult = explode(' ',stristr($this->_agent,'Konqueror'));
				$aversion = explode('/',$aresult[0]);
				$this->setVersion($aversion[1]);
				$this->setBrowser($this->browser['KONQUEROR']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is iCab or not (last updated 1.7)
		 * @return boolean True if the browser is iCab otherwise false
		 */
		protected function checkBrowserIcab() {
			if( stripos($this->_agent,'icab') !== false ) {
				$aversion = explode(' ',stristr(str_replace('/',' ',$this->_agent),'icab'));
				$this->setVersion($aversion[1]);
				$this->setBrowser($this->browser['ICAB']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is OmniWeb or not (last updated 1.7)
		 * @return boolean True if the browser is OmniWeb otherwise false
		 */
		protected function checkBrowserOmniWeb() {
			if( stripos($this->_agent,'omniweb') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'omniweb'));
				$aversion = explode(' ',isset($aresult[1])?$aresult[1]:"");
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['OMNIWEB']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Phoenix or not (last updated 1.7)
		 * @return boolean True if the browser is Phoenix otherwise false
		 */
		protected function checkBrowserPhoenix() {
			if( stripos($this->_agent,'Phoenix') !== false ) {
				$aversion = explode('/',stristr($this->_agent,'Phoenix'));
				$this->setVersion($aversion[1]);
				$this->setBrowser($this->browser['PHOENIX']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Firebird or not (last updated 1.7)
		 * @return boolean True if the browser is Firebird otherwise false
		 */
		protected function checkBrowserFirebird() {
			if( stripos($this->_agent,'Firebird') !== false ) {
				$aversion = explode('/',stristr($this->_agent,'Firebird'));
				$this->setVersion($aversion[1]);
				$this->setBrowser($this->browser['FIREBIRD']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Netscape Navigator 9+ or not (last updated 1.7)
		 * NOTE: (http://browser.netscape.com/ - Official support ended on March 1st, 2008)
		 * @return boolean True if the browser is Netscape Navigator 9+ otherwise false
		 */
		protected function checkBrowserNetscapeNavigator9Plus() {
			if( stripos($this->_agent,'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i',$this->_agent,$matches) ) {
				$this->setVersion($matches[1]);
				$this->setBrowser($this->browser['NETSCAPE_NAVIGATOR']);
				return true;
			}
			else if( stripos($this->_agent,'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i',$this->_agent,$matches) ) {
				$this->setVersion($matches[1]);
				$this->setBrowser($this->browser['NETSCAPE_NAVIGATOR']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Shiretoko or not (https://wiki.mozilla.org/Projects/shiretoko) (last updated 1.7)
		 * @return boolean True if the browser is Shiretoko otherwise false
		 */
		protected function checkBrowserShiretoko() {
			if( stripos($this->_agent,'Mozilla') !== false && preg_match('/Shiretoko\/([^ ]*)/i',$this->_agent,$matches) ) {
				$this->setVersion($matches[1]);
				$this->setBrowser($this->browser['SHIRETOKO']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Ice Cat or not (http://en.wikipedia.org/wiki/GNU_IceCat) (last updated 1.7)
		 * @return boolean True if the browser is Ice Cat otherwise false
		 */
		protected function checkBrowserIceCat() {
			if( stripos($this->_agent,'Mozilla') !== false && preg_match('/IceCat\/([^ ]*)/i',$this->_agent,$matches) ) {
				$this->setVersion($matches[1]);
				$this->setBrowser($this->browser['ICECAT']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Nokia or not (last updated 1.7)
		 * @return boolean True if the browser is Nokia otherwise false
		 */
		protected function checkBrowserNokia() {
			if( preg_match("/Nokia([^\/]+)\/([^ SP]+)/i",$this->_agent,$matches) ) {
				$this->setVersion($matches[2]);
				if( stripos($this->_agent,'Series60') !== false || strpos($this->_agent,'S60') !== false ) {
					$this->setBrowser($this->browser['NOKIA_S60']);
				}
				else {
					$this->setBrowser( $this->browser['NOKIA'] );
				}
				$this->setMobile(true);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Firefox or not (last updated 1.7)
		 * @return boolean True if the browser is Firefox otherwise false
		 */
		protected function checkBrowserFirefox() {
			if( stripos($this->_agent,'safari') === false ) {
				if( preg_match("/Firefox[\/ \(]([^ ;\)]+)/i",$this->_agent,$matches) ) {
					$this->setVersion($matches[1]);
					$this->setBrowser($this->browser['FIREFOX']);
					return true;
				}
				else if( preg_match("/Firefox$/i",$this->_agent,$matches) ) {
					$this->setVersion("");
					$this->setBrowser($this->browser['FIREFOX']);
					return true;
				}
			}
			return false;
		}

		/**
		 * Determine if the browser is Firefox or not (last updated 1.7)
		 * @return boolean True if the browser is Firefox otherwise false
		 */
		protected function checkBrowserIceweasel() {
			if( stripos($this->_agent,'Iceweasel') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Iceweasel'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['ICEWEASEL']);
				return true;
			}
			return false;
		}
		/**
		 * Determine if the browser is Mozilla or not (last updated 1.7)
		 * @return boolean True if the browser is Mozilla otherwise false
		 */
		protected function checkBrowserMozilla() {
			if( stripos($this->_agent,'mozilla') !== false  && preg_match('/rv:[0-9].[0-9][a-b]?/i',$this->_agent) && stripos($this->_agent,'netscape') === false) {
				$aversion = explode(' ',stristr($this->_agent,'rv:'));
				preg_match('/rv:[0-9].[0-9][a-b]?/i',$this->_agent,$aversion);
				$this->setVersion(str_replace('rv:','',$aversion[0]));
				$this->setBrowser($this->browser['MOZILLA']);
				return true;
			}
			else if( stripos($this->_agent,'mozilla') !== false && preg_match('/rv:[0-9]\.[0-9]/i',$this->_agent) && stripos($this->_agent,'netscape') === false ) {
				$aversion = explode('',stristr($this->_agent,'rv:'));
				$this->setVersion(str_replace('rv:','',$aversion[0]));
				$this->setBrowser($this->browser['MOZILLA']);
				return true;
			}
			else if( stripos($this->_agent,'mozilla') !== false  && preg_match('/mozilla\/([^ ]*)/i',$this->_agent,$matches) && stripos($this->_agent,'netscape') === false ) {
				$this->setVersion($matches[1]);
				$this->setBrowser($this->browser['MOZILLA']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Lynx or not (last updated 1.7)
		 * @return boolean True if the browser is Lynx otherwise false
		 */
		protected function checkBrowserLynx() {
			if( stripos($this->_agent,'lynx') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Lynx'));
				$aversion = explode(' ',(isset($aresult[1])?$aresult[1]:""));
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['LYNX']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Amaya or not (last updated 1.7)
		 * @return boolean True if the browser is Amaya otherwise false
		 */
		protected function checkBrowserAmaya() {
			if( stripos($this->_agent,'amaya') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Amaya'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->setBrowser($this->browser['AMAYA']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Safari or not (last updated 1.7)
		 * @return boolean True if the browser is Safari otherwise false
		 */
		protected function checkBrowserSafari() {
			if( stripos($this->_agent,'Safari') !== false && stripos($this->_agent,'iPhone') === false && stripos($this->_agent,'iPod') === false ) {
				$aresult = explode('/',stristr($this->_agent,'Version'));
				if( isset($aresult[1]) ) {
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$this->setVersion(self::VERSION_UNKNOWN);
				}
				$this->setBrowser($this->browser['SAFARI']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is iPhone or not (last updated 1.7)
		 * @return boolean True if the browser is iPhone otherwise false
		 */
		protected function checkBrowseriPhone() {
			if( stripos($this->_agent,'iPhone') !== false ) {
				if(stripos($this->_agent,'Version') !== false){
					$aresult = explode('/',stristr($this->_agent,'Version'));
					if( isset($aresult[1]) ) {
						$aversion = explode(' ',$aresult[1]);
						$this->setVersion($aversion[0]);
					}
					else {
						$this->setVersion(self::VERSION_UNKNOWN);
					}
					$this->setMobile(true);
					if(stripos($aresult[2],'Safari') !== false){
						// Check if the browser is Safari
						$this->setBrowser($this->browser['SAFARI']);
					}else{
						$this->setBrowser($this->browser['IPHONE']);
					}
				}elseif(stripos($this->_agent,'Safari') !== false){
					$aresult = explode('/',stristr($this->_agent,'Safari'));
					if( isset($aresult[1]) ) {
						$aversion = explode(' ',$aresult[1]);
						$this->setVersion($aversion[0]);
					}
					else {
						$this->setVersion(self::VERSION_UNKNOWN);
					}
					$this->setBrowser($this->browser['SAFARI']);
				}

				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is iPod or not (last updated 1.7)
		 * @return boolean True if the browser is iPod otherwise false
		 */
		protected function checkBrowseriPad() {
			if( stripos($this->_agent,'iPad') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Version'));
				if( isset($aresult[1]) ) {
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$this->setVersion(self::VERSION_UNKNOWN);
				}
				$this->setMobile(true);
				$this->setBrowser($this->browser['IPAD']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is iPod or not (last updated 1.7)
		 * @return boolean True if the browser is iPod otherwise false
		 */
		protected function checkBrowseriPod() {
			if( stripos($this->_agent,'iPod') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Version'));
				if( isset($aresult[1]) ) {
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$this->setVersion(self::VERSION_UNKNOWN);
				}
				$this->setMobile(true);
				$this->setBrowser($this->browser['IPOD']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Android or not (last updated 1.7)
		 * @return boolean True if the browser is Android otherwise false
		 */
		protected function checkBrowserAndroid() {
			if( stripos($this->_agent,'Android') !== false ) {
				$aresult = explode(' ',stristr($this->_agent,'Android'));
				if( isset($aresult[1]) ) {
					$aversion = explode(' ',$aresult[1]);
					$this->setVersion($aversion[0]);
				}
				else {
					$this->setVersion(self::VERSION_UNKNOWN);
				}
				$this->setMobile(true);
				$this->setBrowser($this->browser['ANDROID']);
				return true;
			}
			return false;
		}

		/**
		 * Determine if the browser is Microsoft Edge or not
		 * @return boolean True if the browser is Edge otherwise false
		 */
		protected function checkBrowserEdge(){
			if(stripos($this->_agent, 'Edge') !== false){
				$tmp = explode('/',stristr($this->_agent,'Edge'));
				if(isset($tmp[1])){
					$tmp = explode(' ',$tmp[1]);
					$this->setVersion($tmp[0]);
				}else{
					$this->setVersion(self::VERSION_UNKNOWN);
				}
				$this->setBrowser($this->browser['EDGE']);
				return true;
			}
			return false;
		}

		/**
		 * Determine the user's platform (last updated 1.7)
		 */
		protected function checkPlatform() {
			if( stripos($this->_agent, 'windows') !== false ) {
				if(stripos($this->_agent, 'xbox one') !== false){
					//Xbox One
					$this->_platform = $this->platform['XBOX_ONE'];
				}elseif(stripos($this->_agent, 'xbox') !== false){
					//Xbox
					$this->_platform = $this->platform['XBOX'];
				}else{
					$this->_platform = $this->platform['WINDOWS'];
				}
			}
			else if( stripos($this->_agent, 'iPad') !== false ) {
				$this->_platform = $this->platform['IPAD'];
			}
			else if( stripos($this->_agent, 'iPod') !== false ) {
				$this->_platform = $this->platform['IPOD'];
			}
			else if( stripos($this->_agent, 'iPhone') !== false ) {
				$this->_platform = $this->platform['IPHONE'];
			}
			elseif( stripos($this->_agent, 'mac') !== false ) {
				$this->_platform = $this->platform['APPLE'];
			}
			elseif( stripos($this->_agent, 'android') !== false ) {
				if( stripos($this->_agent, 'Mobile') !== false ) {
					$this->_platform = $this->platform['ANDROID'];
				} else {
					$this->_platform = $this->platform['ANDROID_TABLET'];
				}
			}
			elseif( stripos($this->_agent, 'linux') !== false ) {
				$this->_platform = $this->platform['LINUX'];
			}
			else if( stripos($this->_agent, 'Nokia') !== false ) {
				$this->_platform = $this->platform['NOKIA'];
			}
			else if( stripos($this->_agent, 'BlackBerry') !== false ) {
				$this->_platform = $this->platform['BLACKBERRY'];
			}
			elseif( stripos($this->_agent,'FreeBSD') !== false ) {
				$this->_platform = $this->platform['FREEBSD'];
			}
			elseif( stripos($this->_agent,'OpenBSD') !== false ) {
				$this->_platform = $this->platform['OPENBSD'];
			}
			elseif( stripos($this->_agent,'NetBSD') !== false ) {
				$this->_platform = $this->platform['NETBSD'];
			}
			elseif( stripos($this->_agent, 'OpenSolaris') !== false ) {
				$this->_platform = $this->platform['OPENSOLARIS'];
			}
			elseif( stripos($this->_agent, 'SunOS') !== false ) {
				$this->_platform = $this->platform['SUNOS'];
			}
			elseif( stripos($this->_agent, 'OS\/2') !== false ) {
				$this->_platform = $this->platform['OS2'];
			}
			elseif( stripos($this->_agent, 'BeOS') !== false ) {
				$this->_platform = $this->platform['BEOS'];
			}
			elseif( stripos($this->_agent, 'win') !== false ) {
				$this->_platform = $this->platform['WINDOWS'];
			}elseif(stripos($this->_agent, 'playstation') !== false){
				if(stripos($this->_agent, 'playstation 4') !== false){
					$this->_platform = $this->platform['PLAYSTATION_4'];
				}else{
					$this->_platform = $this->platform['PLAYSTATION'];
				}
			}

		}

		/**
		 * Determine if the device is Mobile
		 * @return boolean True if the device is Mobile otherwise false
		 */
		protected function detectMobile() {
			$rules = array_merge(
				parent::$browsers,
				parent::$phoneDevices,
				parent::$operatingSystems
			);
			foreach ($rules as $_regex) {
				$regex = str_replace('/', '\/', $_regex);
				if(preg_match('/'.$regex.'/is', $this->_agent)) {
					return true;
				}
			}return false;
		}

		/**
		 * Determine if the device is Tablet
		 * @return boolean True if the device is Tablet otherwise false
		 */
		protected function detectTablet() {
			foreach (parent::$tabletDevices as $_regex) {
				$regex = str_replace('/', '\/', $_regex);
				if(preg_match('/'.$regex.'/is', $this->_agent)) {
					return true;
				}
			}return false;
		}

		/**
		 * Check device either Mobile or Tablet
		 * @return boolean True if the device is detected otherwise false
		 */
		protected function checkDevice() {
			if($this -> detectMobile()) {
				$this -> detectTablet() ? $this -> setTablet(true) : $this -> setMobile(true);
				return true;
			} return false;
		}

		/**
		 * Returns all browsers in a assoc array
		 *
		 * @return array
		 */
		public function getAllBrowsers(){
			return $this->browser;
		}

		/**
		 * Return all platforms in an assoc array
		 *
		 * @return array
		 */
		public function getPlatforms(){
			return $this->platform;
		}

		/**
		 * Returns an associative array with all available devices
		 * @return array
		 */
		public function getDevices(){
			return $this->devices;
		}

		/**
		 * Check device
		 * @return int | 1 - Desktop, 2 - Mobile, 3 - Tablet
		 */
		public function getDevice(){
			if($this->detectMobile()){
				if($this->detectTablet()){
					$this -> setTablet(true);
					return 3;
				}else{
					$this -> setMobile(true);
					return 2;
				}
			}else{
				return 1;
			}
		}

		/**
		 * Return the string of the device
		 * ex: 1 = Desktop
		 * @param null $device
		 * @return string
		 */
		public function getDeviceString($device = null){
			$devicetype = ($device == null && $device != 0) ? $this->getDevice() : $device;
			if(isset($this->devices[$devicetype])){
				return $this->devices[$devicetype];
			}else{
				return 'Unknown';
			}
		}

		/**
		 * Return an array with the related platforms
		 * @param $device
		 * @return bool | platforms array
		 */
		public function getPlatformsByDevice($device){
			if(isset($this->platform_devices[$device])){
				return $this->platform_devices[$device];
			}
			return false;
		}

		/**
		 * Return DeviceType integer found by $platform
		 * @param $platform
		 * @return bool
		 */
		public function getDeviceByPlatform($platform){
			foreach($this->devices as $id => $device){
				if(in_array($platform, $this->platform_devices[$id])){
					return $id;
				}
			}
			return false;
		}
	}}
	$detect = new Device_Detect();
?>
