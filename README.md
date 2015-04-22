# Aspect
A tiny Imagine wrapper to resize and crop without distortion and with the convenience of requiring only desired dimension.

# Introduction
 
When you're resizing with Imagine, you're required to provide both the target width and height. Sometimes you don't know what the values of those dimensions should be: maybe you know you want the image to be a certain width, but don't care about the height. 

Other times you know exactly what the dimensions should be, but the image needs to be centered before cropping, and you want to keep as much of it as possible before the crop. 

Aspect calculates these things for you.

# General usage

Load image with Imagine and get size.

	$imagine = new Imagine\Gd\Imagine();
	$image = $imagine->open('path-to-file');
	$originalWidth = $image->getSize()->getWidth();
	$originalHeight = $image->getSize()->getHeight();


Get optimal dimensions from fixed width of 100px.

	$aspect = new Aspect($originalWidth,$originalHeight,100);
	$optimal = $aspect->getOptimalDimensions();


Get optimal dimensions from fixed height of 250px.


	$aspect = new Aspect($originalWidth,$originalHeight,null,250);
	$optimal = $aspect->getOptimalDimensions();
	
Get optimal dimensions from exact desired size.

	$aspect = new Aspect($originalWidth,$originalHeight,null,$targetWidth,$targetHeight);
	$optimal = $aspect->getOptimalDimensions();

Chainable option.

	$aspect = new Aspect();
	$optimal = $aspect
		->setOriginalWidth($originalWidth)
		->setOriginalHeight($originalHeight)
		->targetWidth(100)
		->targetHeight(250)
		->getOptimalDimensions();
		
# Installation

composer require fcosrno/aspect

# Requirements

PHP
Imagine Lib


# How it works

**Optimal dimensions**

First, Aspect will calculate the optimal dimensions for your new image, keeping the proportions of your target dimensions.*** If you only provide one dimension (width or height), Aspect will use the original image's proportions to calculate the optimal value for the undefined dimension. If you provide two dimensions, then it will use those proportions.

**Resizing (and cropping)**

Aspect resizes your image to the optimal dimension calculated in step 1. In the event of differences in aspect ratios, ie, the optimal dimension went over the target size, Aspect will crop out the leftover slack. This is usually a small amount either on the sides or top and bottom. The new image will be pixel perfect.

**Benefits**

Aspect shines when you have to resize hundreds of images with different aspect ratios. Most libraries will resize an image to an exact size, leaving you to calculate the dimensions. With Aspect, only one target dimension (either length or height) is required. Aspect figures out the rest for you. Sometimes you care that an image is a certain width, but don't
care about the height. Aspect is great for that. You specify either length or height and Aspect will resize and then crop, if necessary.

If you know the exact size you want, then that works too. Provide both length and height and Aspect will resize and crop, if necessary, for an exact fit.

# Acknowledgements

This wrapper borrows ideas from here and here.

Reference: http://code.tutsplus.com/tutorials/image-resizing-made-easy-with-php--net-10362
Also: https://github.com/Nimrod007/PHP_image_resize/blob/master/smart_resize_image.function.php



