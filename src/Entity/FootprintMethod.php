<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class FootprintMethod
{
    /**
     * @var int The entity Id
     */
    private $id;

    /**
     * @var string The footprint method name
     */
    protected $name;

    protected $footprints;

    public function __construct()
    {
        $this->footprints = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function addFootprint(\App\Entity\Footprint $footprint)
    {
        $this->footprints[] = $footprint;

        return $this;
    }

    public function removeFootprint(\App\Entity\Footprint $footprint): boolean
    {
        return $this->footprints->removeElement($footprint);
    }

    public function getFootprints()
    {
        return $this->footprints;
    }
}
