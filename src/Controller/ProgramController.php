<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    public function index(): Response
    {
        /**
         * @Route("/programs/", name="program_index")
         */
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Séries',
         ]);
    }
}
