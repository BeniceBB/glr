<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(): Response
    {
        $localPackage = new UrlPackage(
            'file://assets/img', new EmptyVersionStrategy()
        );
        return $this->render('index.html.twig', [
            'controller_name' => 'DefaultController',
            'localPackage' => $localPackage,
        ]);
    }
}
