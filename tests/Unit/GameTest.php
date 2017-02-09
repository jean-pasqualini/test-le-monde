<?php
namespace tests\Unit;

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

        // Test grenouille
        yield array(
            array(
                'initState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD,     Game::STATE_DEAD),
                    array(Game::STATE_DEAD,   Game::STATE_LIFE,     Game::STATE_LIFE,     Game::STATE_LIFE),
                    array(Game::STATE_LIFE,   Game::STATE_LIFE,     Game::STATE_LIFE,     Game::STATE_DEAD),
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD,     Game::STATE_DEAD),
                ),
                'endState' => array(
                    array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_LIFE,     Game::STATE_DEAD),
                    array(Game::STATE_LIFE,   Game::STATE_DEAD,     Game::STATE_DEAD,     Game::STATE_LIFE),
                    array(Game::STATE_LIFE,   Game::STATE_DEAD,     Game::STATE_DEAD,     Game::STATE_LIFE),
                    array(Game::STATE_DEAD,   Game::STATE_LIFE,     Game::STATE_DEAD,     Game::STATE_DEAD),
                ),
                'round' => 1
            )
        );
    }

    public function testConstructor()
    {
        self::assertInstanceOf('Game', $this->game);
    }

    public function testInitializeWithValidArray()
    {
        self::assertTrue($this->game->initialize(array(
            array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
            array(Game::STATE_LIFE,   Game::STATE_LIFE,     Game::STATE_LIFE),
            array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
        )));
    }

    public function provideInitializeWithBadArray()
    {
        yield array(
            $testName = 'Invalid state',
            array(array(3))
        );

        yield array(
            $testName = 'Not multidimensional array',
            array(Game::STATE_LIFE)
        );

        yield array(
            $testName = 'Board with differents size lines',
            array(
                array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
                array(Game::STATE_LIFE,   Game::STATE_LIFE),
                array(Game::STATE_DEAD,   Game::STATE_DEAD,     Game::STATE_DEAD),
            )
        );
    }

    /**
     * @dataProvider provideInitializeWithBadArray
     */
    public function testInitializeWithBadArray($testName, $badArray)
    {
        self::assertFalse($this->game->initialize($badArray), $testName);
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