<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EchangeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Security;
use App\Entity\Echange;
use App\Form\EchangeType;

class AdminEchangeController extends AbstractController {
    
    private $repo;

    public function __construct(EchangeRepository $repo){
        $this->repo = $repo;
    }
  
    /**
     * @Route("/admin/echanges", name="gerer_echanges")
     */

    public function index(){

        $echanges = $this->repo->findAll();
        return $this->render('site/admin/gererEchanges.html.twig', [
            'echanges' => $echanges
        ]);
    }

    
    /**
     * @route("/echanges/new", name="nouvel_echange")
     */

    public function newEchange(Request $request, ObjectManager $manager, Security $security){
        
        $echange = new Echange();
        $form = $this->createForm(EchangeType::class, $echange);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $echange->setAuthor($user);
            $echange->setCreatedAt(new \DateTime);
            $manager->persist($echange);
            $manager->flush();
            $this->addFlash('success', 'L\'offre a bien été créée :)');
            return $this->redirectToRoute('echanges');
        }

        return $this->render('site/admin/nouvelEchange.html.twig', [
            'echange' => $echange,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/admin/echanges/{id}/edit", name="editer_echange")
     */

    public function editEchange(Echange $echange, Request $request, ObjectManager $manager){
        
        $form = $this->createForm(EchangeType::class, $echange);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($echange);
            $manager->flush();
            $this->addFlash('success', 'La modification a bien été prise en compte :)');
            return $this->redirectToRoute('echanges');
        }
        
        return $this->render('site/admin/editerEchange.html.twig', [
            'echange' => $echange,
            'form' => $form->createView()
        ]);
    }

        /**
     * @route("/admin/echanges/{id}", name="supprimer_echange", methods="DELETE")
     */

    public function delete(Echange $echange, ObjectManager $manager, Request $request){
        
        if($this->isCsrfTokenValid('delete' . $echange->getId(), $request->get('_token'))){
            $manager->remove($echange);
            $manager->flush();
            $this->addFlash('success', 'L\'offre a bien été supprimée :)');
        }

        return $this->redirectToRoute('gerer_echanges');
    }
}