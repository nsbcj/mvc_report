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
     * @Route("/metrics", name="metricsDoc", methods="GET")
     */
    public function metrics(): Response
    {
        $parsedown = new ParsedownExtra();

        $file = "content/metrics/doc.md";

        $data = [
            "doc" => $parsedown -> text(file_get_contents($file))
        ];

        return $this->render('metrics/index.html.twig', $data);
    }

    /**
     * @Route("/report", name="report")
     */
    public function report(): Response
    {
        $parsedown = new ParsedownExtra();

        $contentFiles = glob("content/reports/*.md");

        $parsedFiles = [];

        $data = [];

        foreach ($contentFiles as $file) {
            array_push($parsedFiles, [
                "name" => basename($file, ".md"),
                "content" => $parsedown -> text(file_get_contents($file))
            ]);
        }

        $data["content"] = $parsedFiles;
        return $this->render('report.html.twig', $data);
    }

    /**
     * @Route("/lucky", name="lucky")
     */
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
    }
}
