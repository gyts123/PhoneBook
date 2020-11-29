<?php

namespace App\Controller;

use App\Entity\PhoneBookEntry;
use App\Form\PhoneBookEntryType;
use App\Repository\PhoneBookEntryRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PhoneBookEntryController extends AbstractController
{
    /**
     * @Route("/", name="phone_book_entry_index", methods={"GET","POST"})
     * @param PhoneBookEntryRepository $phoneBookEntryRepository
     * @return Response
     */
    public function index(PhoneBookEntryRepository $phoneBookEntryRepository): Response
    {
        return $this->render('phone_book_entry/index.html.twig', [
            'phone_book_entries' => $phoneBookEntryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="phone_book_entry_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $phoneBookEntry = new PhoneBookEntry();
        $form = $this->createForm(PhoneBookEntryType::class, $phoneBookEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/{id}", name="phone_book_entry_show", methods={"GET"})
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
     * @Route("/{id}/edit", name="phone_book_entry_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="phone_book_entry_delete", methods={"DELETE"})
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
}
