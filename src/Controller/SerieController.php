<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// possibilité de mettre une racine commune à tout les chemins de ROUTE
// /**
//   * @Route("/series", name="serie_")
//   */


class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(): Response
    {

        //todo : aller chercher les séries en BDD

        return $this->render('serie/list.html.twig', [
            
        ]);
    }


     /**
     * @Route("/series/details/{id}", name="serie_details")
     */
    public function details(int $id): Response
    {

        //todo aller chercher la série dans la BDD

        return $this->render('serie/details.html.twig');

    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(): Response
    {

        return $this->render('serie/create.html.twig');

}
}