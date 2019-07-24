<?php
namespace Chendujin\Bitcoin\Facade;
use Illuminate\Support\Facades\Facade;

class Bitcoin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Chendujin\Bitcoin\Lib\Bitcoin::class;
    }
}