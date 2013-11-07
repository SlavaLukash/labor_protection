<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Equipmentgroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Equipmentgroup
{


	/**
	 * @ORM\OneToMany(targetEntity="Equipmentsubgroup", mappedBy="equipmentgroup")
	 */
	protected $equipmentsubgroup;

	public function __construct()
	{
		$this->equipmentsubgroup = new ArrayCollection();
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
     * @return Equipmentgroup
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
     * Add equipmentsubgroup
     *
     * @param \Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup
     * @return Equipmentgroup
     */
    public function addEquipmentsubgroup(\Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup)
    {
        $this->equipmentsubgroup[] = $equipmentsubgroup;
    
        return $this;
    }

    /**
     * Remove equipmentsubgroup
     *
     * @param \Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup
     */
    public function removeEquipmentsubgroup(\Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup)
    {
        $this->equipmentsubgroup->removeElement($equipmentsubgroup);
    }

    /**
     * Get equipmentsubgroup
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipmentsubgroup()
    {
        return $this->equipmentsubgroup;
    }
}