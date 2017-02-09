<?php
namespace Screen;

class ImageScreen implements ScreenInterface
{
    protected $pixels;
    protected $width;
    protected $height;
    protected $cleanFeature = true;

    protected $image;

    protected $boxSize = 30;
    protected $boxPadding = 15;

    protected $boxColor;
    protected $stringColor;

    public function initialize($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        // Size 10 Box / Size 5 padding

        $boxSize = $this->boxSize;
        $paddingSize = $this->boxPadding;

        $this->image = imagecreatetruecolor(
            ($width * $boxSize) + (($width - 1) * $paddingSize),
            ($height * $boxSize) + (($height - 1) * $paddingSize)
        );

        $this->boxColor = imagecolorallocate($this->image, 255, 0, 0);
        $this->stringColor = imagecolorallocate($this->image, 255, 255, 255);
    }

    public function disableCleanFeature()
    {
        $this->cleanFeature = false;
    }

    public function getFinalPosition($x, $y)
    {
        return array(
            // X
            $x * ($this->boxSize + $this->boxPadding),
            // Y
            $y * ($this->boxSize + $this->boxPadding),
        );
    }

    public function putPixel($x, $y, $value)
    {
        list($x, $y) = $this->getFinalPosition($x, $y);

        $value = array(
            '↟' => 'V',
            '░' => '_'
        )[$value];

        imagefilledrectangle(
            $this->image,
            $x,
            $y,
            $x + $this->boxSize,
            $y + $this->boxSize,
            $this->boxColor
        );

        imagestring($this->image,
            20,
            $x + ($this->boxSize / 10),
            $y + ($this->boxSize / 10),
            $value,
            $this->stringColor);
    }

    protected function getPixel($x, $y)
    {
        return $this->pixels[$x.':'.$y];
    }

    public function clean()
    {
    }

    public function show()
    {
        header('Content-Type: image/png');
        imagepng($this->image);
    }
}