<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(SerieRepository $serieRepository): Response
    {

        //$series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);
        //méthode basique pour faire une filtre avec le findBy

        $series =$serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig', [
            'series' => $series
            
        ]);
    }

     /**
     * @Route("/series/details/{id}", name="serie_details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if(!$serie){
            throw $this->createNotFoundException('oh no!!!');
        }

        return $this->render('serie/details.html.twig', [
        "serie" => $serie
        ]);
    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(
            Request $request,
            EntityManagerInterface $entityManager
            ): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());

        $serieForm = $this->createForm(SerieType::class, $serie);

        //injection des données du formulaire dans le $serie
        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()){
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Serie added! Good Job!');
            return $this->redirectToRoute('serie_details', ['id' => $serie->getId()]);
        }



        return $this->render('serie/create.html.twig',[
            'serieForm' => $serieForm->createView()
        ]);

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



 /**
     * @Route("/series/delete/{id}", name="serie_delete", requirements={"id"="\d+"})
     */
     public function delete(Serie $serie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');
    }

   
}