<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trauma
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Trauma
{

	/**
	 * @var string
	 *
	 * @ORM\Column(name="datetrauma", type="date")
	 */
	private $datetrauma;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="trauma")
	 * @ORM\JoinColumn(name="employee", referencedColumnName="id")
	 */
	protected $employee;

    /**
     * @var integer
     *
     * @ORM\Column(name="traumareport", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $traumareport;

    /**
     * @var integer
     *
     * @ORM\Column(name="hoursstart", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $hoursstart;


	/**
	 * @ORM\ManyToOne(targetEntity="Traumacause", inversedBy="trauma")
	 * @ORM\JoinColumn(name="traumacause", referencedColumnName="id")
	 */
	protected $traumacause;

	/**
	 * @ORM\ManyToOne(targetEntity="Traumakind", inversedBy="trauma")
	 * @ORM\JoinColumn(name="traumakind", referencedColumnName="id")
	 */
	protected $traumakind;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Set datetrauma
     *
     * @param \DateTime $datetrauma
     * @return Trauma
     */
    public function setDatetrauma($datetrauma)
    {
        $this->datetrauma = $datetrauma;
    
        return $this;
    }

    /**
     * Get datetrauma
     *
     * @return \DateTime 
     */
    public function getDatetrauma()
    {
        return $this->datetrauma;
    }

    /**
     * Set traumareport
     *
     * @param integer $traumareport
     * @return Trauma
     */
    public function setTraumareport($traumareport)
    {
        $this->traumareport = $traumareport;
    
        return $this;
    }

    /**
     * Get traumareport
     *
     * @return integer 
     */
    public function getTraumareport()
    {
        return $this->traumareport;
    }

    /**
     * Set hoursstart
     *
     * @param integer $hoursstart
     * @return Trauma
     */
    public function setHoursstart($hoursstart)
    {
        $this->hoursstart = $hoursstart;
    
        return $this;
    }

    /**
     * Get hoursstart
     *
     * @return integer 
     */
    public function getHoursstart()
    {
        return $this->hoursstart;
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
     * Set employee
     *
     * @param \App\MainBundle\Entity\Employee $employee
     * @return Trauma
     */
    public function setEmployee(\App\MainBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \App\MainBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set traumacause
     *
     * @param \App\MainBundle\Entity\Traumacause $traumacause
     * @return Trauma
     */
    public function setTraumacause(\App\MainBundle\Entity\Traumacause $traumacause = null)
    {
        $this->traumacause = $traumacause;
    
        return $this;
    }

    /**
     * Get traumacause
     *
     * @return \App\MainBundle\Entity\Traumacause
     */
    public function getTraumacause()
    {
        return $this->traumacause;
    }

    /**
     * Set traumakind
     *
     * @param \App\MainBundle\Entity\Traumakind $traumakind
     * @return Trauma
     */
    public function setTraumakind(\App\MainBundle\Entity\Traumakind $traumakind = null)
    {
        $this->traumakind = $traumakind;
    
        return $this;
    }

    /**
     * Get traumakind
     *
     * @return \App\MainBundle\Entity\Traumakind
     */
    public function getTraumakind()
    {
        return $this->traumakind;
    }

	public function __toString()
	{
		return $this->traumakind;
	}
}