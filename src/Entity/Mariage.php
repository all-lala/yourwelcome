<?php

namespace App\Entity;

use App\Repository\MariageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MariageRepository::class)
 * @ApiResource(
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_USER') and is_granted('VIEW', object)", "security_message"="Sorry, but you are not the wedding owner."},
 *         "put"={"security_post_denormalize"="is_granted('ROLE_USER') or is_granted('EDIT', object)", "security_post_denormalize_message"="Sorry, but you are not the actual wedding owner."}
*      },
 *     normalizationContext={"groups"={"mariage", "mariage_read"}},
 *     denormalizationContext={"groups"={"mariage"}}
 * )
 */
class Mariage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"mariage_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Groups({"mariage", "write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Groups({"mariage", "write"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"mariage"})
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity=Invite::class, mappedBy="mariage", orphanRemoval=true)
     */
    private $invites;

    /**
     * @ORM\OneToMany(targetEntity=Table::class, mappedBy="mariage", orphanRemoval=true)
     */
    private $tables;

    /**
     * @ORM\OneToMany(targetEntity=Configuration::class, mappedBy="mariage", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"mariage"})
     */
    private $configurations;

    /**
     * @ORM\OneToMany(targetEntity=ConfigurationTheme::class, mappedBy="mariage", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"mariage"})
     */
    private $configurationsTheme;
    
    /**
     * @ORM\OneToMany(targetEntity=ConfigurationVictoire::class, mappedBy="mariage", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"mariage"})
     */
    private $configurationsVictoire;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="mariage")
     */
    private $users;

    public function __construct()
    {
        $this->invites = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->configurations = new ArrayCollection();
        $this->configurationsTheme = new ArrayCollection();
        $this->configurationsVictoire = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection|Invite[]
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Invite $invite): self
    {
        if (!$this->invites->contains($invite)) {
            $this->invites[] = $invite;
            $invite->setMariage($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            // set the owning side to null (unless already changed)
            if ($invite->getMariage() === $this) {
                $invite->setMariage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Table[]
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables[] = $table;
            $table->setMariage($this);
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        if ($this->tables->contains($table)) {
            $this->tables->removeElement($table);
            // set the owning side to null (unless already changed)
            if ($table->getMariage() === $this) {
                $table->setMariage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Configuration[]
     */
    public function getConfigurations(): Collection
    {
        return $this->configurations;
    }

    public function addConfiguration(Configuration $configuration): self
    {
        if (!$this->configurations->contains($configuration)) {
            $this->configurations[] = $configuration;
            $configuration->setMariage($this);
        }

        return $this;
    }

    public function removeConfiguration(Configuration $configuration): self
    {
        if ($this->configurations->contains($configuration)) {
            $this->configurations->removeElement($configuration);
            // set the owning side to null (unless already changed)
            if ($configuration->getMariage() === $this) {
                $configuration->setMariage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConfigurationTheme[]
     */
    public function getConfigurationsTheme(): Collection
    {
        return $this->configurationsTheme;
    }

    public function addConfigurationsTheme(ConfigurationTheme $configurationTheme): self
    {
        if (!$this->configurationsTheme->contains($configurationTheme)) {
            $this->configurationsTheme[] = $configurationTheme;
            $configurationTheme->setMariage($this);
        }

        return $this;
    }

    public function removeConfigurationsTheme(ConfigurationTheme $configurationTheme): self
    {
        if ($this->configurationsTheme->contains($configurationTheme)) {
            $this->configurationsTheme->removeElement($configurationTheme);
            // set the owning side to null (unless already changed)
            if ($configurationTheme->getMariage() === $this) {
                $configurationTheme->setMariage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConfigurationVictoire[]
     */
    public function getConfigurationsVictoire(): Collection
    {
        return $this->configurationsVictoire;
    }

    public function addConfigurationsVictoire(ConfigurationVictoire $configurationVictoire): self
    {
        if (!$this->configurationsVictoire->contains($configurationVictoire)) {
            $this->configurationsVictoire[] = $configurationVictoire;
            $configurationVictoire->setMariage($this);
        }

        return $this;
    }

    public function removeConfigurationsVictoire(ConfigurationVictoire $configurationVictoire): self
    {
        if ($this->configurationsVictoire->contains($configurationVictoire)) {
            $this->configurationsVictoire->removeElement($configurationVictoire);
            // set the owning side to null (unless already changed)
            if ($configurationVictoire->getMariage() === $this) {
                $configurationVictoire->setMariage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setMariage($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getMariage() === $this) {
                $user->setMariage(null);
            }
        }

        return $this;
    }
}
