<?php

namespace App\Entity;

use App\Repository\ConfigurationVictoireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigurationVictoireRepository::class)
 */
class ConfigurationVictoire
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=50)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Victoire::class)
     * @ORM\JoinColumn(name="victoire", referencedColumnName="name", nullable=false)
     */
    private $victoire;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="configurationsVictoire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mariage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getVictoire(): ?Victoire
    {
        return $this->victoire;
    }

    public function setVictoire(?Victoire $victoire): self
    {
        $this->victoire = $victoire;

        return $this;
    }

    public function getMariage(): ?Mariage
    {
        return $this->mariage;
    }

    public function setMariage(?Mariage $mariage): self
    {
        $this->mariage = $mariage;

        return $this;
    }
}
