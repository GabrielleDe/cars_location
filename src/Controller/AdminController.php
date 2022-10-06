<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Form\MembreType;
use App\Form\CommandeType;
use App\Form\VehiculeType;
use App\Form\CommandeAdminType;
use App\Repository\MembreRepository;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/vehicule/edit/{id}', name:'admin_edit_vehicule')]
    #[Route('/admin/vehicules', name: "admin_vehicules")]
    public function adminVehicule(Request $globals, VehiculeRepository $repo, EntityManagerInterface $manager, Vehicule $vehicule = null)
    {
        $colonnes =$manager->getClassMetadata(Vehicule::class)->getFieldNames();

        // dd($colonnes);
        $vehicules = $repo->findAll();
        

        if($vehicule ==null):
            $vehicule = new Vehicule;
        endif;


        $form= $this->createForm(VehiculeType::class, $vehicule );

        $form->handleRequest($globals);



        //dump($vehicule);

        if($form->isSubmitted() && $form->isValid())
        {
            $vehicule->setDateEnregistrement(new \DateTime);
            $manager->persist($vehicule);
            $manager->flush();
            $this->addFlash('success', "Le véhicule a bien été enregistré !");
            //permet de creer un message qui sera affiché une fois a l'utilisateur
            return $this->redirectToRoute('admin_vehicules');
        }

        return $this->renderForm("admin/admin_vehicules.html.twig", [
            "formVehicule" => $form,
            "editMode" => $vehicule->getId() !== null,
            'vehicules' => $vehicules,
            'colonnes' => $colonnes
        ]);

    }
    #[Route("/admin/vehicule/delete/{id}", name:"admin_delete_vehicule")]

    public function deleteVehicule(Vehicule $vehicule, EntityManagerInterface $manager)
    {
        $manager->remove($vehicule);
        $manager->flush();
        $this->addFlash('success', "Le véhicule a bien été supprimé !");
        return $this->redirectToRoute('admin_vehicules');
    }

    #[Route('/admin/commande/edit/{id}', name:'admin_edit_commande')]
    #[Route('/admin/commandes', name: "admin_commandes")]
    public function adminCommande(Request $globals, CommandeRepository $repo, EntityManagerInterface $manager, Commande $commande = null)
    {
       
        // dd($colonnes);
        $commandes = $repo->findAll();
        if($commande ==null):
            $commande = new Commande;
        endif;
        $form = $this->createForm(CommandeAdminType::class, $commande);
        $form->handleRequest($globals);

        //dump($vehicule);

        if($form->isSubmitted() && $form->isValid())
        {
            $commande->setDateEnregistrement(new \DateTime);
            $manager->persist($commande);
            $manager->flush();
            $this->addFlash('success', "La commande a bien été modifié !");
            //permet de creer un message qui sera affiché une fois a l'utilisateur
            return $this->redirectToRoute('admin_commandes');
        }

        return $this->renderForm("admin/admin_commandes.html.twig", [
            "formCommande" => $form,
            "editMode" => $commande->getId() !== null,
            'commandes' => $commandes,
            
        ]);

    }
    #[Route("/admin/commande/delete/{id}", name:"admin_delete_commande")]

    public function deleteCommande(Commande $commande, EntityManagerInterface $manager)
    {
        $manager->remove($commande);
        $manager->flush();
        $this->addFlash('success', "La commande a bien été supprimé !");
        return $this->redirectToRoute('admin_commandes');
    }

    

    
}