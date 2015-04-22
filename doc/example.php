<?php
// Autoload library with Composer
require './../vendor/autoload.php';

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Fcosrno\Aspect\Aspect;

$imagine = new Imagine\Gd\Imagine();
$image = $imagine->open('http://lorempixel.com/1000/1000/');
$imageWidth = $image->getSize()->getWidth();
$imageHeight = $image->getSize()->getHeight();
$aspect = new Aspect();
$optimal = $aspect
	->setOriginalWidth($imageWidth)
	->setOriginalHeight($imageHeight)
	->targetWidth(40)
	->getOptimalDimensions();
echo $optimal[0].'x'.$optimal[1];

?>