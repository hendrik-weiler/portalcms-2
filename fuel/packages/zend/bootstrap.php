<?php

/**
 * Go to packages/zend/pack and run these two lines to comment out ALL the require_once lines
 * find ./library/ -type f -name '*.php' -print0 | xargs -0 sed --regexp-extended --in-place 's/(require_once)/\/\/ \1/g'
 * find ./extras/library/ -type f -name '*.php' -print0 | xargs -0 sed --regexp-extended --in-place 's/(require_once)/\/\/ \1/g'
 *
 * NOTE! This is not needed but recommended because there is no need to
 * use require_once in the class files anymore. This saves server loading 
 * time up to 25% when using Zend classes.
 */

$paths = array(
 __DIR__.DS.'pack'.DS.'library',
 __DIR__.DS.'pack'.DS.'extras'.DS.'library',
 get_include_path()
);

set_include_path(implode(PATH_SEPARATOR, $paths));

// Startup the Zend Loader and Autoloader (Zend < 2.0)

require __DIR__.DS.'pack'.DS.'library'.DS.'Zend'.DS.'Loader.php';
require __DIR__.DS.'pack'.DS.'library'.DS.'Zend'.DS.'Loader'.DS.'Autoloader.php';

Zend_Loader_Autoloader::getInstance();

/* End of file bootstrap.php */