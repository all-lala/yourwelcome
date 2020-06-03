<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigurationRepository::class)
 */
class Configuration
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
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="configurations")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
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
