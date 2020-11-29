<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SharedEntriesRepository;

class SharedPhoneEntryController extends AbstractController
{
    /**
     * @Route("/shared/entries", name="shared_phone_entry")
     */
    public function sharedEntryList(SharedEntriesRepository $sharedEntriesRepository ): Response
    {
        $sharedEntries = $sharedEntriesRepository->findByUser($this->getUser()->getId());

        return $this->render('shared_phone_entry/index.html.twig', [
            'shared_entries' => $sharedEntries,
        ]);
    }
}
