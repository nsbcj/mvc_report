<?php

namespace App\Controller;

use App\Entity\Players;
use App\Entity\Stats;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlayersRepository;
use App\Repository\StatsRepository;

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
        ManagerRegistry $doctrine,
        PlayersRepository $playersRepository,
        StatsRepository $statsRepository,
        SessionInterface $session
    ): Response {
        $game = $session->get("game") ?? null;

        $data = [];

        if (!isset($game)) {
            $players = $playersRepository->findAll();
            $stats = $statsRepository->findAll();
            $data["players"] = $players;
            $data["stats"] = $stats;

            $this->addFlash(
                "notice",
                "Starta ett nytt spel genom att skriva in ett spelarnamn nedan"
            );
            return $this->render('proj/index.html.twig', $data);
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

        if($game->done) {
            // Save player balance to database
            $player = $playersRepository->findOneBy(["name"=>$game->player->name]);
            $player->setBalance($game->player->wallet->getBalance());

            $playersRepository->save($player, true);

            // Save round statistics to database
            $winnerCount = count(array_filter($game->winners, function ($hand) {
                return $hand["winner"];
            }));

            $tieCount = count(array_filter($game->winners, function ($hand) {
                return $hand["tie"];
            }));

            $totalBet = array_reduce($data["playerHands"], function ($sum, $hand) {
                $sum += $hand["handBet"];
                return $sum;
            });

            $totalReturn = array_reduce($game->winners, function ($sum, $hand) {
                $sum += $hand["return"];
                return $sum;
            });

            $entityManager = $doctrine->getManager();
            $stats = new Stats();
            $stats->setHands($game->player->getCountOfHands());
            $stats->setWins($winnerCount);
            $stats->setTies($tieCount);
            $stats->setTotalbet($totalBet);
            $stats->setTotalreturn($totalReturn);

            $entityManager->persist($stats);

            $entityManager->flush();
        }

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
     * @Route("/proj/player/delete", name="projectDeletePlayer", methods="POST")
     */
    public function projectDeletePlayer(
        PlayersRepository $playersRepository,
        SessionInterface $session,
        Request $request
    ): Response {
        $name = $request->request->get("name") ?? null;

        $player = $playersRepository->findOneBy(["name"=>$name]);

        $playersRepository->remove($player, true);

        $this->addFlash(
            "warning",
            "{$name}:s konto har loggats ut och tagits bort"
        );

        $session->set("game", null);

        return $this->redirectToRoute("project");
    }

    /**
     * @Route("/proj/init", name="projectInit", methods="POST")
     */
    public function projectInit(
        PlayersRepository $playersRepository,
        ManagerRegistry $doctrine,
        SessionInterface $session,
        Request $request
    ): Response {
        $player = $request->request->get("name") ?? null;
        $start = $request->request->get("start") ?? null;
        $balance = $request->request->get("balance") ?? null;
        $playerDb = $playersRepository->findOneBy(["name"=>$player]) ?? null;
        if(isset($playerDb) && isset($start)) {
            $this->addFlash(
                "warning",
                "Spelarnamn {$player} är redan taget, välj ett annat"
            );
            return $this->redirectToRoute("project");
        }

        $house = "Huset";

        if(isset($player)) {
            $game = new ProjGame();
            $game->init();
            $game->player->setPlayer($player);
            $game->house->setPlayer($house);

            if(!isset($playerDb) && isset($start)) {
                $entityManager = $doctrine->getManager();

                $players = new Players();

                $players->setName($game->player->name);

                $players->setBalance($game->player->wallet->getBalance());

                $entityManager->persist($players);

                $entityManager->flush();

                $this->addFlash(
                    "notice",
                    "Spelarnamn {$player} är tillagt"
                );
            }

            if(isset($balance)) {
                $game->player->wallet->setBalance($balance);
            }

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
                    "Spelaren fick över 21"
                );
            }

            if ($game->player->checkPlayerDone()) {
                $game->autoPlay();

                $game->setDone();

                $game->setWinners();

                $this->addFlash(
                    "notice",
                    "Huset spelade sin hand"
                );
            }

            $this->addFlash(
                "notice",
                "Spelaren drog ett kort"
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
                    "Huset spelade sin hand"
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
            if($game->player->wallet->getBalance() < $bet) {
                $this->addFlash(
                    "warning",
                    "{$game->player->name} har inte tillräcklig balans för att splitta"
                );

                return $this->redirectToRoute("project");
            }
            $game->player->splitPlayerHand($handIdx);

            $game->player->wallet->withdrawBalance($bet);

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "{$game->player->name} splittade handen"
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
            if($game->player->wallet->getBalance() < $bet) {
                $this->addFlash(
                    "warning",
                    "{$game->player->name} balans är inte tillräcklig för att dubbla"
                );

                return $this->redirectToRoute("project");
            }
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
                    "Spelaren dubblade, spelade ett kort och huset spelade sin hand"
                );
            }

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "{$game->player->name} dubblade. {$bet} lades till i handen och ett kort drogs"
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

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "{$game->player->name} Lade till hand med {$bet} som insats"
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
                $game->player->wallet->withdrawBalance($hand->bet);
            }

            $game->house->addHandWithoutBet();
            $game->house->drawWithoutBet($game->deck);
            $game->house->drawWithoutBet($game->deck);

            $game->start();

            $session->set("game", $game);

            $this->addFlash(
                "notice",
                "{$game->player->name} startade spelet"
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
                "En ny runda startades av {$game->player->name}"
            );
        }

        return $this->redirectToRoute("project");
    }
}
