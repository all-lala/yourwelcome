<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 * @ApiResource
 */
class Theme
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=50)
     * @Groups({"mariage"})
     * @ApiProperty(identifier=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $orientation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $configuration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity=ConfigurationTheme::class, mappedBy="theme", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $configurationsTheme;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getConfiguration(): ?bool
    {
        return $this->configuration;
    }

    public function setConfiguration(bool $configuration): self
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
    /**
     * @return Collection|ConfigurationTheme[]
     */
    public function getConfigurationsTheme(): Collection
    {
        return $this->configurationsTheme;
    }
    
    public function addConfigurationTheme(ConfigurationTheme $configurationTheme): self
    {
        if (!$this->configurationsTheme->contains($configurationTheme)) {
            $this->configurationsTheme[] = $configurationTheme;
            $configurationTheme->setTheme($this);
        }
        
        return $this;
    }
    
    public function removeConfigurationTheme(ConfigurationTheme $configurationTheme): self
    {
        if ($this->configurationsTheme->contains($configurationTheme)) {
            $this->configurationsTheme->removeElement($configurationTheme);
            // set the owning side to null (unless already changed)
            if ($configurationTheme->getMariage() === $this) {
                $configurationTheme->setTheme(null);
            }
        }
        
        return $this;
    }
}
