<?php

namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function getMainPage()
    {
        try {
            new PDO('mysql:host=mysql;charset=utf8', 'root', '12345');
        } catch (\Exception $e) {
            return new Response('buy world');
        };
        return new Response('hello world');
    }
}