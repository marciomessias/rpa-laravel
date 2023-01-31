<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class DriverController
{
    protected $driver;

    public function __construct()
    {
        $this->driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());
        $this->driver->manage()->timeouts()->implicitlyWait = 10;
    }

    public function __destruct()
    {
        $this->driver->quit();
    }
}
