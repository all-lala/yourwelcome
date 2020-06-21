<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TableRepository::class)
 * @ORM\Table(name="`table`")
 * @ApiResource(
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_USER') and is_granted('VIEW', object)", "security_message"="Sorry, but you are not the Table owner."},
 *         "put"={"security_post_denormalize"="is_granted('ROLE_USER') or is_granted('EDIT', object)", "security_post_denormalize_message"="Sorry, but you are not the actual Table owner."},
 *         "delete"={"security"="is_granted('ROLE_USER') and is_granted('DELETE', object)", "security_message"="Sorry, but you are not the Table owner."}
*      },
 *     normalizationContext={"groups"={"table", "table_read"}},
 *     denormalizationContext={"groups"={"table"}}
 * )
 */
class Table
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"table_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Groups({"table"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"table"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     * @Groups({"table"})
     */
    private $couleur;

    /**
     * @ORM\ManyToOne(targetEntity=Mariage::class, inversedBy="tables")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     * @Groups({"table"})
     */
    private $mariage;

    /**
     * @ORM\OneToMany(targetEntity=Invite::class, mappedBy="tableReserve", orphanRemoval=false)
     * @Groups({"table"})
     */
    private $invites;

    public function __construct()
    {
        $this->invites = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return \App\Entity\Mariage|null
     */
    public function getMariage(): ?Mariage
    {
        return $this->mariage;
    }

    public function setMariage(?Mariage $mariage): self
    {
        $this->mariage = $mariage;

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
            $invite->setTableReserve($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            // set the owning side to null (unless already changed)
            if ($invite->getTableReserve() === $this) {
                $invite->setTableReserve(null);
            }
        }

        return $this;
    }
}
