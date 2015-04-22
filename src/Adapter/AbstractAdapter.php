<?php

namespace Fcosrno\Aspect\Adapter;

abstract class AbstractAdapter
{
    public function open($path);
    public function show();
    public function save();
}
