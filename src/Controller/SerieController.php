<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
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

 /**
     * @Route("/series/demo", name="serie_em-demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //créé une instance de mon entitée
        $serie = new Serie();

        //hydrate toutes les propriétés
        $serie->setName('pif paf pouf');
        $serie->setBackdrop('ersdfsd');
        $serie->setPoster('dsfsdf');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("- 1 year"));
        $serie->setLastAirDate(new \DateTime("- 6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('bla bla bla');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('Canceled');
        $serie->setTmdbId(321568);

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        //$entityManager->remove($serie);

        $serie->setGenres('comedy');

        $entityManager->flush();


        return $this->render('serie/create.html.twig');

}
}