<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Form\HotelType;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index(): Response
    {

        $hotels = $this->getDoctrine()->getManager()->getRepository(Hotel::class)->findALL();
        return $this->render('hotel/index.html.twig', ['hotels' => $hotels]);
    }


    /**
     * @Route("/addHotel", name="addHotel")
     */

    public function addHotel(Request $request): Response
    {
        $Hotel= new Hotel();

        $form = $this->createForm(HotelType::class, $Hotel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Hotel);
            $em->flush();

            return $this->redirectToRoute('hotel');
        }
        return $this->render('hotel/CreateHotel.html.twig', ['a' => $form->createView()]);

    }

    /**
     * @Route("/removehotel/{id}",name="hoteldel")
     */
    public function delhotel(Hotel $hotel): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();

        return $this->redirectToRoute('hotel');

    }


    /**
     * @Route("/edithotel/{id}", name="edithotel")
     */

    public function edithotel(Request $request,$id): Response
    {
        $hotel = $this->getDoctrine()->getManager()->getRepository(Hotel::class)->find($id);

        $form = $this->createForm(HotelType::class, $hotel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('hotel');
        }
        return $this->render('hotel/updatehotel.html.twig', ['a' => $form->createView()]);

    }
}
