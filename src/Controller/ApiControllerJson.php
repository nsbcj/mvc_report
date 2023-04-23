<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\CardHand;

class ApiControllerJson extends AbstractController
{
    /**
     * @Route("/api", name="api", methods="GET")
     */
    public function api(): Response
    {
        return $this->render("api/api.html.twig");
    }

    /**
     * @Route("/api/quote", name="quoteApi", methods="GET")
     */
    public function quoteApi(): Response
    {
        $quotes = [
            "Bättre sent än aldrig",
            "Det viktigaste är att deltaga",
            "Listig som en räv"
        ];

        $random = rand(0, 2);

        $data = [
            "quotes" => $quotes[$random],
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }



    /**
     * @Route("/api/deck", name="deckApi", methods="GET")
     */
    public function deckApi(): Response
    {
        $deck = new DeckOfCards();
        $deck->init();

        $data = [
            "deck" => $deck->getDeckAsString(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/deck/shuffle", name="shuffleApi", methods="POST")
     */
    public function shuffleApi(
        SessionInterface $session
    ): Response {
        $sessionDeck = $session->get("deck") ?? null;

        if(isset($sessionDeck)) {
            $session->remove("deck");
        }

        $deck = new DeckOfCards();
        $deck->init();
        $deck->shuffle();
        $session->set("deck", $deck);

        $data = [
            "deck" => $deck->getDeckAsString(),
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/deck/draw/{num<\d+>}", name="drawApi", methods="POST")
     */
    public function drawApi(
        SessionInterface $session,
        int $num=1
    ): Response {
        $deck = $session->get("deck") ?? null;
        $hand = $session->get("hand") ?? null;

        if (!isset($deck)) {
            $deck = new DeckOfCards();
            $deck->init();
            $deck->shuffle();
        }

        $deckLength = $deck->getDeckLength();

        if (($deckLength - $num) < 0) {
            $this->addFlash(
                "warning",
                "Not enough cards left in deck, a new deck is shuffled"
            );
            $session->remove("deck");
            return $this->redirectToRoute('api');
        }

        if (!isset($hand)) {
            $hand = new CardHand();
        }

        for ($i=0; $i < $num; $i++) {
            $hand->add($deck);
        }

        $session->set("deck", $deck);

        $data = [
            "card" => $hand->getHandAsString(),
            "deckLength" => $deckLength - $num,
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/game", name="gameApi", methods="POST")
     */
    public function gameApi(
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        $data = [];

        if (isset($game)) {
            $data = $game->play();
        }

        return new JsonResponse($data);
    }
}
