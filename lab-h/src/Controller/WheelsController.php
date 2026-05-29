<?php

namespace App\Controller;

use App\Entity\Wheels;
use App\Form\WheelsType;
use App\Repository\WheelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wheels')]
final class WheelsController extends AbstractController
{
    #[Route(name: 'app_wheels_index', methods: ['GET'])]
    public function index(WheelsRepository $wheelsRepository): Response
    {
        return $this->render('wheels/index.html.twig', [
            'wheels' => $wheelsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_wheels_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wheel = new Wheels();
        $form = $this->createForm(WheelsType::class, $wheel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wheel);
            $entityManager->flush();

            return $this->redirectToRoute('app_wheels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wheels/new.html.twig', [
            'wheel' => $wheel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wheels_show', methods: ['GET'])]
    public function show(Wheels $wheel): Response
    {
        return $this->render('wheels/show.html.twig', [
            'wheel' => $wheel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wheels_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wheels $wheel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WheelsType::class, $wheel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wheels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wheels/edit.html.twig', [
            'wheel' => $wheel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wheels_delete', methods: ['POST'])]
    public function delete(Request $request, Wheels $wheel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wheel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($wheel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wheels_index', [], Response::HTTP_SEE_OTHER);
    }
}
