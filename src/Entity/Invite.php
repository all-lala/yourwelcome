<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InviteRepository::class)
 */
class Invite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $badge;

    /**
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="invites")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Exclude()
     * @Assert\NotNull()
     */
    private $mariage;

    /**
     * @ORM\ManyToOne(targetEntity=Table::class, inversedBy="invites")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL")
     * @JMS\SerializedName("table")
     */
    private $tableReserve;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function setBadge(?string $badge): self
    {
        $this->badge = $badge;

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

    public function getTableReserve(): ?Table
    {
        return $this->tableReserve;
    }

    public function setTableReserve(?Table $tableReserve): self
    {
        $this->tableReserve = $tableReserve;

        return $this;
    }
}
