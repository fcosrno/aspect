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

use Fcosrno\Aspect\Aspect;

abstract class AbstractAdapter
{
    abstract protected function open($path_to_file);
    abstract protected function getWidth();
    abstract protected function getHeight();
    abstract protected function show();
    abstract protected function resize($ratio);
    abstract protected function crop($coordinate,$ratio);
    abstract protected function save($path);
}
