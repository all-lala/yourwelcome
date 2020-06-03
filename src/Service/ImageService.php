<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Hoa\File\Directory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\DBAL\Exception\InvalidArgumentException;

class ImageService
{
    const IMAGE_TYPE_TABLE = 'table';
    
    const IMAGE_TYPE_THEME = 'theme';
    
    const IMAGE_TYPE_VICTOIRE = 'victoire';
    
    private $params;
        
    public function __construct(ParameterBagInterface $params) {
        $this->params = $params;
    }
    
    /**
     * Sauvegarde une image selon son type
     * 
     * @param UploadedFile $image
     * @param string $type
     * @param int $mariageId
     * @throws InvalidArgumentException
     * @return string
     */
    public function saveImage(UploadedFile $image, string $type, int $mariageId) {
        $path = '';
        $originalFilename = $image->getClientOriginalName();
        switch($type) {
            case self::IMAGE_TYPE_TABLE:
                $path = $this->params->get('image_table_directory') . $mariageId . '/';
                break;
            case self::IMAGE_TYPE_THEME:
                $path = $this->params->get('image_theme_directory') . $mariageId . '/';
                break;
            case self::IMAGE_TYPE_VICTOIRE:
                $path = $this->params->get('image_victoire_directory') . $mariageId . '/';
                break;
        }
        if($path) {
            $image->move($path, $originalFilename);
            return $originalFilename;
        } else {
            throw new InvalidArgumentException();
        }
    }
}

