<?php

namespace App\Service;

use App\Entity\Table;
use App\Entity\Mariage;
use App\Repository\TableRepository;
use App\Exception\NotNewException;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Description of TableService
 *
 * @author all-lala
 */
class TableService {
   
    private $repository;

    private $validator;
    
    public function __construct(TableRepository $repository, ValidatorRestService $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    /**
     * Retourne la liste des tables pour un mariage
     * 
     * @param int $mariageId
     * @return Table[]
     */
    public function getTables(int $mariageId) : Array {
        return $this->repository->findBy(['mariage' => $mariageId], ['id' => 'ASC']);
    }
    
    /**
     * Retourne une table
     * 
     * @param int $tableId
     * @param int $mariageId
     * @return Table
     */
    public function getTable(int $tableId, int $mariageId) : Table {
        return $this->repository->findOneBy(['id' => $tableId, 'mariage' => $mariageId]);
    }
    
    /**
     * Ajoute une table
     * 
     * @param Table $newTable
     * @param Mariage $mariage
     * @return Table
     */
    public function addTable(Table $newTable,Mariage $mariage) {
        if($newTable->getId()){
            throw new NotNewException();
        }
        $newTable->setMariage($mariage);
        
        $this->validator->valid($newTable);
        
        $this->repository->save($newTable);

        return $newTable;
    }
    
    
    /**
     * Modifie une table
     *
     * @param Table $newTable
     * @param int $mariageId
     * @return Table
     */
    public function updateTable(Table $table, int $mariageId) {
        if ($table->getId() && $table->getMariage()->getId() === $mariageId) {
            $this->validator->valid($table);
            
            $this->repository->save($table);
        } else {
            throw new EntityNotFoundException();
        }
        return $table;
    }
    
    /**
     * Supprime une table
     *
     * @param int $tableId
     * @param int $mariageId
     */
    public function deleteTable(int $tableId, int $mariageId) {
        $table = $this->repository->findOneBy(['id' => $tableId, 'mariage' => $mariageId]);
        if ($table) {
            $this->repository->remove($table);
        } else {
            throw new EntityNotFoundException();
        }
    }
}
