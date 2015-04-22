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

class Ratio{

    public $dimensions = array();

    function __construct($originalWidth=null,$originalHeight=null,$targetWidth=null,$targetHeight=null){
    	$this->setOriginalWidth($originalWidth);
    	$this->setOriginalHeight($originalHeight);
    	$this->setTargetWidth($targetWidth);
    	$this->setTargetHeight($targetHeight);
        $this->fillTargetDimensions();
        $this->calculateOptimalDimensions();
    }

    private function setOriginalWidth($int)
    {
        $this->dimensions['original'][0] = $int;

        return $this;
    }
   private function setOriginalHeight($int)
    {
        $this->dimensions['original'][1] = $int;

        return $this;
    }
    private function setTargetWidth($int=0)
    {
        if($int)$this->dimensions['target'][0]=$int;
        return $this;
    }
    private function setTargetHeight($int=0)
    {
        if($int)$this->dimensions['target'][1]=$int;
        return $this;
    }

    /**
     * Defines the optimal dimensions
     * @param  integer $base_coordinate Either 0 or 1 which refers to x or y
     */
    private function calculateOptimalDimensions($base_coordinate=0)
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
}
?>