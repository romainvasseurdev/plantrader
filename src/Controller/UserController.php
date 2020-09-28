<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EchangeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Security;
use App\Entity\Echange;
use App\Form\EchangeType;

class UserController extends AbstractController {

    private $repo;

    public function __construct(EchangeRepository $repo){
        $this->repo = $repo;
    }

    

    /**
     * @Route("/profile/echanges", name="mes_echanges")
     */
    
    public function afficherEchanges(EchangeRepository $repo, Security $security)
    {
        $user = $security->getUser();
        $id = $user->getId();
        $echanges = $repo->findBy(
            ['author' => $id ]
        );
        return $this->render('site/mesEchanges.html.twig', [
            'echanges' => $echanges 
        ]);
    }

    /**
     * @route("/profile/echanges/{id}/edit", name="editer_mon_echange")
     */

    public function editEchange(Echange $echange, Request $request, ObjectManager $manager){
        
        $form = $this->createForm(EchangeType::class, $echange);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($echange);
            $manager->flush();
            $this->addFlash('success', 'La modification a bien été prise en compte :)');
            return $this->redirectToRoute('mes_echanges');
        }
        
        return $this->render('site/admin/editerEchange.html.twig', [
            'echange' => $echange,
            'form' => $form->createView()
        ]);
    }

        /**
     * @route("/profile/echanges/{id}", name="supprimer_mon_echange", methods="DELETE")
     */

    public function delete(Echange $echange, ObjectManager $manager, Request $request){
        
        if($this->isCsrfTokenValid('delete' . $echange->getId(), $request->get('_token'))){
            $manager->remove($echange);
            $manager->flush();
            $this->addFlash('success', 'L\'offre a bien été supprimée :)');
        }

        return $this->redirectToRoute('mes_echanges');
    }

}
