<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FicheRepository;
use App\Form\FicheType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Fiche;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'title' => "Bienvenue sur Plantrader"
        ]);
    }

    /**
     * @Route("/fiches", name="fiches")
     */
    
    public function afficherFiches(FicheRepository $repo, Security $security)
    {
        $fiches = $repo->findAll();
        $user = $security->getUser();
        $user = $security->getUser();
        if($user == null){
            $role = null;
        }else{
            $role = $user->getRoles();
        }
        return $this->render('site/fiches.html.twig', [
            'fiches' => $fiches,
            'role' => $role
        ]);
    }

    /**
     * @Route("/fiches/new", name="fiche_create")
     * @Route("/fiches/{id}/edit", name="fiche_edit")
     */
    
    public function form(Fiche $fiche = null, Request $request, ObjectManager $manager)
    {   
        if(!$fiche){
        $fiche = new Fiche();
        }
        
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fiche->setCreatedAt(new \DateTime);
            $manager->persist($fiche);
            $manager->flush();
            return $this->redirectToRoute('afficher_fiche', ['id' => $fiche->getId()]);
        }

        return $this->render('site/create.html.twig', [
            'formFiche' => $form->createView()
        ]);
    }

    /**
     *@route("/fiches/{id}", name="afficher_fiche") 
     */

    public function afficherFiche(Fiche $fiche, Security $security)
    {

        $user = $security->getUser();
        if($user == null){
            $role = null;
        }else{
            $role = $user->getRoles();
        }

        return $this->render('site/fiche.html.twig', [
            'fiche' => $fiche,
            'role' => $role
        ]);
    }
}
