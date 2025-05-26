<?php

namespace Framework\Route;

use Exception;

class ViewNotFoundException extends Exception
{
    protected $message = 'View not Found';
}
