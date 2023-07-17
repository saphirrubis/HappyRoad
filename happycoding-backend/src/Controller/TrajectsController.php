<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrajectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrajectsController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('hr/home', name: 'App_trajects_home')]
    public function readTrajects(TrajectRepository $trajectRepository, SerializerInterface $serializerInterface): jsonResponse
    {
        $latestTrajects = $trajectRepository->findLatestTrajects();

        $serializedTrajects = $serializerInterface->serialize($latestTrajects, 'json');

        return new jsonResponse($serializedTrajects, 200, [], true);
    }
}
