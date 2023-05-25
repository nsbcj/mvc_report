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
use App\Project\ProjDeckOfCards;
use App\Project\ProjGame;

class ProjController extends AbstractController
{
    /**
     * @Route("/proj", name="project", methods="GET")
     */
    public function project(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        $data = [];

        if (!isset($game)) {
            $this->addFlash(
                "notice",
                "Starta ett nytt spel genom att skriva in ett spelarnamn nedan"
            );
            return $this->render('proj/index.html.twig');
        }

        $data["house"] = $game->house->name;
        $data["houseHand"] = $game->house->getHandsAsStringAndSumAndBet();
        $data["deck"] = $game->deck;
        $data["deckLength"] = $game->deck->getDeckLength();
        $data["playerHands"] = $game->player->getHandsAsStringAndSumAndBet();
        $data["playerHandCount"] = $game->player->getCountOfHands();
        $data["activeHandIndex"] = $game->player->getActiveHandIndex();
        $data["playerBalance"] = $game->player->wallet->getBalance();
        $data["player"] = $game->player->name;
        $data["start"] = $game->start;
        $data["done"] = $game->done;
        $data["winners"] = $game->winners;

        return $this->render('proj/index.html.twig', $data);
    }

    /**
     * @Route("/proj/about", name="projectAbout", methods="GET")
     */
    public function projectAbout(): Response
    {
        return $this->render('proj/about.html.twig');
    }

    /**
     * @Route("/proj/init", name="projectInit", methods="POST")
     */
    public function projectInit(
        SessionInterface $session,
        Request $request
    ): Response {
        $player = $request->request->get("name") ?? null;
        $house = "Huset";

        if(isset($player)) {
            $game = new ProjGame();
            $game->init();
            $game->player->setPlayer($player);
            $game->house->setPlayer($house);

            $session->set("game", $game);
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/logout", name="projectLogout", methods="POST")
     */
    public function projectLogout(
        SessionInterface $session,
        Request $request
    ): Response {
        $logout = $request->request->get("logout") ?? null;

        if(isset($logout)) {
            $session->set("game", null);
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/draw", name="projectDraw", methods="POST")
     */
    public function projectDraw(
        SessionInterface $session,
        Request $request
    ): Response {
        $draw = $request->request->get("draw") ?? null;

        if(isset($draw)) {
            $game = $session->get("game");

            $deck = $game->deck;

            $game->player->draw($deck);

            $currentValue = $game->player->hands[$game->player->getActiveHandIndex()]->getHandSum();

            if ($currentValue > 21) {
                $game->player->hold();
                $this->addFlash(
                    "warning",
                    "Player got over 21"
                );
            }

            if ($game->player->checkPlayerDone()) {
                $game->autoPlay();

                $game->setDone();

                $game->setWinners();

                $this->addFlash(
                    "notice",
                    "House played hand"
                );
            }

            $this->addFlash(
                "notice",
                "Player drawed a new card"
            );

            $session->set("game", $game);
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/hold", name="projectHold", methods="POST")
     */
    public function projectHold(
        SessionInterface $session,
        Request $request
    ): Response {
        $hold = $request->request->get("hold") ?? null;

        if(isset($hold)) {
            $game = $session->get("game");

            $game->player->hold();

            if ($game->player->checkPlayerDone()) {
                $game->autoPlay();

                $game->setDone();

                $game->setWinners();

                $this->addFlash(
                    "notice",
                    "House played hand"
                );
            }

            $session->set("game", $game);
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/splithand", name="projectSplitHand", methods="POST")
     */
    public function projectSplitHand(
        SessionInterface $session,
        Request $request
    ): Response {
        $handIdx = $request->request->get("hand") ?? null;

        $bet = $request->request->get("bet") ?? null;

        $game = $session->get("game") ?? null;

        if(isset($game)) {
            $game->player->splitPlayerHand($handIdx);

            $game->player->wallet->withdrawBalance($bet);

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "Player splitted hand, by {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/doublehand", name="projectDoubleHand", methods="POST")
     */
    public function projectDoubleHand(
        SessionInterface $session,
        Request $request
    ): Response {
        $handIdx = $request->request->get("hand") ?? null;

        $bet = $request->request->get("bet") ?? null;

        $game = $session->get("game") ?? null;

        if(isset($game)) {
            $game->player->hands[$handIdx]->doubleBet();

            $game->player->wallet->withdrawBalance($bet);

            $game->player->draw($game->deck);

            $game->player->hold();

            if ($game->player->checkPlayerDone()) {
                $game->autoPlay();

                $game->setDone();

                $game->setWinners();

                $this->addFlash(
                    "notice",
                    "Player doubled, drawed card and House played hand"
                );
            }

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "Player doubled. Additional {$bet} is added to bet and card is drawed, by {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/addhand", name="projectAddHand", methods="POST")
     */
    public function projectAddHand(
        SessionInterface $session,
        Request $request
    ): Response {
        $bet = $request->request->get("bet") ?? null;

        $game = $session->get("game") ?? null;

        if(isset($game)) {
            $game->player->addHand($bet);

            // $game->player->wallet->setBalance(-$bet);

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "Added hand with bet {$bet}, by {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/initround", name="projectInitRound", methods="POST")
     */
    public function projectInitRound(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        if(isset($game)) {
            foreach ($game->player->hands as $hand) {
                $hand->add($game->deck);
                $hand->add($game->deck);
                $game->player->wallet->setBalance(-$hand->bet);
            }

            $game->house->addHandWithoutBet();
            $game->house->drawWithoutBet($game->deck);
            $game->house->drawWithoutBet($game->deck);

            $game->start();

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "Game started, by {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/reset", name="projectReset", methods="POST")
     */
    public function projectReset(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        if(isset($game)) {
            $game->stop();

            $game->setUnDone();

            $game->player->resetPlayerHands();

            $game->house->resetPlayerHands();

            $game->winners = null;

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "New round is initiated by {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }
}
