<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Enterprise
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Enterprise
{

	/**
	 * @ORM\OneToMany(targetEntity="Subdivision", mappedBy="enterprise")
	 */
	protected $subdivision;

	public function __construct()
	{
		$this->subdivision = new ArrayCollection();
	}

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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="okved", type="string", length=8)
     */
    private $okved;


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
     * @return Enterprise
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
     * Set address
     *
     * @param string $address
     * @return Enterprise
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set okved
     *
     * @param string $okved
     * @return Enterprise
     */
    public function setOkved($okved)
    {
        $this->okved = $okved;
    
        return $this;
    }

    /**
     * Get okved
     *
     * @return string 
     */
    public function getOkved()
    {
        return $this->okved;
    }

    /**
     * Add subdivisions
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivisions
     * @return Enterprise
     */
    public function addSubdivision(\Sir\OtBundle\Entity\Subdivision $subdivision)
    {
        $this->subdivision[] = $subdivision;
    
        return $this;
    }

    /**
     * Remove subdivisions
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivisions
     */
    public function removeSubdivision(\Sir\OtBundle\Entity\Subdivision $subdivisions)
    {
        $this->subdivisions->removeElement($subdivisions);
    }

    /**
     * Get subdivisions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubdivisions()
    {
        return $this->subdivisions;
    }

	public function __toString()
	{
		return $this->name;
	}

    /**
     * Get subdivision
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubdivision()
    {
        return $this->subdivision;
    }
}