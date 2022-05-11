<?php

namespace App\Controller;


use App\Entity\Airline;
use App\Entity\Vol;
use App\Form\AirlineType;
use App\Repository\AirlineRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class AirlineController extends AbstractController
{
    /**
     * @Route("/airline", name="airline")
     */
    public function index(): Response
    {

        $airlines = $this->getDoctrine()->getManager()->getRepository(Airline::class)->findALL();
        return $this->render('airline/index.html.twig', ['airlines' => $airlines]);
    }


    /**
     * @Route("/addAirline", name="addAirline")
     */

    public function addAirline(Request $request, FlashyNotifier $flashy): Response
    {
        $Airline = new Airline();

        $form = $this->createForm(AirlineType::class, $Airline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Airline);
            $em->flush();

            $flashy->success("Airline Ajouter avec Succés", 'airline');

            return $this->redirectToRoute('airline');

        }
        return $this->render('airline/CreateAirline.html.twig', ['a' => $form->createView()]);

    }


    /**
     * @Route("/removeairline/{id}",name="airlinedel")
     */
    public function delairline(Airline $airline, FlashyNotifier $flashy): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($airline);
        $em->flush();

        $flashy->error("Airline Supprimer avec Succés", 'airline');

        return $this->redirectToRoute('airline');

    }


    /**
     * @Route("/editairline/{id}", name="editairline")
     */

    public function editairline(Request $request, $id, FlashyNotifier $flashy): Response
    {
        $airline = $this->getDoctrine()->getManager()->getRepository(Airline::class)->find($id);

        $form = $this->createForm(AirlineType::class, $airline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $flashy->error("Airline modifier avec Succés", 'airline');

            return $this->redirectToRoute('airline');
        }
        return $this->render('airline/updateairline.html.twig', ['a' => $form->createView()]);

    }


    /**
     * @Route("/statR", name="SR")
     */


    public function static(AirlineRepository $repo)
    {

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Statistique Airlines');
        $ob->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));

        $offre = $repo->stat1();
        $data = array();
        foreach ($offre as $values) {
            $a = array($values['nomairline'], intval($values['id']));
            array_push($data, $a);

        }

        $ob->series(array(array('type' => 'pie', 'name' => 'Nombre de vols', 'data' => $data)));
        return $this->render('Airline/index1.html.twig', array(
            'chart' => $ob
        ));
    }

    /**
     * @Route("/addairlineJson/new",name="addairlineJson")
     */

    public function addairlinejson(Request $request,NormalizerInterface $Normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $airline = new airline();
        $airline->setNomairline($request->get('nomairline'));
        $airline->setPays($request->get('pays'));
        $airline->setStars($request->get('stars'));
        $em->persist($airline);
        $em->flush();
        $jsonContent = $Normalizer->normalize($airline,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/jsonairline", name="jsonairline")
     */
    public function Allairline(NormalizerInterface $normalizer)
    {

        $repository =$this->getDoctrine()->getRepository(Airline::class);
        $airline = $repository->findAll();
        $jsonContent = $normalizer->normalize($airline,'json',['groups'=>'airline']);
        return new Response(json_encode($jsonContent) );
    }


    /**
     * @Route("/Upldateairlinejson/{id}",name="Upldateairlinejson")
     */
    public function Updateairlinejson(Request $request,NormalizerInterface $normalizer,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $airline= $em->getRepository(Airline::class)->find($id);
        $airline->setNomairline($request->get('nomairline'));
        $airline->setPays($request->get('pays'));
        $airline->setStars($request->get('stars'));
        $em->flush();
        $jsonContent = $normalizer->normalize($airline,'json',['groups'=>'post:read']);
        return new Response("Updated".json_encode($jsonContent));
    }

    /**
     * @Route("/deleteairlinejson/{id}",name="deleteairlinejson")
     */
    public function deleteairlinejson(Request $request,NormalizerInterface $normalizer,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $airline = $em->getRepository(Airline::class)->find($id);
        $em->remove($airline);
        $em->flush();
        $jsonContent = $normalizer->normalize($airline,'json',['groups'=>'post:read']);
        return new Response("Deleted !!".json_encode($jsonContent));



    }
























































}
















