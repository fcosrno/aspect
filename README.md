# Aspect
A PHP image library wrapper to resize and crop without distortion and with the convenience of requiring only one target dimension.

# Introduction
 
When you're resizing with image libraries like [Imagine](https://github.com/avalanche123/Imagine), you're required to provide both the target width and height. Yet, sometimes you don't know what the values of those dimensions should be. 

Maybe you know you want the image to be a certain width, but don't care about the height or vice-versa. Or maybe you know exactly what the dimensions should be, but the image needs to be centered before cropping, and you want to keep as much of it as possible before the crop. 

Aspect calculates these things for you.

# Quick usage

Load an image, resize, and show.

	$aspect = new Aspect();
	
	echo $aspect
		->open('http://lorempixel.com/1000/500/')
		->targetWidth('160')
		->targetHeight('90')
		->show();
		
You can use save instead of show.

		...
		->targetHeight('90')
		->save('path/to/file.jpg');
		
Read below if you only want Aspect to calculate the optimal dimensions and not process your image.		

# Installation

composer require fcosrno/aspect


# How it works

**Optimal dimensions**

First, Aspect will calculate the optimal dimensions for your new image, keeping the proportions of your target dimensions.

If you only provide one dimension (width or height), Aspect will use the original image's proportions to calculate the optimal value for the undefined dimension. If you provide two dimensions, then it will use those proportions.

**Resizing (and cropping)**

Aspect then resizes your image to its optimal dimension (optional). 

In the event of differences in aspect ratios, ie, the optimal dimension went over the target size, Aspect will crop out the leftover slack. This is usually a small amount either on the sides or top and bottom. The new image will be pixel perfect.

**Benefits**

Aspect shines when you have to resize hundreds of images with different aspect ratios. Most libraries will resize an image to an exact size, leaving you to calculate the dimensions. With Aspect, only one target dimension (either length or height) is required. Aspect figures out the rest for you. 

If you know the exact size you want, then that works too. Provide both length and height and Aspect will resize and crop, if necessary, for an exact fit.

# Default Library: Imagine/GD

By default, Aspect uses [Imagine](https://github.com/avalanche123/Imagine) to do image processing with the GD library. This keeps the API short and sweet for most user cases. 

If you want to use another library, read the **Adapters** section below.

If you want to use Imagine with the Imagick library, pass an instance of the Imagine library to the adapter setter.
	
	// This resizes and shows a picture with Imagick
	$aspect = new Aspect();
	echo $aspect->setAdapter(new ImagineAdapter(new Imagine\Imagick\Imagine()))
		->open('http://lorempixel.com/1000/500/')
		->targetWidth('160')
		->targetHeight('90')
		->show();

	// Just to clarify, this resizes and shows a picture with GD. 
	// Notice there is no need for the setter. GD is the default.
	$aspect = new Aspect();
	echo $aspect->open('http://lorempixel.com/1000/500/')
		->targetWidth('160')
		->targetHeight('90')
		->show();

# Adapters

If you would like to use another library instead of Imagine, you can create an adapter. Check out `src/Adapter/ImagineAdapter.php` to use it as an example.

# Other usage

You can use Ratio if you only want Aspect to compute dimensions.

Get optimal dimensions from fixed width of 100px.

	use Fcosrno\Aspect\Ratio;

	$ratio = new Ratio($originalWidth,$originalHeight,100);
	$optimal = $ratio->getOptimalDimensions();


Get optimal dimensions from fixed height of 250px.

	...
	
	$ratio = new Ratio($originalWidth,$originalHeight,null,250);
	$optimal = $ratio->getOptimalDimensions();
	
Get optimal dimensions from exact desired size.

	...
	
	$ratio = new Ratio($originalWidth,$originalHeight,null,$targetWidth,$targetHeight);
	$optimal = $ratio->getOptimalDimensions();


# Acknowledgements

Aspect uses [Imagine](https://github.com/avalanche123/Imagine) as a default image library.

This wrapper borrows ideas from [here](http://code.tutsplus.com/tutorials/image-resizing-made-easy-with-php--net-10362) and [here](https://github.com/Nimrod007/PHP_image_resize/blob/master/smart_resize_image.function.php). 




