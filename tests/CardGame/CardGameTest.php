<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGame.
 */
class CardGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGameNoArguments()
    {
        $game = new CardGame();
        $this->assertInstanceOf("\App\CardGame\CardGame", $game);
    }

    /**
     * Test initiate play with no arguments
     */
    public function testPlayNoArguments()
    {
        $game = new CardGame();

        $game->init();

        $game = $game->play();

        $this->assertIsArray($game);
    }

    /**
     * Test reset game with no arguments
     */
    public function testRestGame()
    {
        $game = new CardGame();

        $game->init();

        $startGame = $game->play();

        $game->setGameDone();

        $game->drawCard($game->deck, $game->player);

        $game->drawCard($game->deck, $game->house);

        $game->reset();

        $endGame = $game->play();

        $startGame = (object)$startGame;
        $endGame = (object)$endGame;

        $first = [
            "house" => $startGame->house,
            "player" => $startGame->player,
            "done" => $startGame->done
        ];

        $second = [
            "house" => $endGame->house,
            "player" => $endGame->player,
            "done" => $endGame->done
        ];

        $this->assertEquals($first, $second);
    }

    /**
     * Test House draw
     */
    public function testHouseDraw()
    {
        $game = new CardGame();

        $game->init();

        $game->HouseDraw();

        $game = $game->play();

        $game = (object)$game;

        $house = (object)$game->house;

        $houseHandSum = $house->sum;

        $this->assertGreaterThan(0, $houseHandSum);
    }

    /**
     * Test get Player Hand As String
     */
    public function testGetPlayerHandAsSum()
    {
        $game = new CardGame();

        $game->init();

        while(true) {
            $game->drawCard($game->deck, $game->player);

            if($game->getPlayerHandSum($game->player->hand) == 14) {
                break;
            }

            $game->reset();
        }

        $handAsString = $game->getPlayerHandSum($game->player->hand);

        $this->assertNotEmpty($handAsString);
    }

    /**
     * Test get Player Hand As String
     */
    public function testGetPlayerHandAsString()
    {
        $game = new CardGame();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $handAsString = $game->getPlayerHandAsString($game->player);

        $this->assertNotEmpty($handAsString);
    }

    /**
     * Test get GameStats
     */
    public function testGetGameStats()
    {
        $game = new CardGame();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $gameStats = $game->getGameStats();

        $this->assertNotEmpty($gameStats);
        $this->assertIsArray($gameStats);
    }

    /**
     * Test get draw percentage
     */
    public function testGetDrawPercentage()
    {
        $game = new CardGame();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $playerPercentage = $game->getPlayerDrawPercentage();

        $housePercentage = $game->getHouseDrawPercentage();

        $this->assertIsFloat($playerPercentage);

        $this->assertIsFloat($housePercentage);

        for ($i=0; $i <= 50; $i++) {
            $game->drawCard($game->deck, $game->player);
        }

        $playerPercentage = $game->getPlayerDrawPercentage();

        $this->assertEquals($playerPercentage, null);

        $game = new CardGame();

        $game->init();

        $game->drawCard($game->deck, $game->player);
        $game->drawCard($game->deck, $game->player);

        $playerPercentage = $game->getPlayerDrawPercentage();

        $this->LessThan($playerPercentage, 100);
    }

    /**
     * Test get winner
     */
    public function testGetWinner()
    {
        $game = new CardGame();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $game->setWinner();

        $this->assertEquals($game->winner, $game->player->name);

        $game->reset();

        $game->drawCard($game->deck, $game->house);

        $game->setWinner();

        $this->assertEquals($game->winner, $game->house->name);

        $game->reset();

        foreach (range(1, 10) as $value) {
            $game->drawCard($game->deck, $game->player);
        }

        $game->setWinner();

        $this->assertEquals($game->winner, $game->house->name);

        $game->reset();

        foreach (range(1, 10) as $value) {
            $game->drawCard($game->deck, $game->house);
        }

        $game->setWinner();

        $this->assertEquals($game->winner, $game->player->name);
    }
}
