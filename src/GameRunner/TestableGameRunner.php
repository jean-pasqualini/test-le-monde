<?php
namespace GameRunner;

class TestableGameRunner extends GameRunner
{
    protected $outputScreens = array();
    protected $seek = 0;

    public function run(array $board, $loop = 1, $clean = false, $sleep = false)
    {
        parent::run($board, $loop, $clean, $sleep); // TODO: Change the autogenerated stub
    }

    public function showGame(\GameView $gameView)
    {
        ob_start();
        parent::showGame($gameView);
        $this->outputScreens[] = ob_get_clean();
    }

    public function getOutput()
    {
        $output = $this->outputScreens[$this->seek];
        $this->seek++;

        return $output;
    }
}