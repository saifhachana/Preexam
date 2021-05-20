<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FournisseurRepository;
use App\Entity\Commande ;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeController extends AbstractController
{
    /**
     * @Route("/smart_play/list_commande", name="listcommande")
     */

    public function Jouet(){
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $coms = $repo->findAll();
        return $this->render('commande/Commandes.html.twig', [
            'controller_name' => 'CommandeController',
            'coms' =>$coms]);
    }

    /**
     * @Route("/smart_play/list_commande/new", name = "Com-add") 
     * @Route("/smart_play/list_commande/edit/{id}", name = "Com-edit")
     */

    public function form(Commande $Com=null,Request $requet){
        $manager = $this->getDoctrine()->getManager();
        if(!$Com){
            $Com = new Commande();
        }
      $form = $this->createFormBuilder($Com)
                   ->add('num_cde')
                   ->add('remise_cde')
                   ->add('mnt_cde')
                   ->add('code_clt_cde')
                   ->getForm();
                   $form->handleRequest($requet);
                   if($form->isSubmitted() && $form->isValid()){
                       if(!$Com->getId()){
                           $Com->setDateCde(new \DateTime());
                       }
                       $manager->persist($Com);
                       $manager->flush();
                       return $this->redirectToRoute('UnCom',['id'=>$Com->getId()]);

                   }
        return $this->render('commande/create.html.twig', [
            'formCom'=>$form->createView(),
            'editMode'=>$Com->getId()!==null
        ]);

    }
     /**
     * @Route("/smart_play/list_commande/{id}", name = "UnCom")
     */
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $Com=$repo->find($id);
        return $this->render('commande/Commande.html.twig',[
           'com'=>$Com
        ]);
    }
    /**
     * @Route("/smart_play/list_commande/Supprimer/{id}", name = "Com-supp")
     * @param Commande $Com
     * @return Response
     */
    public function suppr(Commande $Com, Request $request){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($Com);
        $manager->flush();
    
        return $this->redirectToRoute("listcommande");
    }


   
    }

