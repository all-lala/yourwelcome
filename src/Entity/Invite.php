<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=InviteRepository::class)
 * @ApiResource(
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_USER') and is_granted('VIEW', object)", "security_message"="Sorry, but you are not the guest owner."},
 *         "put"={"security_post_denormalize"="is_granted('ROLE_USER') or is_granted('EDIT', object)", "security_post_denormalize_message"="Sorry, but you are not the actual guest owner."},
 *         "delete"={"security"="is_granted('ROLE_USER') and is_granted('DELETE', object)", "security_message"="Sorry, but you are not the guest owner."}
*      },
 *     normalizationContext={"groups"={"invite", "invite_read"}},
 *     denormalizationContext={"groups"={"invite"}}
 * )
 */
class Invite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"invite_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Groups({"invite"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Groups({"invite"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"invite"})
     */
    private $badge;

    /**
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="invites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invite"})
     * @Assert\NotNull()
     */
    private $mariage;

    /**
     * @ORM\ManyToOne(targetEntity=Table::class, inversedBy="invites", cascade={"persist"} )
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL")
     * @SerializedName("table")
     * @Groups({"invite"})
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
