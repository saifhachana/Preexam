<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $num_cde;

    /**
     * @ORM\Column(type="date")
     */
    private $date_cde;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heure_cde;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remise_cde;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mnt_cde;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     */
    private $code_clt_cde;

    /**
     * @ORM\OneToMany(targetEntity=LigneCde::class, mappedBy="num_cde_ligne")
     */
    private $ligneCdes;

    public function __construct()
    {
        $this->ligneCdes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCde(): ?string
    {
        return $this->num_cde;
    }

    public function setNumCde(string $num_cde): self
    {
        $this->num_cde = $num_cde;

        return $this;
    }

    public function getDateCde(): ?\DateTimeInterface
    {
        return $this->date_cde;
    }

    public function setDateCde(\DateTimeInterface $date_cde): self
    {
        $this->date_cde = $date_cde;

        return $this;
    }

    public function getHeureCde(): ?string
    {
        return $this->heure_cde;
    }

    public function setHeureCde(string $heure_cde): self
    {
        $this->heure_cde = $heure_cde;

        return $this;
    }

    public function getRemiseCde(): ?int
    {
        return $this->remise_cde;
    }

    public function setRemiseCde(?int $remise_cde): self
    {
        $this->remise_cde = $remise_cde;

        return $this;
    }

    public function getMntCde(): ?int
    {
        return $this->mnt_cde;
    }

    public function setMntCde(?int $mnt_cde): self
    {
        $this->mnt_cde = $mnt_cde;

        return $this;
    }

    public function getCodeCltCde(): ?Client
    {
        return $this->code_clt_cde;
    }

    public function setCodeCltCde(?Client $code_clt_cde): self
    {
        $this->code_clt_cde = $code_clt_cde;

        return $this;
    }

    /**
     * @return Collection|LigneCde[]
     */
    public function getLigneCdes(): Collection
    {
        return $this->ligneCdes;
    }

    public function addLigneCde(LigneCde $ligneCde): self
    {
        if (!$this->ligneCdes->contains($ligneCde)) {
            $this->ligneCdes[] = $ligneCde;
            $ligneCde->setNumCdeLigne($this);
        }

        return $this;
    }

    public function removeLigneCde(LigneCde $ligneCde): self
    {
        if ($this->ligneCdes->removeElement($ligneCde)) {
            // set the owning side to null (unless already changed)
            if ($ligneCde->getNumCdeLigne() === $this) {
                $ligneCde->setNumCdeLigne(null);
            }
        }

        return $this;
    }
}
