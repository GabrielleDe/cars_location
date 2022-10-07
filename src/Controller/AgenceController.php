<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\MembreRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgenceController extends AbstractController
{
    #[Route('/', name: 'app_agence')]
    public function index(VehiculeRepository $repo): Response
    {
        $vehicule=$repo->findAll();
        return $this->render('agence/index.html.twig', [
            'vehicules' => $vehicule
        ]);
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
        ]);
    }

    #[Route('/agence/show/{id}', name:'agence_show')]
    public function show($id, VehiculeRepository $repo, Request $globals, EntityManagerInterface $manager){
        // $vehicule = $repo->find($id);
        // $commande = new Commande;
        // $form = $this->createForm(CommandeType::class, $commande);
        // $form->handleRequest($globals);
        
        // if($form->isSubmitted() && $form->isValid())
        // {
        //     $commande->setDateEnregistrement(new \DateTime());
        //     $commande->setMembre($this->getUser());
        //     $commande->setVehicules($vehicule);

        //     $table = $globals->request->get("commande");

        //     $tableOrigin = $table["date_heure_depart"]['date'];
        //     $origin = $tableOrigin["year"] . "-" . $tableOrigin["month"] . "-" . $tableOrigin["day"];

        //     $origin = date_create($origin);

        //     $tableTarget = $table["date_heure_fin"]['date'];
        //     $target = $tableTarget["year"] . "-" . $tableTarget["month"] . "-" . $tableTarget["day"];

        //     $target = date_create($target);

        //     $interval = date_diff($origin, $target);
            
        //     // $interval = $interval->format('d');
        //     $interval = ($interval->d) + ($interval->m) *30 + ($interval->y) *364 ;
        //     $prix = $vehicule->getPrixJournalier();
        //     $prix = $prix * $interval;

        //     $commande->setPrixTotal($prix);

            
            
        //     $manager->persist($commande);
        //     $manager->flush();
        //     $this->addFlash('Success', 'La commande a été passé');
        //     return $this->redirectToRoute('app_agence');

        // }

        return $this->renderForm('agence/show.html.twig', [
            // 'vehicule' => $vehicule,
            // 'formCommande' => $form
        ]);
        }

        #[Route('/profil/{id}', name:"app_profil")]
        public function profil(CommandeRepository $repo )
        {
            
            $commande = $repo->findAll();


            return$this->render('agence/profil.html.twig', [
                'commandes'=>$commande
            ]);
        }
        
}
