<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/programs/", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * The controller for the program add form
     * Display the form or deal with it
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form);
            $entityManager->flush();

        return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("show/{id<^[0-9]+$>}", name="show")
     */
    public function show(Program $program): Response
    {
        if (!$program){
            throw $this->createNotFoundException(
                'No program with id'.$program.' found in program\'s table'
            );
        }
        return $this->render('program/show.html.twig', [
            'program'=>$program
            ]);
    }

    /**
     * @Route("{program<^[0-9]+$>}/season/{season<^[0-9]+$>}", name="season_show")
     */
    public function showSeason(Program $program, Season $season) : Response
    {
        if (!$program){
            throw $this->createNotFoundException(
                'No program with id'.$program.' found in program\'s table'
            );
        }

        if (!$season){
            throw $this->createNotFoundException(
                'No season with id'.$season.' found in season\'s table'
            );
        }

        $episodes = $this->getDoctrine()
        ->getRepository(Episode::class)
        ->findAll();

        return $this->render('program/season_show.html.twig', [
            'program'=>$program,
            'season'=>$season,
            'episodes'=>$episodes
            ]);
    }
    
    /**
     * @Route("{programId}/seasons/{seasonId}/episodes/{episodeId}", name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode) : Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program'=>$program,
            'season'=>$season,
            'episode'=>$episode
            ]);
    }
}
