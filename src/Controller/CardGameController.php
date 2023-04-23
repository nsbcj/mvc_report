<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\CardGame\CardGame;
use App\CardGame\Player;
use App\CardGame\HousePlayer;

class CardGameController extends AbstractController
{
    /**
     * @Route("/game", name="cardGame", methods="GET")
     */
    public function game(): Response
    {
        return $this->render('game/landing.html.twig');
    }

    /**
     * @Route("/game/doc", name="cardGameDoc", methods="GET")
     */
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    /**
     * @Route("/game/play", name="cardGamePlay", methods="GET")
     */
    public function playGame(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        if (!isset($game)) {
            $this->addFlash(
                "notice",
                "Starta ett nytt spel genom att trycka på 'starta spelet'"
            );
            return $this->redirectToRoute("cardGame");
        }

        $data = $game->play();

        return $this->render('game/gameboard.html.twig', $data);
    }

    /**
     * @Route("/game/proceed", name="proceedGame", methods="POST")
     */
    public function proceedGame(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $game->reset();

        $session->set("game", $game);

        return $this->redirectToRoute("cardGamePlay");
    }

    /**
     * @Route("/game/init", name="initGame", methods="POST")
     */
    public function initGame(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $game = new CardGame();

        $game->init();

        $session->set("game", $game);

        return $this->redirectToRoute("cardGamePlay");
    }

    /**
     * @Route("/game/play", name="cardGameDraw", methods="POST")
     */
    public function drawGame(
        SessionInterface $session,
        Request $request
    ): Response {
        $game = $session->get("game");

        $draw = $request->request->get("draw") ?? null;

        $hold = $request->request->get("hold") ?? null;

        if (isset($draw) && $draw == "true") {
            $game->player->hand->add($game->deck);
            if (!$game->checkPlayerHand($game->player)) {
                $game->setGameDone();
                $game->setWinner();
                $classname = ($game->winner == "House") ? "warning" : "notice";
                $this->addFlash(
                    $classname,
                    "{$game->winner} har vunnit"
                );
            }
        }
        if (isset($hold) && $hold == "true") {
            $game->houseDraw();
            $game->setGameDone();
            $game->setWinner();
            $classname = ($game->winner == "House") ? "warning" : "notice";
            $this->addFlash(
                $classname,
                "{$game->winner} har vunnit"
            );
        }
        $session->set("game", $game);
        return $this->redirectToRoute("cardGamePlay");
    }

    /**
     * @Route("/game/shuffle", name="cardGameShuffle", methods="POST")
     */
    public function shuffleDeck(
        SessionInterface $session,
        Request $request
    ): Response {
        $game = $session->get("game");

        $status = $request->request->get("game_status");

        if ($status == "shuffle") {
            $game->deck->init();
            $game->deck->shuffle();
            $session->set("game", $game);
        }
        return $this->redirectToRoute("cardGamePlay");
    }
}
