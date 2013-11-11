<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subdivision
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subdivision
{

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="subdivision")
	 */
	protected $employee;

	/**
	 * @ORM\OneToMany(targetEntity="Usersubdivision", mappedBy="subdivision")
	 */
	protected $usersubdivision;

	/**
	 * @ORM\OneToMany(targetEntity="Equipment", mappedBy="subdivision")
	 */
	protected $equipment;

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
	 * @ORM\ManyToOne(targetEntity="Enterprise", inversedBy="subdivision")
	 * @ORM\JoinColumn(name="enterprise", referencedColumnName="id")
	 */
	protected $enterprise;


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
     * @return Subdivision
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
     * Set enterprise
     *
     * @param \Sir\OtBundle\Entity\Enterprise $enterprise
     * @return Subdivision
     */
    public function setEnterprise(\Sir\OtBundle\Entity\Enterprise $enterprise = null)
    {
        $this->enterprise = $enterprise;
    
        return $this;
    }

    /**
     * Get enterprise
     *
     * @return \Sir\OtBundle\Entity\Enterprise 
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

	public function __toString()
	{
		return $this->name;
	}

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersubdivision = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employee = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add employee
     *
     * @param \Sir\OtBundle\Entity\Employee $employee
     * @return Subdivision
     */
    public function addEmployee(\Sir\OtBundle\Entity\Employee $employee)
    {
        $this->employee[] = $employee;
    
        return $this;
    }

    /**
     * Remove employee
     *
     * @param \Sir\OtBundle\Entity\Employee $employee
     */
    public function removeEmployee(\Sir\OtBundle\Entity\Employee $employee)
    {
        $this->employee->removeElement($employee);
    }

    /**
     * Get employee
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Add equipment
     *
     * @param \Sir\OtBundle\Entity\Equipment $equipment
     * @return Subdivision
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

    /**
     * Add usersubdivision
     *
     * @param \Sir\OtBundle\Entity\Usersubdivision $usersubdivision
     * @return Subdivision
     */
    public function addUsersubdivision(\Sir\OtBundle\Entity\Usersubdivision $usersubdivision)
    {
        $this->usersubdivision[] = $usersubdivision;
    
        return $this;
    }

    /**
     * Remove usersubdivision
     *
     * @param \Sir\OtBundle\Entity\Usersubdivision $usersubdivision
     */
    public function removeUsersubdivision(\Sir\OtBundle\Entity\Usersubdivision $usersubdivision)
    {
        $this->usersubdivision->removeElement($usersubdivision);
    }

    /**
     * Get usersubdivision
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsersubdivision()
    {
        return $this->usersubdivision;
    }
}