<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class FootprintMedia
{
  /**
   * @var int The entity Id
   */
    private $id;

    /**
     * @var string The media name
     */
    protected $name;

    protected $footprint;

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

    public function setFootprint(\App\Entity\Footprint $footprint = null): self
    {
        $this->footprint = $footprint;

        return $this;
    }

    public function getFootprint()
    {
        return $this->footprint;
    }
}
