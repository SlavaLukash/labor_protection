<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Registrationtype
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Registrationtype
{


	public function __toString()
	{
		return $this->name;
	}
	/**
	 * @ORM\OneToMany(targetEntity="Equipment", mappedBy="registrationtype")
	 */
	protected $equipment;

	public function __construct()
	{
		$this->equipment = new ArrayCollection();
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
     * @return Registrationtype
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
     * Add equipment
     *
     * @param \Sir\OtBundle\Entity\Equipment $equipment
     * @return Registrationtype
     */
    public function addEquipment(\Sir\OtBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;
    
        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \Sir\OtBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\Sir\OtBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
}