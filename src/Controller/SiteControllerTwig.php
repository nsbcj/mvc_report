<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use ParsedownExtra;

class SiteControllerTwig extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/report", name="report")
     */
    public function report(): Response
    {
        $parsedown = New ParsedownExtra();

        $content_files = glob("content/*.md");

        $parsed_files = [];

        foreach ($content_files as $file) {
            array_push($parsed_files, [
                "name" => basename($file, ".md"),
                "content" => $parsedown -> text(file_get_contents($file))
            ]);
        }

        $data["content"] = $parsed_files;
        return $this->render('report.html.twig', $data);
    }

    /**
     * @Route("/lucky", name="lucky")
     */
    public function lucky(): Response
    {
        $this->number = random_int(0, 100);

        $data = [
            'number' => $this->number
        ];

        return $this->render('lucky.html.twig', $data);
    }
}
