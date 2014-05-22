<?php

namespace App\MainBundle\Entity;

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
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="usersubdivisions")
	 **/
	private $users;

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="subdivision")
	 */
	protected $employee;

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
     * @param \App\MainBundle\Entity\Enterprise $enterprise
     * @return Subdivision
     */
    public function setEnterprise(\App\MainBundle\Entity\Enterprise $enterprise = null)
    {
        $this->enterprise = $enterprise;
    
        return $this;
    }

    /**
     * Get enterprise
     *
     * @return \App\MainBundle\Entity\Enterprise
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
		$this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employee = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add employee
     *
     * @param \App\MainBundle\Entity\Employee $employee
     * @return Subdivision
     */
    public function addEmployee(\App\MainBundle\Entity\Employee $employee)
    {
        $this->employee[] = $employee;
    
        return $this;
    }

    /**
     * Remove employee
     *
     * @param \App\MainBundle\Entity\Employee $employee
     */
    public function removeEmployee(\App\MainBundle\Entity\Employee $employee)
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
     * @param \App\MainBundle\Entity\Equipment $equipment
     * @return Subdivision
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
     * Add users
     *
     * @param \App\MainBundle\Entity\User $users
     * @return Subdivision
     */
    public function addUser(\App\MainBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \App\MainBundle\Entity\User $users
     */
    public function removeUser(\App\MainBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}