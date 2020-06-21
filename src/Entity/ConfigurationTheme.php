<?php

namespace App\Entity;

use App\Repository\ConfigurationThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ConfigurationThemeRepository::class)
 * @ApiResource
 */
class ConfigurationTheme
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=50)
     * @Groups({"mariage"})
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     * @Groups({"mariage"})
     */
    private $value;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="configurationsTheme")
     * @ORM\JoinColumn(name="theme", referencedColumnName="name", nullable=false)
     * @Groups({"mariage"})
     */
    private $theme;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="configurationsTheme")
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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

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
