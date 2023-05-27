<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Project\ProjWallet;
use App\Project\ProjDeckOfCards;
use App\Project\ProjGame;
use App\Project\ProjPlayer;

class ProjApiControllerJson extends AbstractController
{
    /**
     * @Route("/proj/api", name="projectApi", methods="GET")
     */
    public function projApi(): Response
    {
        return $this->render("proj/api.html.twig");
    }

    /**
     * @Route("/proj/api/deck", name="projectDeckApi", methods="GET")
     */
    public function getProjDeckApi(): Response
    {
        $deck = new ProjDeckOfCards();

        $deck->init();

        $data = [
            "deck" => $deck->getDeckAsString(),
            "deckLength" => $deck->getDeckLength(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/proj/api/player", name="projectPlayerApi", methods="GET")
     */
    public function getProjPlayerApi(): Response
    {
        $game = new ProjGame();

        $game->init();

        $game->player->setPlayer();

        $game->player->addHand(10);
        $game->player->addHand(10);
        $game->player->addHand(10);

        $game->player->draw($game->deck);
        $game->player->hold();

        $game->player->draw($game->deck);
        $game->player->hold();

        $game->player->draw($game->deck);
        $game->player->hold();

        $data = [
            "player" => $game->player->name,
            "playerHands" => $game->player->getHandsAsStringAndSumAndBet(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/proj/api/session", name="projectSessionApi", methods="GET")
     */
    public function getProjSessionApi(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        $data = [];

        if(!isset($game)) {
            $data["message"] ="No active session";
            return new JsonResponse($data);
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

        return new JsonResponse($data);
    }

    /**
     * @Route("/proj/api/balance", name="projectPlayerBalanceApi", methods="POST")
     */
    public function setAndGetProjPlayerBalanceApi(
        Request $request
    ): Response {
        $balance = $request->request->get("balance");

        $game = new ProjGame();

        $game->init();

        $game->player->setPlayer();

        $game->player->wallet->setBalance($balance);

        $data = [
            "player" => $game->player->name,
            "balance" => $game->player->wallet->getBalance(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/proj/api/initgame", name="projectInitGameApi", methods="POST")
     */
    public function getProjInitGameApi(
        Request $request
    ): Response {
        $hands = $request->request->get("hands");

        $game = new ProjGame();

        $game->init();

        $game->player->setPlayer();

        $game->house->setPlayer();

        while ($hands > 0) {
            $game->player->addHand(10);
            $hands--;
        }

        foreach ($game->player->hands as $hand) {
            $hand->add($game->deck);
            $hand->add($game->deck);
            $game->player->wallet->withdrawBalance($hand->bet);
        }

        $game->house->addHandWithoutBet();
        $game->house->drawWithoutBet($game->deck);
        $game->house->drawWithoutBet($game->deck);

        $game->start();

        $data = [
            "deck" => $game->deck->getDeckLength(),
            "player" => $game->player->getHandsAsStringAndSumAndBet(),
            "house" => $game->house->getHandsAsStringAndSumAndBet(),
            "start" => $game->start,
            "done" => $game->done,
            "winners" => $game->winners,
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }
}
