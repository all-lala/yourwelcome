<?php
namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use App\Service\ThemeService;

class ThemeController
{
    /**
     * Retourne la liste des themes
     * 
     * @View(statusCode=200)
     * @Get(path="/theme")
     */
    public function getThemes(ThemeService $themeService) {
        return $themeService->getThemes();
    }
}

