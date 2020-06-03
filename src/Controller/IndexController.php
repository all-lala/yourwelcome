<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * Index l'application
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('base.html.twig', []);
    }
}
