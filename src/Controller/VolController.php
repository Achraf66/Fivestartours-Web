<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Form\VolType;
use App\Repository\AirlineRepository;
use App\Repository\VolRepository;
use http\Env\Url;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;




class VolController extends AbstractController
{


    /**
     * @Route("/", name="main")
     */
    public function index1()
    {
        return $this->render('PagePrincipal/Main.html.twig');
    }


    /**
     * @Route("/vol", name="app_vol")
     */
    public function index(): Response
    {
        $vols = $this->getDoctrine()->getManager()->getRepository(Vol::class)->findALL();
        return $this->render('vol/index.html.twig',
            ['vols' => $vols]);
    }

    /**
     * @Route("/addvol", name="addvol")
     */

    public function addVol(Request $request,FlashyNotifier $flashy):Response
    {
        $vol = new Vol();

        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vol);//Add
            $em->flush();
            $flashy->success("Vol Ajouter avec Succés",'vol');
            return $this->redirectToRoute('app_vol');

        }

        return $this->render('vol/Createvol.html.twig', ['f' => $form->createView()]);

    }

    /**
     * @Route("/removevol/{id}",name="supp_vol")
     */
    public function suppressionVol(Vol $vol,FlashyNotifier $flashy): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($vol);
        $em->flush();
        $flashy->success("Vol Supprimer avec Succés",'vol');
        return $this->redirectToRoute('app_vol');

    }

    /**
     * @Route("/editvol/{id}", name="editvol")
     */

    public function editvol(Request $request,$id,FlashyNotifier $flashy): Response
    {
        $vol = $this->getDoctrine()->getManager()->getRepository(Vol::class)->find($id);

        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info("Vol modifié",'vol');
            return $this->redirectToRoute('app_vol');
        }
        return $this->render('vol/updatevol.html.twig', ['f' => $form->createView()]);

    }


    /**
     * @param VolRepository $repository
     * @Route("/volliste",name="volliste")
     */

    public function Affichagelistedesvolsdispo(VolRepository $repository)
    {


        $em = $this->getDoctrine()->getManager();

        //$re=$em->CreateQuery('SELECT v FROM App\Entity\Vol v')->getResult();

        /*$re = $em->CreateQuery('SELECT count(v) FROM App\Entity\Vol v ')->getResult();

        dump($re[0][1]);
        die;*/
        /*   $re = $em->CreateQuery('SELECT count(v) FROM App\Entity\Vol v ')->getSingleScalarResult(); //retourne une seul valeur et pas un array
        dump($re);
        die;
        */

        $best = $em->CreateQuery
        (

            "  
            
    SELECT v.nom,v.Datedepart,v.Datearrive,v.heuredepart,v.heurearrive,v.destination,a.nomairline,v.nbrplace
    FROM App\Entity\Vol v INNER JOIN App\Entity\Airline a
    where a.id = v.airline
    
            "
        )
            ->getResult();

        return $this->render('vol/listevoluser.html.twig',
            ['best' => $best]);

        /*dump($best);
        die;*/


    }



     /**
     * @param VolRepository $repository
     * @Route("/vol", name="app_vol")
     */

    public function rechercheByNomAction(Request $request,FlashyNotifier $flashy,FlashyNotifier $flashy1)
    {
        $em = $this->getDoctrine()->getManager();
        $vols = $em->getRepository(Vol::class)->findAll();


        if ($request->isMethod("POST"))
        {

            $nom = $request->get('nom');
            $vols = $em->getRepository(Vol::class)->findBy(array('nom' => $nom));
            $flashy->success("Liste des vols avec le nom :".$nom, 'vol');

        }


        return $this->render('vol/index.html.twig', array('vols' => $vols));
    }











    /**
     * @Route("/imprimer", name="imprimer")
     */

    public function imprimer()
    {


        $vols = $this->getDoctrine()->getManager()->getRepository(Vol::class)->findALL();


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('vol/index.html.twig',
            ['vols' => $vols]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }


    /**
     * @Route("/addVolJson/new",name="addVolJson")
     */

public function addVoljson(Request $request,NormalizerInterface $Normalizer)
{
    $em=$this->getDoctrine()->getManager();
    $Vol = new Vol();
    /*\DateTime::createFromFormat('Y-m-d');*/


    $Vol->setNom($request->get('Nom'));
  /*  $Vol->setDatearrive($request->get('Datearrive'));*/

    $Vol->setDatearrive(\DateTime::createFromFormat('Y-m-d',$request->get('Datearrive')));

    $Vol->setDatedepart(\DateTime::createFromFormat('Y-m-d',$request->get('Datedepart')));


  /* $Vol->setDatedepart($request->get('Datedepart'));*/
    $Vol->setDestination($request->get('destination'));
 /*  $Vol->setHeurearrive($request->get('Heurearrive'));
    $Vol->setHeuredepart($request->get('Heuredepart'));*/


    $Vol->setHeurearrive(\DateTime::createFromFormat('H:i:s',$request->get('Heurearrive')));

    $Vol->setHeuredepart(\DateTime::createFromFormat('H:i:s',$request->get('Heuredepart')));

    $Vol->setNbrplace($request->get('nbrplace'));

    $Vol->setAirline($request->get('Airline'));
    $em->persist($Vol);
    $em->flush();
    $jsonContent = $Normalizer->normalize($Vol,'json',['groups'=>'post:read']);
return new Response(json_encode($jsonContent));
}


    /**
     * @Route("/jsonvos", name="jsonvls")
     */
    public function getvols(VolRepository $repo,SerializerInterface $serializerinterface)
    {

        $vols = $repo->findAll();
        $json=$serializerinterface->serialize($vols,'json',['groups'=>'vols']);
        dump($json);
        die;


    }

    /**
     * @Route("/Updatevoljson/{id}",name="Updatevoljson")
     */

    public function updatevolJson(Request $request,NormalizerInterface $normalizer,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $Vol= $em->getRepository(Vol::class)->find($id);

        $Vol->setNom($request->get('Nom'));
        $Vol->setDatearrive(\DateTime::createFromFormat('Y-m-d',$request->get('Datearrive')));
        $Vol->setDatedepart(\DateTime::createFromFormat('Y-m-d',$request->get('Datedepart')));
        $Vol->setDestination($request->get('destination'));
        $Vol->setHeurearrive(\DateTime::createFromFormat('H:i:s',$request->get('Heurearrive')));
        $Vol->setHeuredepart(\DateTime::createFromFormat('H:i:s',$request->get('Heuredepart')));
        $Vol->setNbrplace($request->get('nbrplace'));
        $Vol->setAirline($request->get('Airline'));
        $em->flush();
        $jsonContent = $normalizer->normalize($Vol,'json',['groups'=>'post:read']);

        return new Response("Updated".json_encode($jsonContent));



    }

    /**
     * @Route("/jsonvols", name="jsonvols")
     */
public function Allvols(NormalizerInterface $normalizer)
{

    $repository = $this->getDoctrine()->getRepository(Vol::class);
    $vols = $repository->findAll();

    $jsonContent = $normalizer->normalize($vols,'json',['groups'=>'vols']);




    return new Response(json_encode($jsonContent) );
}


    /**
     * @Route("/deletevolJson/{id}", name="deletevolJson")
     */
    public function deletevolJson(Request $request,NormalizerInterface $Normalizer,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $vols = $em->getRepository(Vol::class)->find($id);
        $em->remove($vols);
        $em->flush();
        $jsonContent = $Normalizer->normalize($vols,'json',['groups'=>'post:read']);
        return new Response("Deleted !!".json_encode($jsonContent));
    }






}
