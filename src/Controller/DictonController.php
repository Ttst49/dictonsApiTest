<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Dicton;
use App\Repository\AuthorRepository;
use App\Repository\DictonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api")]
class DictonController extends AbstractController
{
    #[Route('/dicton/index', name: 'app_dicton_index')]
    public function index(DictonRepository $repository): Response
    {
        return $this->json($repository->findAll(),200,[],["groups"=>"dicton"]);
    }

    #[Route("dicton/show/{id}",name: "app_dicton_show")]
    public function show(Dicton $dicton):Response{
        return $this->json($dicton,200);
    }


    #[Route("dicton/create",name: "app_dicton_create")]
    public function createDicton( Request $request, SerializerInterface $serializer, AuthorRepository $repository, EntityManagerInterface $manager):Response{

        $dicton = $serializer->deserialize($request->getContent(), Dicton::class, "json");

        $supposedAuthor = $repository->findOneBy(["name"=>$dicton->getAuthor()->getName()]);
        if ( $supposedAuthor){
            $dicton->setAuthor($supposedAuthor);
        }else{
            $supposedAuthor = new Author();
            $dicton->setAuthor($supposedAuthor);
        }


        $manager->persist($dicton);
        $manager->flush();

        return $this->json($dicton,200);
        //return $this->json("un nouveau dicton a été crée avec succès",200);
    }
}
