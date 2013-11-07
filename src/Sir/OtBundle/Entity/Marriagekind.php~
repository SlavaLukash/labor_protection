<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Marriagekind
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Marriagekind
{

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="marriagekind")
	 */
	protected $employee;

	public function __construct()
	{
		$this->employee = new ArrayCollection();
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
     * @return Marriagekind
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
     * Add employee
     *
     * @param \Sir\OtBundle\Entity\Employee $employee
     * @return Marriagekind
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
}