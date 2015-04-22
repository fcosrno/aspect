<?php 
/**
 * This file is part of the Aspect library
 *
 * Copyright (c) 2015 Francisco Serrano <fserrano@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fcosrno\Aspect;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;

// use Fcosrno\Exam\Question;
// use Fcosrno\Exam\HtmlGenerator;
// use Fcosrno\Exam\Grade;

class Aspect{
    private $image;
    private $dimensions = array();
    function __construct($originalWidth=null,$originalHeight=null,$targetWidth=null,$targetHeight=null){
    	$this->setOriginalWidth($originalWidth);
    	$this->setOriginalHeight($originalHeight);
    	$this->targetWidth($targetWidth);
    	$this->targetHeight($targetHeight);
    }

    public function open($path_to_file)
    {
        // Open up the file
        $imagine = new Imagine\Gd\Imagine();
        $this->image = $imagine->open($path_to_file);
 
        // Get width and height
        $this->dimensions['original'][0] = $this->image->getSize()->getWidth();
        $this->dimensions['original'][1] = $this->image->getSize()->getHeight();

        return $this;
    }

    public function setOriginalWidth($int)
    {
        $this->dimensions['original'][0] = $int;

        return $this;
    }
   public function setOriginalHeight($int)
    {
        $this->dimensions['original'][1] = $int;

        return $this;
    }

    public function originalDimensions($array=array())
    {
        // Set width and height
        $this->dimensions['original'][0] = $array[0];
        $this->dimensions['original'][1] = $array[1];

        return $this;
    }

    public function targetWidth($int=0)
    {
        if($int)$this->dimensions['target'][0]=$int;
        return $this;
    }
    public function targetHeight($int=0)
    {
        if($int)$this->dimensions['target'][1]=$int;
        return $this;
    }

    /**
     * Defines the optimal dimensions
     * @param  integer $base_coordinate Either 0 or 1 which refers to x or y
     */
    public function calculateOptimalDimensions($base_coordinate=0)
    {
        $ratio = $this->dimensions['original'][$base_coordinate]/$this->dimensions['target'][$base_coordinate];

        $this->dimensions['optimal'][0]=round($this->dimensions['original'][0]/$ratio);
        $this->dimensions['optimal'][1]=round($this->dimensions['original'][1]/$ratio);

        // If one of the calculated optimal sizes fall outside the boundaries of the target
        // values, flip the ratio base_coordinate to y
        if($this->dimensions['optimal'][0]<$this->dimensions['target'][0] || $this->dimensions['optimal'][1]<$this->dimensions['target'][1]){
            return $this->calculateOptimalDimensions(1);
        }
    }
    public function getOptimalDimensions()
    {
        $this->fillTargetDimensions();
        $this->calculateOptimalDimensions();
    	return array($this->dimensions['optimal'][0],$this->dimensions['optimal'][1]);
    }
    // Makes sure all target Dimensions are filled out
    private function fillTargetDimensions()
    {
        foreach(array(0,1) as $coordinate){
            if(empty($this->dimensions['target'][$coordinate])){
                $other_coordinate = 1-$coordinate;
                $ratio = $this->dimensions['original'][$other_coordinate]/$this->dimensions['target'][$other_coordinate];
                $this->dimensions['target'][$coordinate]=round($this->dimensions['original'][$coordinate]/$ratio);
            } 
        }
    }
    public function apply()
    {
        $this->fillTargetDimensions();

        $this->calculateOptimalDimensions();

        $this->image->resize(new Box($this->dimensions['optimal'][0],$this->dimensions['optimal'][1]));

        foreach(range(0,1) as $coordinate){
            if($this->dimensions['optimal'][$coordinate]>$this->dimensions['target'][$coordinate])$this->crop($coordinate);
        }
    }
    public function crop($coordinate)
    {
        $slack = $this->dimensions['optimal'][$coordinate]-$this->dimensions['target'][$coordinate];

        // This is just a clever way to avoid doing an if/else on coordinate. When you crop you
        // send a coordinate, which is 0 for x (or width) and 1 for y (or height). 
        // So this code puts the slack value in the array position that matches the coordinate.
        $cropCoordinate=array(0,0);
        $cropCoordinate[$coordinate]=$slack/2;
        $cropPoint = new Point($cropCoordinate[0],$cropCoordinate[1]);

        $this->image->crop(
            $cropPoint,
            new Box($this->dimensions['target'][0],$this->dimensions['target'][1])
            );
    }
    public function show()
    {
        $this->apply();
        $this->image->show('jpg');
    }
}
?>