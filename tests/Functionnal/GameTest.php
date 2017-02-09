<?php

namespace tests\Functionnal;

use PHPUnit\Framework\TestCase;
use Screen\ConsoleScreen;

class GameTest extends TestCase
{
    protected $game;
    /** @var \TestableGameRunner */
    protected $gameRunner;
    protected $screen;

    public function setUp()
    {
        $this->game = new \Game();
        $this->screen = new ConsoleScreen();
        $this->screen->disableCleanFeature();
        $this->gameRunner = new \TestableGameRunner($this->game, $this->screen);
    }

    public function testUpdate()
    {
        $expectedStates = explode(
            '-----',
            file_get_contents(__DIR__.'/Fixture/game_view_ouput.test')
        );

        $board = array(
            array(\Game::STATE_DEAD, \Game::STATE_LIFE, \Game::STATE_DEAD),
            array(\Game::STATE_DEAD, \Game::STATE_LIFE, \Game::STATE_DEAD),
            array(\Game::STATE_DEAD, \Game::STATE_LIFE, \Game::STATE_DEAD),
        );

        $this->gameRunner->run($board, count($expectedStates));

        foreach ($expectedStates as $expectedState) {

            $expectedState = ltrim($expectedState);

            $actual = $this->gameRunner->getOutput();

            self::assertEquals($expectedState, $actual);
        }
    }
}