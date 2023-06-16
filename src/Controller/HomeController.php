<?php

namespace App\Controller;

use App\Repository\DictonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    #[Route('{_locale}/home', name: 'app_home')]
    public function index(TranslatorInterface $translator,DictonRepository $repository, PaginatorInterface $paginator, Request $request,$id = 0 ): Response
    {


        $pagination = $paginator->paginate(
            $repository->findBy(array(),array("createdAt"=>"ASC")),
            $request->query->getInt('page', 1),
            30
        );

        return $this->render('home/index.html.twig', [
            "translator"=>$translator,
            'pagination' => $pagination
        ]);
    }
}
