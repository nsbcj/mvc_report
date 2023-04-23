<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    /**
     * @Route("/api/quote")
     */
    public function number(): Response
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
     * @Route("/api/lucky/number2")
     */
    public function number2(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'message' => 'Welcome to the lucky number API',
            'lucky-number' => $number
        ];

        return new JsonResponse($data);
    }



    /**
     * @Route("/api/lucky/number/{min}/{max}")
     */
    public function number3(int $min, int $max): Response
    {
        $number = random_int($min, $max);

        $data = [
            'message' => 'Welcome to the lucky number API',
            'min number' => $min,
            'max number' => $max,
            'lucky-number' => $number
        ];

        return new JsonResponse($data);
    }
}
