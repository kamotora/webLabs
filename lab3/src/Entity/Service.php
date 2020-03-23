<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Autoservice", mappedBy="services")
     */
    private $autoservices;

    public function __construct()
    {
        $this->autoservices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Autoservice[]
     */
    public function getAutoservices(): Collection
    {
        return $this->autoservices;
    }

    public function addAutoservice(Autoservice $autoservice): self
    {
        if (!$this->autoservices->contains($autoservice)) {
            $this->autoservices[] = $autoservice;
            $autoservice->addService($this);
        }

        return $this;
    }

    public function removeAutoservice(Autoservice $autoservice): self
    {
        if ($this->autoservices->contains($autoservice)) {
            $this->autoservices->removeElement($autoservice);
            $autoservice->removeService($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


}
