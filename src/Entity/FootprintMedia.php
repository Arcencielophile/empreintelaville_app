<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class FootprintMedia
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The media name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Footprint", inversedBy="media")
     */
    protected $footprint;

    /**
     * To string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FootprintMedia
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set footprint.
     *
     * @param \App\Entity\Footprint|null $footprint
     *
     * @return FootprintMedia
     */
    public function setFootprint(\App\Entity\Footprint $footprint = null)
    {
        $this->footprint = $footprint;

        return $this;
    }

    /**
     * Get footprint.
     *
     * @return \App\Entity\Footprint|null
     */
    public function getFootprint()
    {
        return $this->footprint;
    }
}
