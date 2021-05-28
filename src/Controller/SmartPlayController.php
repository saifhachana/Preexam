<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fournisseur ;
use App\Repository\FournisseurRepository;
use App\Entity\Jouet ;

class SmartPlayController extends AbstractController
{
    private $repfour;
    public function __construct(FournisseurRepository $four)
    {
    $this->repfour=$four;
    }
    /**
     * @Route("/smart_play", name="smart_play")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Jouet::class);
        $games = $repo->findAll();
 
        return $this->render('smart_play/index.html.twig', [
            'controller_name' => 'SmartPlayController',
            'games' =>$games
        ]);
    }
    
    /**
     * @Route("/", name = "home")
     */
    
    public function home(){
        return $this->render('smart_play/home.html.twig');
    }
    /**
     * @Route("/smart_play/upload")
     */
    public function  uploaddata () {
        $entityManager = $this->getDoctrine()->getManager();
        $fourn = new Fournisseur();
        $fourn->setCodeFour("1")
              ->setDesFour("PlayTunisia");
        $entityManager->persist($fourn);
        $fourn = new Fournisseur();
        $fourn->setCodeFour("2")
              ->setDesFour("ImportSmart");
        $entityManager->persist($fourn);
        $fourn = new Fournisseur();
        $fourn->setCodeFour("3")
              ->setDesFour("EduGame");
        $entityManager->persist($fourn);
        $entityManager->flush();
    

        $jouet = new Jouet() ;
        $fourn = $this->repfour->find(2) ;
        $jouet->setCodeJouet("1")
            ->setDesJouet("Camionnette Lego")
            ->setQteStockJouet("130")
            ->setPUJouet("20000")
            ->setCodeFourJouet($fourn) ;
        $entityManager->persist($jouet) ;
        $jouet = new Jouet() ;
        $fourn = $this->repfour->find(2) ;
        $jouet->setCodeJouet("2")
            ->setDesJouet("Voiture télécommandée")
            ->setQteStockJouet("120")
            ->setPUJouet("45.400")
            ->setCodeFourJouet($fourn) ;
            $entityManager->persist($jouet) ;
        $jouet = new Jouet() ;
        $fourn = $this->repfour->find(3) ;
        $jouet->setCodeJouet("3")
            ->setDesJouet("Puzzle La reine des neiges")
            ->setQteStockJouet("300")
            ->setPUJouet("3")
            ->setCodeFourJouet($fourn) ;
            $entityManager->persist($jouet) ;
        $jouet = new Jouet() ;
        $fourn = $this->repfour->find(3) ;
        $jouet->setCodeJouet("4")
            ->setDesJouet("Scrabble")
            ->setQteStockJouet("270")
            ->setPUJouet("32.000")
            ->setCodeFourJouet($fourn) ;
            $entityManager->persist($jouet) ;
        $jouet = new Jouet() ;
        $fourn = $this->repfour->find(3) ;
        $jouet->setCodeJouet("5")
            ->setDesJouet("Monopoly")
            ->setQteStockJouet("300")
            ->setPUJouet("34.600")
            ->setCodeFourJouet($fourn) ;
            $entityManager->persist($jouet) ;
            $entityManager->flush() ;

            return new Response("Uploaded successfully");
    }
    /**
     * @Route("/smart_play/Jouet", name = "Listejouet")
     */
    
    public function Jouet(){
        $repo = $this->getDoctrine()->getRepository(Jouet::class);
        $games = $repo->findAll();
        return $this->render('smart_play/Jouets.html.twig', [
            'controller_name' => 'SmartPlayController',
            'games' =>$games]);
    }
     /**
     * @Route("/smart_play/Jouet/new", name = "jouet-add") 
     * @Route("/smart_play/Jouet/edit/{id}", name = "jouet-edit")
     */

    public function form(Jouet $Jouet=null,Request $requet){
        $manager = $this->getDoctrine()->getManager();
        if(!$Jouet){
            $Jouet = new Jouet();
        }
      $form = $this->createFormBuilder($Jouet)
                   ->add('code_jouet')
                   ->add('des_jouet')
                   ->add('Qte_stock_jouet')
                   ->add('pu_jouet')
                   ->add('code_four_jouet')
                   ->getForm();
                   $form->handleRequest($requet);
                   if($form->isSubmitted() && $form->isValid()){
                       $manager->persist($Jouet);
                       $manager->flush();
                       return $this->redirectToRoute('UnJouet',['id'=>$Jouet->getId()]);

                   }
        return $this->render('smart_play/create.html.twig', [
            'formJouet'=>$form->createView(),
            'editMode'=>$Jouet->getId()!==null
        ]);

    }
    /**
     * @Route("/smart_play/Jouet/{id}", name = "UnJouet")
     */
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(Jouet::class);
        $jouet=$repo->find($id);
        return $this->render('smart_play/Jouet.html.twig',[
           'game'=>$jouet 
        ]);
    }

    /**
     * @Route("/smart_play/Jouet/Supprimer/{id}", name = "jouet-supp")
     * @param Jouet $jouet
     * @return Response
     */
    public function suppr(Jouet $jouet, Request $request){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($jouet);
        $manager->flush();
    
        return $this->redirectToRoute("Listejouet");
    }


    
}
