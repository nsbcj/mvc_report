<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Dice\Dice;
use App\Dice\DiceGraphic;
use App\Dice\DiceHand;

class DiceGameController extends AbstractController
{
    /**
     * @Route("/dicegame", name="start")
     */
    public function home(): Response
    {
        return $this->render('dicegame/home.html.twig');
    }

    /**
     * @Route("/dicegame/rollDice", name="roll_dice")
     */
    public function rollDice(): Response
    {
        $dice = new DiceGraphic();

        $data = [
            "diceRoll" => $dice->roll(),
            "diceString" => $dice->getAsString()
        ];
        return $this->render('dicegame/roll.html.twig', $data);
    }

    /**
     * @Route("/dicegame/dicehand/{num<\d+>}", name="dicehand")
     */
    public function diceHand(int $num): Response
    {
        $hand = new DiceHand();

        for ($i=1; $i <= $num; $i++) {
            $hand->add(new DiceGraphic());
        }

        $hand->roll();

        $data = [
                "numDices" => $hand->getNumberOfDices(),
                "diceRoll" => $hand->getString()
            ];

        return $this->render('dicegame/dicehand.html.twig', $data);
    }

    /**
     * @Route("/dicegame/init", name="game_init", methods="GET")
     */
    public function init(): Response
    {
        return $this->render('dicegame/init.html.twig');
    }

    /**
     * @Route("/dicegame/init", name="game_init_post", methods="POST")
     */
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numDices = $request->request->get("num_dices");

        $diceHand = new DiceHand();

        for ($i=1; $i <= $numDices; $i++) {
            $diceHand->add(new DiceGraphic());
        }

        $diceHand->roll();

        $session->set("game_dices", $numDices);
        $session->set("game_round", 0);
        $session->set("game_total", 0);
        $session->set("game_hand", $diceHand);

        return $this->redirectToRoute("game_play");
    }

    /**
     * @Route("/dicegame/play", name="game_play", methods="GET")
     */
    public function play(
        SessionInterface $session
    ): Response {
        $diceHand = $session->get("game_hand");

        $data = [
            "gameDices" => $session->get("game_dices"),
            "gameRound" => $session->get("game_round"),
            "gameTotal" => $session->get("game_total"),
            "gameHand" => $diceHand->getString()
        ];

        return $this->render('dicegame/play.html.twig', $data);
    }

    /**
     * @Route("/dicegame/roll", name="game_roll", methods="POST")
     */
    public function roll(
        SessionInterface $session
    ): Response {
        $diceHand = $session->get("game_hand");
        $diceHand->roll();

        $roundTotal = $session->get("game_round");
        $round = 0;
        $values = $diceHand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;
                $this->addFlash(
                    "warning",
                    "Du fick en etta och förlorade rundans poäng"
                );
                break;
            }
            $round += $value;
        }

        $session->set("game_round", $roundTotal + $round);

        return $this->redirectToRoute("game_play");
    }

    /**
     * @Route("/dicegame/save", name="game_save", methods="POST")
     */
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("game_round");
        $gameTotal = $session->get("game_total");

        $session->set("game_round", 0);
        $session->set("game_total", $roundTotal + $gameTotal);

        $this->addFlash(
            "notice",
            "Din runda lades till i totalsumman"
        );

        return $this->redirectToRoute("game_play");
    }
}
