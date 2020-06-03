<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\TableService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Table;
use App\Exception\ValidatorException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TableController extends AbstractFOSRestController
{
    const TABLE_NOT_FOUND = 'Entity not found';
    
    /**
     * retournes toutes les tables
     * 
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Get(path = "/table")
     */
    public function getTables(TableService $tableService) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $tableService->getTables($mariageId);
    }
    
    
    /**
     * Retourne une table
     * 
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Get(path = "/table/{tableId}", name="table_show")
     */
    public function getTable(TableService $tableService, int $tableId) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $tableService->getTable($tableId, $mariageId);
    }
    
    /**
     * Ajoute une table
     * 
     * @View(statusCode=201)
     * @Rest\Post(path = "/table")
     * @ParamConverter("table", converter="fos_rest.request_body")
     */
    public function addTable(TableService $tableService, Table $table) {
        try {
            $mariage = $this->getUser()->getMariage();
            $tableService->addTable($table, $mariage);

            return $this->view($table,
                Response::HTTP_CREATED,
                ['Location' => $this->generateUrl('table_show', ['tableId' => $table->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
        } catch (ValidatorException $errors) {
            return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Ajoute une table
     *
     * @View(statusCode=200)
     * @Rest\Put(path = "/table/{tableId}")
     * @Rest\Patch(path = "/table/{tableId}")
     * @ParamConverter("table", converter="fos_rest.request_body")
     */
    public function updateTable(TableService $tableService, Table $table, int $tableId) {
        if($table->getId() === $tableId) {
            try {
                $mariageId = $this->getUser()->getMariage()->getId();
                return $tableService->updateTable($table, $mariageId);
            } catch (ValidatorException $errors) {
                return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
            }
        }
        throw new BadRequestHttpException();
    }
    
    /**
     * Supprime une table
     *
     * @View(statusCode=200)
     * @Rest\Delete(path = "/table/{tableId}")
     */
    public function deleteTable(TableService $tableService, int $tableId) {
        $mariageId = $this->getUser()->getMariage()->getId();
        return $tableService->deleteTable($tableId, $mariageId);
    }
}
