<?php
namespace Screen;

interface ScreenInterface
{
    public function clean();
    public function initialize($width, $height);
    public function putPixel($x, $y, $value);

    public function show();
}