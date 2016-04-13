<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );
$app = [ 
		/**
		 * Debug Level:
		 *
		 * Production Mode:
		 * false: No error messages, errors, or warnings shown.
		 *
		 * Development Mode:
		 * true: Errors and warnings shown.
		 */
		'debug' => true,
		
		/**
		 * Security and encryption configuration
		 * you can change it Key must be 12, 24, 32 bit long
		 */
		'Security' => [ 
				'salt' => 'SDF#$%FS&()DSF+_SDF@SER^&(~DTdir' 
		],
		
		'Domain' => [ 
				'default' => [ 
						'host' => 'localhost',
						'port' => '80',
						'protocol' => 'http' 
				],
				'production' => [ 
						'host' => 'www.dummy.com',
						'port' => '443',
						'protocol' => 'https' 
				] 
		],
		
		'Error' => [ 
				'errorLevel' => 'E_ALL | E_STRICT' 
		],
		
		'Http' => [ 
				'method' => 'GET' 
		],
		
		'Datasources' => [ 
				'default' => [ 
						'host' => 'localhost',
						'username' => 'PwCduydCknTC-B_MINywCM769T2-QZoz2E5qwcJw3Qo',	// Encrypted
						'password' => 'cSLFemcMeG7-Sibf9O013CojhjVHsliCGPBa9cUmhzk',	// Encrypted
						'database' => 'Wl8t7ZzWOkGMIlxBMsgg5f0QorTe3-N6WNar7VmU7YU',	// Encrypted
						'encoding' => 'utf8',
						'timezone' => 'UTC' 
				],
				'production' => [ 
						'host' => '',
						'username' => '',	// Encrypted
						'password' => '',	// Encrypted
						'database' => '',	// Encrypted
						'encoding' => 'utf8',
						'timezone' => 'UTC' 
				] 
		],
		
		'Session' => [ 
				'defaults' => 'php' 
		],

		'View' => [
				'ext'	=> '.jsp'
		]
];
