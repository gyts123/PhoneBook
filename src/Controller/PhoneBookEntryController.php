<?php

namespace App\Controller;

use App\Entity\PhoneBookEntry;
use App\Entity\SharedEntries;
use App\Form\PhoneBookEntryType;
use App\Repository\PhoneBookEntryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneBookEntryController extends AbstractController
{
    /**
     * @Route("/pbEntry", name="phone_book_entry_index", methods={"GET"})
     * @param PhoneBookEntryRepository $phoneBookEntryRepository
     * @return Response
     */
    public function index(PhoneBookEntryRepository $phoneBookEntryRepository): Response
    {
        return $this->render('phone_book_entry/index.html.twig', [
            'phone_book_entries' => $phoneBookEntryRepository->findByUser($this->getUser()->getId()),// findAll(),
        ]);
    }

    /**
     * @Route("/pbEntry/new", name="phone_book_entry_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $phoneBookEntry = new PhoneBookEntry();
        $form = $this->createForm(PhoneBookEntryType::class, $phoneBookEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phoneBookEntry->setFkUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($phoneBookEntry);
            $entityManager->flush();

            return $this->redirectToRoute('phone_book_entry_index');
        }

        return $this->render('phone_book_entry/new.html.twig', [
            'phone_book_entry' => $phoneBookEntry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pbEntry/{id}", name="phone_book_entry_show", methods={"GET"})
     * @param PhoneBookEntry $phoneBookEntry
     * @return Response
     */
    public function show(PhoneBookEntry $phoneBookEntry): Response
    {
        return $this->render('phone_book_entry/show.html.twig', [
            'phone_book_entry' => $phoneBookEntry,
        ]);
    }

    /**
     * @Route("/pbEntry/{id}/edit", name="phone_book_entry_edit", methods={"GET","POST"})
     * @param Request $request
     * @param PhoneBookEntry $phoneBookEntry
     * @return Response
     */
    public function edit(Request $request, PhoneBookEntry $phoneBookEntry): Response
    {
        $form = $this->createForm(PhoneBookEntryType::class, $phoneBookEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_book_entry_index');
        }

        return $this->render('phone_book_entry/edit.html.twig', [
            'phone_book_entry' => $phoneBookEntry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pbEntry/{id}", name="phone_book_entry_delete", methods={"DELETE"})
     * @param Request $request
     * @param PhoneBookEntry $phoneBookEntry
     * @return Response
     */
    public function delete(Request $request, PhoneBookEntry $phoneBookEntry): Response
    {
        if ($this->isCsrfTokenValid('delete' . $phoneBookEntry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phoneBookEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_book_entry_index');
    }

    /**
     * @Route("/pbEntry/{id}/share", name="phone_book_entry_share", methods={"GET"})
     * @param int $id
     * @param UserRepository $userRepository
     * @param PhoneBookEntryRepository $phoneBookEntryRepository
     * @return Response
     */
    public function share(int $id, UserRepository $userRepository, PhoneBookEntryRepository $phoneBookEntryRepository): Response
    {
        return $this->render('phone_book_entry/share.html.twig', [
            'entry' => $phoneBookEntryRepository->find($id),
            'users' => $userRepository->findUsersWithoutCurrentlyLoggedIn($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/pbEntry/{id}/{userId}/share", name="phone_book_entry_share_submit", methods={"GET"})
     * @param int $id
     * @param int $userId
     * @param UserRepository $userRepository
     * @param PhoneBookEntryRepository $phoneBookEntryRepository
     * @return Response
     */
    public function shareSubmit(int $id, int $userId, UserRepository $userRepository, PhoneBookEntryRepository $phoneBookEntryRepository): Response
    {
        $sharedEntry = new SharedEntries();
        $sharedEntry->setFkUser($userRepository->find($userId));
        $sharedEntry->setFkPhoneBookEntry($phoneBookEntryRepository->find($id));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($sharedEntry);
        $entityManager->flush();

        $this->addFlash('success', 'Successfully shared Phone entry!');

        return $this->redirectToRoute('phone_book_entry_index');
    }
}
