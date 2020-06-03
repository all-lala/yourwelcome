<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200529223236 extends AbstractMigration
{
    private $themes = [
            [
                'name' => 'SlotMachine',
                'label' => 'Machine Ã  sous',
                'orientation' => 'h',
                'image' => 'SlotMachine.png',
                'configuration' => 1,
                'visible' => 1
            ]
        ];
    
    private $victoires = [
            [
                'name' => 'ImageFixe',
                'label' => 'Une image',
                'orientation' => 'h',
                'image' => 'ImageFixe.png',
                'configuration' => 1,
                'visible' => 1
            ],
            [
                'name' => 'Aucune',
                'label' => 'Aucune',
                'orientation' => 'h',
                'image' => '',
                'configuration' => 0,
                'visible' => 1
            ],
            [
                'name' => 'Firework',
                'label' => 'Feu d\'artifice',
                'orientation' => 'h',
                'image' => 'Firework.png',
                'configuration' => 1,
                'visible' => 1
            ]
        ];
    public function getDescription() : string
    {
        return 'Données de base pour themes et victoires';
    }

    public function up(Schema $schema) : void
    {
        foreach ($this->themes as $theme){
            $this->addSql('INSERT INTO theme (name, label, orientation, image, configuration, visible) VALUES (:name, :label, :orientation, :image, :configuration, :visible)', $theme);
        }
        
        foreach ($this->victoires as $victoire){
            $this->addSql('INSERT INTO victoire (name, label, orientation, image, configuration, visible) VALUES (:name, :label, :orientation, :image, :configuration, :visible)', $victoire);
        }
    }

    public function down(Schema $schema) : void
    {
        
        foreach ($this->themes as $theme){
            $this->addSql('DELETE FROM theme WHERE name = :name', $theme);
        }
        
        foreach ($this->victoires as $victoire){
            $this->addSql('DELETE FROM victoire WHERE name = :name', $victoire);
        }
    }
}
