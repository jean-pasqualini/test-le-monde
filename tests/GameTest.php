<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use Game;

class GameTest extends TestCase
{
    /** @var Game */
    protected $game;

    public function setUp()
    {
        $this->game = new Game();
    }

    public function provideBoard()
    {
        // Test basic with one round
        yield array(
            array(
                'initState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                    array(Game::STATE_LIFE,   Game::STATE_LIFE,     Game::STATE_LIFE),
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                ),
                'endState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_LIFE,     Game::STATE_DEAD),
                    array(Game::STATE_DEAD,   Game::STATE_LIFE,     Game::STATE_DEAD),
                    array(Game::STATE_DEAD,   Game::STATE_LIFE,     Game::STATE_DEAD),
                ),
                'round' => 1
            )
        );

        // Test basic with two round
        yield array(
            array(
                'initState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                    array(Game::STATE_LIFE,   Game::STATE_LIFE,     Game::STATE_LIFE),
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                ),
                'endState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                    array(Game::STATE_LIFE,   Game::STATE_LIFE,     Game::STATE_LIFE),
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                ),
                'round' => 2
            )
        );
    }

    public function testConstructor()
    {
        self::assertInstanceOf('Game', $this->game);
    }

    public function testInitializeWithValidArray()
    {
        self::assertTrue($this->game->initialize(array()));
    }

    public function testInitializeWithBadArray()
    {
        self::markTestSkipped('TODO : Complete this test');
    }

    /**
     * @expectedException \Exception\NotInitializedGameException
     */
    public function testNotInitializedGameException()
    {
        $this->setExpectedExceptionFromAnnotation();

        $this->game->update();
    }

    /** @dataProvider provideBoard */
    public function testSuccessfullGame($environment)
    {
        $this->game->initialize($environment['initState']);

        // Loop for execute all rounds
        $roundPassed = 0;
        while($roundPassed < $environment['round'])
        {
            $this->game->update();
            $roundPassed++;
        }

        self::assertEquals($environment['endState'], $this->game->getBoard());
    }
}