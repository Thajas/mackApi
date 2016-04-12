<?php
defined ( 'ACCESS' ) or exit ( 'No direct script access allowed' );

/**
 * Use the DS to separate the directories in other defines
 */
if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define ( 'ROOT', dirname ( __DIR__ ) );

/**
 * Path to the inc directory.
 */
define ( 'INC', ROOT . DS . 'inc' . DS );

/**
 * Path to the application's directory.
 */
define ( 'CLASSES', INC . 'classes' . DS );

/**
 * Path to the command's directory.
 */
define ( 'COMMANDS', INC . 'commands' . DS );

/**
 * Path to the library directory.
 */
define ( 'LIBRARY', INC . 'lib' . DS );

/**
 * Path to the config directory.
 */
define ( 'CONFIG', ROOT . DS . 'config' . DS );

/**
 * Path to the tests directory.
 */
define ( 'TESTS', ROOT . DS . 'tests' . DS );

/**
 * Path to the temporary files directory.
 */
define ( 'TMP', ROOT . DS . 'tmp' . DS );
