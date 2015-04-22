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

class Aspect{

    private $adapterInstance;
    private $targetDimensions=array(0,0);

    public function __construct()
    {
        // By default, use the Imagine adapter. This gets overwritten if developer uses $this->setAdapter
        $this->setAdapter(new Adapter\ImagineAdapter(new \Imagine\GD\Imagine()));
    }

    function setAdapter($adapterInstance){
        $this->adapterInstance = $adapterInstance;
        return $this;
    }
    public function targetHeight($int)
    {
        $this->targetDimensions[1]=$int;
        return $this;
    }
    public function targetWidth($int)
    {
        $this->targetDimensions[0]=$int;
        return $this;
    }
    public function apply()
    {
        $ratio = new Ratio(
            $this->adapterInstance->getWidth(),
            $this->adapterInstance->getHeight(),
            $this->targetDimensions[0],
            $this->targetDimensions[1]
            );

        $this->adapterInstance->resize($ratio);

        foreach(range(0,1) as $coordinate){
            if($ratio->dimensions['optimal'][$coordinate]>$ratio->dimensions['target'][$coordinate])$this->adapterInstance->crop($coordinate,$ratio);
        }
    }
    public function show()
    {
        $this->apply();
        return $this->adapterInstance->show();
    }
    public function save($path)
    {
        $this->apply();
        return $this->adapterInstance->save($path);
    }
    public function open($path)
    {
        $this->adapterInstance->open($path);
        return $this;
    }

}
?>