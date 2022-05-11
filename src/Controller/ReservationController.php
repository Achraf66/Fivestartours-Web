<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(): Response
    {
        $reservations = $this->getDoctrine()->getManager()->getRepository(Reservation::class)->findALL();
        return $this->render('reservation/index.html.twig',
            ['reservations' => $reservations]);
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function indexadmin(): Response
    {

        return $this->render('reservation/index.html.twig'
        );
    }


    /**
     * @Route("/addReservation", name="addReservation")
     */

    public function addReservation(Request $request): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);//Add
            $em->flush();

            $this ->addFlash(
                'info',
                'added successfully!'

            );
            return $this->redirectToRoute('app_reservation');
        }
        return $this->render('reservation/CreateReservation.html.twig', ['f' => $form->createView()]);

    }
    /**
     * @Route("/removereservation/{id}",name="supp_reservation")
     */
    public function suppressionReservation(Reservation $reservation): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();

        return $this->redirectToRoute('app_reservation');

    }
    /**
     * @Route("/editReservation/{id}", name="editReservation")
     */

    public function editReservation(Request $request ,$id): Response
    {
        $reservation = $this->getDoctrine()->getManager()->getRepository(Reservation::class)->find($id);


        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            $this ->addFlash(
                'info',
                'edited successfully!' );

            return $this->redirectToRoute('app_reservation');
        }
        return $this->render('reservation/updateReservation.html.twig', ['f' => $form->createView()]);

    }


}