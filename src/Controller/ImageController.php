<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


#[Route("/api/image")]
class ImageController extends AbstractController
{
    #[Route('/upload', name: 'upload')]
    public function upload(Request $request, EntityManagerInterface $manager, UploaderHelper $helper): Response
    {

        $image = new Image();
        $file = $request->files->get("monImage");
        $image->setImageFile($file);

        $manager->persist($image);
        $manager->flush();

        $response = [
            "message"=>"bravo pour ton upload",
            "idImage"=>$image->getId(),
            "image"=>"https://localhost:8000".$helper->asset($image)

        ];




        return $this->json($response,200);
    }
}
