<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\MariageService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Mariage;
use App\Exception\ValidatorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MariageController extends AbstractFOSRestController
{
    const TABLE_NOT_FOUND = 'Entity not found';
    
    /**
     * Retourne le mariage de l'utilisateur en cours
     *
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true, )
     * @Rest\Get(path = "/mariage", name="mariage_show")
     */
    public function getMariage(MariageService $mariageService) {
        return $mariageService->getMariage($this->getUser()->getMariage()->getId());
    }
    
    /**
     * Modifie un mariage
     *
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Put(path = "/mariage/{mariageId}")
     * @Rest\Patch(path = "/mariage/{mariageId}")
     * @ParamConverter("mariage", converter="fos_rest.request_body")
     */
    public function updateMariage(MariageService $mariageService, Mariage $mariage, int $mariageId) {
        if($mariage->getId() === $mariageId) {
            try {
                return $mariageService->updateMariage($mariage);
            } catch (ValidatorException $errors) {
                return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
            }
        }
        throw new BadRequestHttpException();
    }
}
