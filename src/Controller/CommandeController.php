<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FournisseurRepository;
use App\Entity\Commande ;
use App\Entity\Fournisseur;
use App\Entity\Jouet;
use App\Entity\LigneCde;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeController extends AbstractController
{
    /**
     * @Route("/smart_play/list_commande", name="listcommande")
     */

    public function ListCommande(){
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
                           $Com->setHeureCde(date("H:i:s", strtotime('+1 hours')));
                       }
                       $manager->persist($Com);
                       $manager->flush();
                       return $this->redirectToRoute('LesLignes',['id'=>$Com->getId()]);

                   }
        return $this->render('commande/create.html.twig', [
            'formCom'=>$form->createView(),
            'editMode'=>$Com->getId()!==null
        ]);

    }
     /**
     * @Route("/smart_play/list_commande/Lignes/new/{id}", name = "Ligne-add") 
     */
    public function Add($id,Request $requet){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $manager = $this->getDoctrine()->getManager();
        $repo1=$this->getDoctrine()->getRepository(LigneCde::class);
        $montf=0;
            $LC = new LigneCde();
        
      $form = $this->createFormBuilder($LC)
                   ->add('code_jouet_ligne')
                   ->add('qte_ligne')
                   ->add('remise_ligne')
                   ->getForm();
                   $form->handleRequest($requet);
                   if($form->isSubmitted() && $form->isValid()){
                    $LC->setNumCdeLigne($repo->find($id));
                    
                       $manager->persist($LC);
                       $manager->flush();

        $jou=$repo1->findBy(['num_cde_ligne'=>$id]);
        foreach ($jou as $value) {
            $montf+=$value->getCodeJouetLigne()->getPUJouet()*$value->getQteLigne();
          }
          $Cmd=$repo->find($id);
          $Cmd->setMntCde($montf);
          $manager->persist($Cmd);
                       $manager->flush();
            
                       return $this->redirectToRoute('LesLignes',['id'=>$id]);
                    }
        return $this->render('commande/createLc.html.twig',[
            'formL'=>$form->createView(),
            'editMode'=>$LC->getId()!==null
        ]);
    }
       /**
     * @Route("/smart_play/list_commande/Lignes/edit/{idc}/{id}", name = "Ligne-edit")
     */
    public function Edit($idc,$id,LigneCde $LC,Request $requet){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $manager = $this->getDoctrine()->getManager();
        $repo1=$this->getDoctrine()->getRepository(LigneCde::class);
        $montf=0;
      $form = $this->createFormBuilder($LC)
                   ->add('code_jouet_ligne')
                   ->add('qte_ligne')
                   ->add('remise_ligne')
                   ->getForm();
                   $form->handleRequest($requet);
                   if($form->isSubmitted() && $form->isValid()){

                       $manager->persist($LC);
                       $manager->flush();
                       $jou=$repo1->findBy(['num_cde_ligne'=>$idc]);
        foreach ($jou as $value) {
            $montf+=$value->getCodeJouetLigne()->getPUJouet()*$value->getQteLigne();
          }
          $Cmd=$repo->find($idc);
          $Cmd->setMntCde($montf);
          $manager->persist($Cmd);
          $manager->flush();
                       return $this->redirectToRoute('LesLignes',['id'=>$idc]);
                    }
        return $this->render('commande/createLc.html.twig',[
            'formL'=>$form->createView(),
            'editMode'=>$LC->getId()!==null
        ]);
    }
    
    /**
     * @Route("/smart_play/list_commande/Supprimer/Lignes/{idc}/{id}", name = "Ligne-supp")
     * @param LigneCde $LC
     * @return Response
     */
    public function supprL(LigneCde $LC,$idc){
        $repo=$this->getDoctrine()->getRepository(Commande::class);
        $manager = $this->getDoctrine()->getManager();
        $repo1=$this->getDoctrine()->getRepository(LigneCde::class);
        $montf=0;
        $manager->remove($LC);
          $manager->flush();
          $jou=$repo1->findBy(['num_cde_ligne'=>$idc]);
        foreach ($jou as $value) {
            $montf+=$value->getCodeJouetLigne()->getPUJouet()*$value->getQteLigne();
          }
          $Cmd=$repo->find($idc);
          $Cmd->setMntCde($montf);
          $manager->persist($Cmd);
                       $manager->flush();
    
        return $this->redirectToRoute('LesLignes',['id'=>$idc]);
    }
      /**
     * @Route("/smart_play/list_commande/Supprimer/{id}", name = "Com-supp")
     * @param Commande $Com
     * @return Response
     */
    public function suppr(Commande $Com){
        $manager=$this->getDoctrine()->getManager();
        $repo1=$this->getDoctrine()->getRepository(LigneCde::class);
        $jou=$repo1->findBy(['num_cde_ligne'=>$Com->getId()]);
        foreach ($jou as $value) {
            $manager->remove($value);
          }

        $manager->remove($Com);
        $manager->flush();
    
        return $this->redirectToRoute("listcommande");
    }

    /**
     * @Route("/smart_play/list_commande/Lignes/{id}", name="LesLignes")
     */
    public function Lignes($id){
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $coms = $repo->find($id);
        $repo = $this->getDoctrine()->getRepository(LigneCde::class);
        $Ligne = $repo->findBy(['num_cde_ligne'=>$id]);
        return $this->render('commande/Commande.html.twig', [
            'controller_name' => 'CommandeController',
            'com' =>$coms,
            'Ligne'=>$Ligne]);
    }






     


   
}


