<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Reservation;
use App\Entity\ReservationEquipement;
use App\Form\ArchiveType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Service\SignatureService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods="GET")
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', ['reservations' => $reservationRepository->findAll()]);
    }

    /**
     * @Route("/current/{id}", defaults={"id"=null}, name="current_reservation_index", methods="GET|POST")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param Reservation $reservationArchive
     * @return Response
     */
    public function currentReservationIndex(
        Request $request,
        Reservation $reservationArchive = null,
        PaginatorInterface $paginator
    ) {
      
        $em = $this->getDoctrine()->getmanager()->getRepository(Reservation::class);
        $reservations = $em->findBy(['isArchived' => '0'], ['id'=>'DESC']);

        $formArchive = [];

        foreach ($reservations as $reservation) {
            $form = $this->createForm(ArchiveType::class, $reservation);
            $form->handleRequest($request);
            $formArchive[$reservation->getId()]=$form->createView();
        }

        if (!is_null($reservationArchive) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reservationArchive->setIsArchived(1);
            $reservationArchive->setEndDate(new\DateTime());


            $em->persist($reservationArchive);
            $em->flush();

            $this->addFlash(
                'success',
                'Réservation archivée !'
            );

            return $this->redirectToRoute('current_reservation_index');
        }
        $results = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1),
            $this->getParameter('limitPaginator')
        );

        return $this->render('reservation/currentReservations.html.twig', [
            'reservations'=> $results,
            'formArchive' => $formArchive,
            ]);
    }
    /**
     * @Route("/archive", name="archive_reservation_index", methods="GET")
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function archiveReservationIndex(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getmanager()->getRepository(Reservation::class);
        $reservations = $em->findBy(['isArchived' => 'true'], ['startDate'=>'DESC']);

        $result = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1),
            $this->getParameter('limitPaginator')
        );
        return $this->render('reservation/archiveReservations.html.twig', [
            'reservations'=> $result,
        ]);
    }
    /**
     * @Route("/new", name="reservation_new", methods="GET|POST")
     */
    public function new(Request $request, SignatureService $signatureService): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipements = $em->getRepository(Equipement::class)->findAll();
        $reservation = new Reservation();
      
        foreach ($equipements as $equipement) {
            $reservationEquipements = new ReservationEquipement();
            $reservationEquipements->setEquipement($equipement);
            $reservationEquipements->setQuantity(0);
            $reservationEquipements->setReservation($reservation);
            $reservation->addReservationEquipement($reservationEquipements);
        }
      
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reservation->getSignature();
            $reservation->setSignature($signatureService->add(
                $reservation->getSignature()
            ));

            foreach ($reservation->getReservationEquipements() as $reservationEquipements) {
                if ($reservationEquipements->getQuantity() == 0) {
                    $reservation->removeReservationEquipement($reservationEquipements);
                }
            }
            $reservation->setStartDate(new\DateTime());
            $em->persist($reservation);
            $em->flush();

            $this->addFlash(
                'success',
                'Reservation bien enregistrée !'
            );

            return $this->redirectToRoute('current_reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods="GET")
     */
    public function show(Reservation $reservation): Response
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Modification effectuée avec succès !'
            );

            return $this->redirectToRoute('current_reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods="DELETE")
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();

            $this->addFlash(
                'success',
                'Reservation bien supprimée !'
            );
        }

        return $this->redirectToRoute('reservation_index');
    }
}
