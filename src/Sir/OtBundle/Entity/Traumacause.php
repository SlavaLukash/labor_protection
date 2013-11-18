<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traumacause
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Traumacause
{

	/**
	 * @ORM\OneToMany(targetEntity="Trauma", mappedBy="traumacause")
	 */
	protected $trauma;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trauma = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Traumacause
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add trauma
     *
     * @param \Sir\OtBundle\Entity\Trauma $trauma
     * @return Traumacause
     */
    public function addTrauma(\Sir\OtBundle\Entity\Trauma $trauma)
    {
        $this->trauma[] = $trauma;
    
        return $this;
    }

    /**
     * Remove trauma
     *
     * @param \Sir\OtBundle\Entity\Trauma $trauma
     */
    public function removeTrauma(\Sir\OtBundle\Entity\Trauma $trauma)
    {
        $this->trauma->removeElement($trauma);
    }

    /**
     * Get trauma
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrauma()
    {
        return $this->trauma;
    }
}