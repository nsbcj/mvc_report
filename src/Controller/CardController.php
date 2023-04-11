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

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card", methods="GET")
     */
    public function card(): Response
    {
        $card = new CardGraphic();
        $card->setCard("spades", 13);

        $data = [
            "card" => $card->getAsString()
        ];
        echo $data["card"];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="deck", methods="GET")
     */
    public function deck(): Response
    {
        $deck = new DeckOfCards();
        $deck->init();

        $data = [
            "deck" => $deck->getDeckAsString()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle", methods="GET")
     */
    public function shuffle(
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
            "deck" => $deck->getDeckAsString()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw/{num<\d+>}", name="draw", methods="GET")
     */
    public function draw(
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
            return $this->redirectToRoute('shuffle');
        }

        if (!isset($hand)) {
            $hand = new CardHand();
        }

        for ($i=0; $i < $num; $i++) {
            $hand->add($deck);
        }

        $session->set("deck", $deck);

        $data = [
            "hand" => $hand->getHandAsString(),
            "deckLength" => $deckLength - $num
        ];

        return $this->render('card/hand.html.twig', $data);
    }
}
