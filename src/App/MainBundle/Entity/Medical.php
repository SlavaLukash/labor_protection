<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medical
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Medical
{

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="medical")
	 * @ORM\JoinColumn(name="employee", referencedColumnName="id")
	 */
	protected $employee;

	/**
	 * @ORM\ManyToOne(targetEntity="Medicalkind", inversedBy="medical")
	 * @ORM\JoinColumn(name="medicalkind", referencedColumnName="id")
	 */
	protected $medicalkind;

	/**
	 * @ORM\ManyToOne(targetEntity="Medicaltype", inversedBy="medical")
	 * @ORM\JoinColumn(name="medicaltype", referencedColumnName="id")
	 */
	protected $medicaltype;

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
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="dateplan", type="date")
	 */
	private $dateplan;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="datefact", type="date")
	 */
	private $datefact;



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
     * Set comment
     *
     * @param string $comment
     * @return Medical
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set dateplan
     *
     * @param \DateTime $dateplan
     * @return Medical
     */
    public function setDateplan($dateplan)
    {
        $this->dateplan = $dateplan;
    
        return $this;
    }

    /**
     * Get dateplan
     *
     * @return \DateTime 
     */
    public function getDateplan()
    {
        return $this->dateplan;
    }

    /**
     * Set datefact
     *
     * @param \DateTime $datefact
     * @return Medical
     */
    public function setDatefact($datefact)
    {
        $this->datefact = $datefact;
    
        return $this;
    }

    /**
     * Get datefact
     *
     * @return \DateTime 
     */
    public function getDatefact()
    {
        return $this->datefact;
    }

    /**
     * Set employee
     *
     * @param \App\MainBundle\Entity\Employee $employee
     * @return Medical
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
     * Set medicalkind
     *
     * @param \App\MainBundle\Entity\Medicalkind $medicalkind
     * @return Medical
     */
    public function setMedicalkind(\App\MainBundle\Entity\Medicalkind $medicalkind = null)
    {
        $this->medicalkind = $medicalkind;
    
        return $this;
    }

    /**
     * Get medicalkind
     *
     * @return \App\MainBundle\Entity\Medicalkind
     */
    public function getMedicalkind()
    {
        return $this->medicalkind;
    }

    /**
     * Set medicaltype
     *
     * @param \App\MainBundle\Entity\Medicaltype $medicaltype
     * @return Medical
     */
    public function setMedicaltype(\App\MainBundle\Entity\Medicaltype $medicaltype = null)
    {
        $this->medicaltype = $medicaltype;
    
        return $this;
    }

    /**
     * Get medicaltype
     *
     * @return \App\MainBundle\Entity\Medicaltype
     */
    public function getMedicaltype()
    {
        return $this->medicaltype;
    }
}