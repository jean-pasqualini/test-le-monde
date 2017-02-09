<?php
/**
 * Created by PhpStorm.
 * User: aurore
 * Date: 09/02/2017
 * Time: 10:39
 */

namespace Screen;

class ConsoleScreen implements ScreenInterface
{
    protected $pixels;
    protected $width;
    protected $height;
    protected $cleanFeature = true;

    public function initialize($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $this->putPixel($x, $y, '_');
            }
        }
    }

    public function disableCleanFeature()
    {
        $this->cleanFeature = false;
    }

    public function putPixel($x, $y, $value)
    {
        $this->pixels[$x.':'.$y] = $value;
    }

    protected function getPixel($x, $y)
    {
        return $this->pixels[$x.':'.$y];
    }

    public function clean()
    {
        if ($this->cleanFeature)
        {
            system('clear');
        }
    }

    public function show()
    {
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                echo $this->getPixel($x, $y);
            }
            echo PHP_EOL;
        }
    }
}