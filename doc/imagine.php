<?php
// Autoload library with Composer
require './../vendor/autoload.php';

use Fcosrno\Aspect\Aspect;

$aspect = new Aspect();

// Default
echo $aspect
	->open('http://lorempixel.com/1000/500/')
	->targetWidth('160')
	->targetHeight('90')
	->show();

// With custom adapter (uncomment to view)
/*
echo $aspect->setAdapter(new ImagineAdapter(new Imagine\Imagick\Imagine()))
	->open('http://lorempixel.com/1000/500/')
	->targetWidth('160')
	->targetHeight('90')
	->show();
*/

?>