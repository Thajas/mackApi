<?php
defined('ACCESS') OR exit('No direct script access allowed');
// error_reporting(E_ALL | E_STRICT); // E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR E_ALL | E_STRICT
// ini_set('display_errors', 'on');
require dirname ( __DIR__ ) . '/config/paths.php';
require LIBRARY . 'SafePDO.inc';
require COMMANDS . $object->getClassFolder () . '.inc';
require CLASSES . $object->getClassFolder () . DS . $object->getClassFolder () . '.inc';
