<?php
namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends AbstractController
{
    
    /**
     * Route d'ajout d'image
     * 
     * @View(statusCode=200)
     * @Post(path="/image/{type}")
     */
    public function saveImage(ImageService $imageService, Request $request, string $type) {
        $mariageId = $this->getUser()->getMariage()->getId();
        $image = $request->files->get('image');
        return $this->json($imageService->saveImage($image, $type, $mariageId));
    }
}

