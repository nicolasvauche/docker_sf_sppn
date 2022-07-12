<?php

namespace App\Controller;

use App\Entity\Todolist;
use App\Form\TodolistType;
use App\Repository\TodolistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todolist', name: 'app_todolist_')]
class TodolistController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TodolistRepository $todolistRepository): Response
    {
        dd($todolistRepository->findAll());

        return $this->render('todolist/index.html.twig', [
            //'todolist' => $todolistRepository->findAll(),
        ]);
    }

    #[Route('/creer', name: 'add')]
    public function add(TodolistRepository $todolistRepository, Request $request): Response
    {
        $todolist = new Todolist();

        $form = $this->createForm(TodolistType::class, $todolist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todolist = $form->getData();
            $todolistRepository->add($todolist, true);
        }

        return $this->renderForm('todolist/add.html.twig', [
            'form' => $form,
        ]);
    }
}
