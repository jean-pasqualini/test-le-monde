<?php
namespace GameRunner;

use Screen\ScreenInterface;

class WebGameRunner
{
    /** @var \Game */
    protected $game;
    /** @var ScreenInterface */
    protected $screen;

    protected $board;

    public function __construct(\Game $game, \Screen\ScreenInterface $screen)
    {
        $this->game = $game;
        $this->screen = $screen;
    }

    public function setBoard($board)
    {
        $this->game->initialize($board);
    }

    public function run()
    {
        $gameView = new \GameView($this->game, $this->screen);

        $gameView->update();
        $gameView->show();
    }
}