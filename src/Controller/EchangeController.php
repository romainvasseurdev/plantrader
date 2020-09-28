<?php

namespace App\Controller;

use App\Entity\Echange;
use App\Entity\EchangeSearch;
use App\Form\EchangeSearchType;
use App\Repository\EchangeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EchangeController extends AbstractController
{
    /**
     * @Route("/echanges", name="echanges")
     */
    
    public function afficherEchanges(EchangeRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $search = new EchangeSearch();
        $form = $this->createForm(EchangeSearchType::class, $search);
        $form->handleRequest($request);
        $echanges = $paginator->paginate(
            $repo->findAllPage($search),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('site/echanges.html.twig', [
            'echanges' => $echanges,
            'form' => $form->createView()
        ]);
    }

    /**
     *@route("/echanges/{id}", name="afficher_echange") 
     */

    public function afficherEchange(Echange $echange)
    {
        return $this->render('site/echange.html.twig', [
            'echange' => $echange
        ]);
    }
}