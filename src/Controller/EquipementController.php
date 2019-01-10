<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EquipementController
 * @package App\Controller
 * @Route("/equipement")
 */
class EquipementController extends AbstractController
{
    /**
     * @Route("/", name="equipement_index", methods="GET")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */

    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getmanager()->getRepository(Equipement::class);
        $equipements = $em->findAll(['id'=>'DESC']);

        $results = $paginator->paginate(
            $equipements,
            $request->query->getInt('page', 1),
            $this->getParameter('limitPaginator')
        );
        return $this->render('equipement/index.html.twig', [
            'equipements' => $results,
        ]);
    }

    /**
     * @Route("/new", name="equipement_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush();

            $this->addFlash(
                'success',
                'Equipement bien créé !'
            );

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipement_edit", methods="GET|POST")
     * @param Request $request
     * @param Equipement $equipement
     * @return Response
     */
    public function edit(Request $request, Equipement $equipement): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Modification bien effectuée !'
            );

            return $this->redirectToRoute('equipement_index', ['id' => $equipement->getId()]);
        }

        return $this->render('equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }
}
