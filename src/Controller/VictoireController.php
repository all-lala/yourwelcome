<?php
namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use App\Service\VictoireService;

class VictoireController
{
    /**
     * Retourne la liste des victoires
     *
     * @View(statusCode=200)
     * @Get(path="/victoire")
     */
    public function getVictoires(VictoireService $victoireService) {
        return $victoireService->getVictoires();
    }
}
