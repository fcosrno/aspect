<?php
/**
 * This file is part of the Aspect library
 *
 * Copyright (c) 2015 Francisco Serrano <fserrano@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fcosrno\Aspect\Adapter;

use Fcosrno\Aspect\Adapter\AbstractAdapter;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;

class ImagineAdapter extends AbstractAdapter
{
    private $image;
    protected $instance;

    public function __construct(\Imagine\GD\Imagine $obj)
    {
        $this->instance = $obj;
    }
    public function open($path_to_file)
    {
        $this->image = $this->instance->open($path_to_file);
    }
    public function getWidth()
    {
        return $this->image->getSize()->getWidth();
    }
    public function getHeight()
    {
        return $this->image->getSize()->getHeight();
    }
    public function show()
    {
        return $this->image->show('jpg');
    }
    public function resize($ratio)
    {
        $this->image->resize(new Box($ratio->dimensions['optimal'][0],$ratio->dimensions['optimal'][1]));
    }
    public function crop($coordinate,$ratio)
    {
        $slack = $ratio->dimensions['optimal'][$coordinate]-$ratio->dimensions['target'][$coordinate];

        // This is just a clever way to avoid doing an if/else on coordinate. When you crop you
        // send a coordinate, which is 0 for x (or width) and 1 for y (or height). 
        // So this code puts the slack value in the array position that matches the coordinate.
        $cropCoordinate=array(0,0);
        $cropCoordinate[$coordinate]=$slack/2;
        $cropPoint = new Point($cropCoordinate[0],$cropCoordinate[1]);

        $this->image->crop(
            $cropPoint,
            new Box($ratio->dimensions['target'][0],$ratio->dimensions['target'][1])
            );
    }

    public function save($path)
    {
        $this->image->save($path);
    }
}
