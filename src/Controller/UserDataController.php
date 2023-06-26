<?php

namespace App\Controller;

use App\Entity\UserData;
use App\Form\UserDataType;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class UserDataController extends AbstractController
{
    #[Route('/all', name: 'app_user_data_index', methods: ['GET'])]
    public function index(UserDataRepository $userDataRepository): Response
    {
        return $this->render('user_data/index.html.twig', [
            'user_datas' => $userDataRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_user_data_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserDataRepository $userDataRepository): Response
    {
        $userDatum = new UserData();
        $form = $this->createForm(UserDataType::class, $userDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDataRepository->save($userDatum, true);

            return $this->redirectToRoute('app_user_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_data/new.html.twig', [
            'user_datum' => $userDatum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_data_show', methods: ['GET'])]
    public function show(UserData $userDatum): Response
    {
        return $this->render('user_data/show.html.twig', [
            'user_datum' => $userDatum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_data_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserData $userDatum, UserDataRepository $userDataRepository): Response
    {
        $form = $this->createForm(UserDataType::class, $userDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDataRepository->save($userDatum, true);

            return $this->redirectToRoute('app_user_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_data/edit.html.twig', [
            'user_datum' => $userDatum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_data_delete', methods: ['POST'])]
    public function delete(Request $request, UserData $userDatum, UserDataRepository $userDataRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userDatum->getId(), $request->request->get('_token'))) {
            $userDataRepository->remove($userDatum, true);
        }

        return $this->redirectToRoute('app_user_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
