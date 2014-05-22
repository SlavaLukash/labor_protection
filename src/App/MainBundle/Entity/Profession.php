<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Profession
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Profession
{

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="profession")
	 */
	protected $employee;

	public function __construct()
	{
		$this->employee = new ArrayCollection();
	}

	/**
	 * @ORM\ManyToOne(targetEntity="Professionkind", inversedBy="profession")
	 * @ORM\JoinColumn(name="professionkind", referencedColumnName="id")
	 */
	protected $professionkind;

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
     * @return Profession
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
     * Set professionkind
     *
     * @param \App\MainBundle\Entity\Professionkind $professionkind
     * @return Profession
     */
    public function setProfessionkind(\App\MainBundle\Entity\Professionkind $professionkind = null)
    {
        $this->professionkind = $professionkind;
    
        return $this;
    }

    /**
     * Get professionkind
     *
     * @return \App\MainBundle\Entity\Professionkind
     */
    public function getProfessionkind()
    {
        return $this->professionkind;
    }

	public function __toString()
	{
		return $this->name;
	}

    /**
     * Add employee
     *
     * @param \App\MainBundle\Entity\Employee $employee
     * @return Profession
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
}