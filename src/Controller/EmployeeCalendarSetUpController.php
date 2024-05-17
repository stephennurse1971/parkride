<?php

namespace App\Controller;

use App\Entity\EmployeeCalendarSetUp;
use App\Form\EmployeeCalendarSetUpType;
use App\Repository\EmployeeCalendarSetUpRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employee/calendar/setup")
 * @Security("is_granted('ROLE_STAFF')")
 */
class EmployeeCalendarSetUpController extends AbstractController
{
    /**
     * @Route("/", name="employee_calendar_set_up_index", methods={"GET"})
     */
    public function index(EmployeeCalendarSetUpRepository $employeeCalendarSetUpRepository): Response
    {
        return $this->render('employee_calendar_set_up/index.html.twig', [
            'employee_calendar_set_ups' => $employeeCalendarSetUpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employee_calendar_set_up_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EmployeeCalendarSetUpRepository $employeeCalendarSetUpRepository, UserRepository $userRepository): Response
    {
        $employeeCalendarSetUp = new EmployeeCalendarSetUp();
        $employees = [];
        foreach ($userRepository->findAll() as $user){
            if(in_array('ROLE_STAFF',$user->getRoles())){
                $employees[] = $user;
            }
        }

        $form = $this->createForm(EmployeeCalendarSetUpType::class, $employeeCalendarSetUp,['employee'=>$employees]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeCalendarSetUpRepository->add($employeeCalendarSetUp, true);

            return $this->redirectToRoute('employee_calendar_set_up_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_calendar_set_up/new.html.twig', [
            'employee_calendar_set_up' => $employeeCalendarSetUp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="employee_calendar_set_up_show", methods={"GET"})
     */
    public function show(EmployeeCalendarSetUp $employeeCalendarSetUp): Response
    {
        return $this->render('employee_calendar_set_up/show.html.twig', [
            'employee_calendar_set_up' => $employeeCalendarSetUp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_calendar_set_up_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EmployeeCalendarSetUp $employeeCalendarSetUp, EmployeeCalendarSetUpRepository $employeeCalendarSetUpRepository): Response
    {
        $form = $this->createForm(EmployeeCalendarSetUpType::class, $employeeCalendarSetUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeCalendarSetUpRepository->add($employeeCalendarSetUp, true);

            return $this->redirectToRoute('employee_calendar_set_up_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_calendar_set_up/edit.html.twig', [
            'employee_calendar_set_up' => $employeeCalendarSetUp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="employee_calendar_set_up_delete", methods={"POST"})
     */
    public function delete(Request $request, EmployeeCalendarSetUp $employeeCalendarSetUp, EmployeeCalendarSetUpRepository $employeeCalendarSetUpRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeCalendarSetUp->getId(), $request->request->get('_token'))) {
            $employeeCalendarSetUpRepository->remove($employeeCalendarSetUp, true);
        }

        return $this->redirectToRoute('employee_calendar_set_up_index', [], Response::HTTP_SEE_OTHER);
    }
}
