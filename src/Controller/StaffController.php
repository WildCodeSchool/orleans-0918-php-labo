<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\EnableDisableStaffType;
use App\Form\StaffType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaffController
 * @package App\Controller
 * @Route("/staff")
 */
class StaffController extends AbstractController
{
    /**
     * @Route("/index/{id}", defaults={"id"=null}, name="staff_index", methods="GET|POST")
     * @param Staff|null $staffEnableDisable
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, Staff $staffEnableDisable = null, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getmanager()->getRepository(Staff::class);
        $staffs= $em->findBy([], ['isActive'=>'DESC']);

        $formStaff = [];

        foreach ($staffs as $staff) {
            $form = $this->createForm(EnableDisableStaffType::class, $staff);
            $form->handleRequest($request);
            $formStaff[$staff->getId()]=$form->createView();
        }

        if (!is_null($staffEnableDisable) && $form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            if ($staffEnableDisable->getIsActive() === true) {
                $staffEnableDisable->setIsActive(false);
            } else {
                $staffEnableDisable->setIsActive(true);
            }
            $em->persist($staffEnableDisable);
            $em->flush();

            return $this->redirectToRoute('staff_index');
        }
        $results = $paginator->paginate(
            $staffs,
            $request->query->getInt('page', 1),
            $this->getParameter('limitPaginator')
        );
        return $this->render('staff/index.html.twig', [
            'staffs' =>$results,
            'formStaff' => $formStaff,
        ]);
    }

    /**
     * @Route("/new", name="staff_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $staff->setIsActive(true);
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
     * @Route("/{id}/edit", name="staff_edit", methods="GET|POST")
     * @param Request $request
     * @param Staff $staff
     * @return Response
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
}
