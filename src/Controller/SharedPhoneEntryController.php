<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SharedEntriesRepository;
use Psr\Log\LoggerInterface;

class SharedPhoneEntryController extends AbstractController
{
    /**
     * @Route("/shared/entries", name="shared_phone_entry")
     * @param SharedEntriesRepository $sharedEntriesRepository
     * @return Response
     */
    public function sharedEntryList(SharedEntriesRepository $sharedEntriesRepository): Response
    {
        return $this->render('shared_phone_entry/index.html.twig', [
            'shared_entries' => $sharedEntriesRepository->findByUser($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/myShared/entries", name="my_shared_phone_entry")
     * @param SharedEntriesRepository $sharedEntriesRepository
     * @return Response
     */
    public function mySharedEntryList(SharedEntriesRepository $sharedEntriesRepository): Response
    {
        return $this->render('shared_phone_entry/my_shared_list.html.twig', [
            'shared_entries' => $sharedEntriesRepository->findEntriesThatWereSharedByUser($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/myShared/{id}/remove", name="remove_my_shared_phone_entry")
     * @param int $id
     * @param SharedEntriesRepository $sharedEntriesRepository
     * @param LoggerInterface $logger
     * @return Response
     */
    public function removeSharedEntry(int $id, SharedEntriesRepository $sharedEntriesRepository, LoggerInterface $logger): Response
    {
        try {
            $sharedEntry = $sharedEntriesRepository->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sharedEntry);
            $entityManager->flush();
        } catch (\Exception $e) {
            $logger->debug($e->getMessage());
        }

        return $this->redirectToRoute("my_shared_phone_entry");
    }
}
