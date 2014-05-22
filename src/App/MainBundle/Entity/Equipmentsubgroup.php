<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Equipmentsubgroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Equipmentsubgroup
{

	/**
	 * @ORM\OneToMany(targetEntity="Equipment", mappedBy="equipmentsubgroup")
	 */
	protected $equipment;

	public function __construct()
	{
		$this->equipment = new ArrayCollection();
	}

	/**
	 * @ORM\ManyToOne(targetEntity="Equipmentgroup", inversedBy="equipmentsubgroup")
	 * @ORM\JoinColumn(name="equipmentgroup", referencedColumnName="id")
	 */
	protected $equipmentgroup;
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
     * @return Equipmentsubgroup
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

	public function __toString()
	{
		return $this->name;
	}

    /**
     * Add equipment
     *
     * @param \App\MainBundle\Entity\Equipment $equipment
     * @return Equipmentsubgroup
     */
    public function addEquipment(\App\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;
    
        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \App\MainBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\App\MainBundle\Entity\Equipment $equipment)
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

    /**
     * Set equipmentgroup
     *
     * @param \App\MainBundle\Entity\Equipmentgroup $equipmentgroup
     * @return Equipmentsubgroup
     */
    public function setEquipmentgroup(\App\MainBundle\Entity\Equipmentgroup $equipmentgroup = null)
    {
        $this->equipmentgroup = $equipmentgroup;
    
        return $this;
    }

    /**
     * Get equipmentgroup
     *
     * @return \App\MainBundle\Entity\Equipmentgroup
     */
    public function getEquipmentgroup()
    {
        return $this->equipmentgroup;
    }
}