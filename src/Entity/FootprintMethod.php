<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class FootprintMethod
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
     * @var string The footprint method name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Footprint", mappedBy="method")
     */
    protected $footprints;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->footprints = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return FootprintMethod
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
     * Add footprint.
     *
     * @param \App\Entity\Footprint $footprint
     *
     * @return FootprintMethod
     */
    public function addFootprint(\App\Entity\Footprint $footprint)
    {
        $this->footprints[] = $footprint;

        return $this;
    }

    /**
     * Remove footprint.
     *
     * @param \App\Entity\Footprint $footprint
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFootprint(\App\Entity\Footprint $footprint)
    {
        return $this->footprints->removeElement($footprint);
    }

    /**
     * Get footprints.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFootprints()
    {
        return $this->footprints;
    }
}
