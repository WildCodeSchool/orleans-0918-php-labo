<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/staff")
 */
class StaffController extends AbstractController
{
    /**
     * @Route("/", name="staff_index", methods="GET")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getmanager()->getRepository(Staff::class);
        $staffs = $em->findAll(['id'=>'DESC']);

        $results = $paginator->paginate(
            $staffs,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );
        return $this->render('staff/index.html.twig', [
            'staffs' => $results,
        ]);
    }

    /**
     * @Route("/new", name="staff_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($staff);
            $em->flush();

            $this->addFlash(
                'success',
                'Personnel bien créé !'
            );

            return $this->redirectToRoute('staff_index');
        }

        return $this->render('staff/new.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="staff_show", methods="GET")
     */
    public function show(Staff $staff): Response
    {
        return $this->render('staff/show.html.twig', ['staff' => $staff]);
    }

    /**
     * @Route("/{id}/edit", name="staff_edit", methods="GET|POST")
     */
    public function edit(Request $request, Staff $staff): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Modification bien effectuée !'
            );

            return $this->redirectToRoute('staff_index', ['id' => $staff->getId()]);
        }

        return $this->render('staff/edit.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="staff_delete", methods="DELETE")
     */
    public function delete(Request $request, Staff $staff): Response
    {
        if ($this->isCsrfTokenValid('delete' . $staff->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($staff);
            $em->flush();
        }
        $this->addFlash(
            'success',
            'Suppression bien effectuée !'
        );

        return $this->redirectToRoute('staff_index');
    }
}
