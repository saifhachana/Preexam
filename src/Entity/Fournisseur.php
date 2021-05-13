<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $code_four;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_four;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adr_four;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contact_four;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel_four;

    /**
     * @ORM\OneToMany(targetEntity=Jouet::class, mappedBy="code_four_jouet")
     */
    private $jouets;

    public function __construct()
    {
        $this->jouets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeFour(): ?string
    {
        return $this->code_four;
    }

    public function setCodeFour(string $code_four): self
    {
        $this->code_four = $code_four;

        return $this;
    }

    public function getDesFour(): ?string
    {
        return $this->des_four;
    }

    public function setDesFour(?string $des_four): self
    {
        $this->des_four = $des_four;

        return $this;
    }

    public function getAdrFour(): ?string
    {
        return $this->adr_four;
    }

    public function setAdrFour(string $adr_four): self
    {
        $this->adr_four = $adr_four;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContactFour(): ?string
    {
        return $this->contact_four;
    }

    public function setContactFour(string $contact_four): self
    {
        $this->contact_four = $contact_four;

        return $this;
    }

    public function getTelFour(): ?string
    {
        return $this->tel_four;
    }

    public function setTelFour(string $tel_four): self
    {
        $this->tel_four = $tel_four;

        return $this;
    }

    /**
     * @return Collection|Jouet[]
     */
    public function getJouets(): Collection
    {
        return $this->jouets;
    }

    public function addJouet(Jouet $jouet): self
    {
        if (!$this->jouets->contains($jouet)) {
            $this->jouets[] = $jouet;
            $jouet->setCodeFourJouet($this);
        }

        return $this;
    }

    public function removeJouet(Jouet $jouet): self
    {
        if ($this->jouets->removeElement($jouet)) {
            // set the owning side to null (unless already changed)
            if ($jouet->getCodeFourJouet() === $this) {
                $jouet->setCodeFourJouet(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->code_four;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
