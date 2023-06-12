<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findall();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }

    #[Route('/program/new', name: 'program_new')]
    public function new(): Response
    {
        $program = new Program();


        $form = $this->createForm(ProgramType::class, $program);
        
        // Render the form

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('program/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(int $id,ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$id]);

        if (!$program){
            throw $this->createNotFoundException(
                'No program with id :' . $id . 'found in programs table.'
            );
        }
        return $this->render('program/show.html.twig',
        ['program' => $program,
        ]);
    }

    #[Route("/program/{programId}/season/{seasonId}", name: 'program_season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$programId]);
        $season = $seasonRepository->find($seasonId);

        if (!$program || !$season) {
            throw $this->createNotFoundException('Program or Season not found');
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }
    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'program_episode_show')]
    public function showEpisode(Program $program,Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode]);
    }
}