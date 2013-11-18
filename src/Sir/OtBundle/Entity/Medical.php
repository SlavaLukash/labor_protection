<?php

namespace Sir\OtBundle\Entity;

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
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="medical")
	 */
	protected $employee;

	/**
	 * @ORM\OneToMany(targetEntity="Medicalkind", mappedBy="medical")
	 */
	protected $medicalkind;

	/**
	 * @ORM\OneToMany(targetEntity="Medicaltype", mappedBy="medical")
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
     * @ORM\Column(name="comment", type="string", length=255)
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
     * Constructor
     */
    public function __construct()
    {
        $this->employee = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medicalkind = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medicaltype = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add employee
     *
     * @param \Sir\OtBundle\Entity\Employee $employee
     * @return Medical
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
     * Add medicalkind
     *
     * @param \Sir\OtBundle\Entity\Medicalkind $medicalkind
     * @return Medical
     */
    public function addMedicalkind(\Sir\OtBundle\Entity\Medicalkind $medicalkind)
    {
        $this->medicalkind[] = $medicalkind;
    
        return $this;
    }

    /**
     * Remove medicalkind
     *
     * @param \Sir\OtBundle\Entity\Medicalkind $medicalkind
     */
    public function removeMedicalkind(\Sir\OtBundle\Entity\Medicalkind $medicalkind)
    {
        $this->medicalkind->removeElement($medicalkind);
    }

    /**
     * Get medicalkind
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicalkind()
    {
        return $this->medicalkind;
    }

    /**
     * Add medicaltype
     *
     * @param \Sir\OtBundle\Entity\Medicaltype $medicaltype
     * @return Medical
     */
    public function addMedicaltype(\Sir\OtBundle\Entity\Medicaltype $medicaltype)
    {
        $this->medicaltype[] = $medicaltype;
    
        return $this;
    }

    /**
     * Remove medicaltype
     *
     * @param \Sir\OtBundle\Entity\Medicaltype $medicaltype
     */
    public function removeMedicaltype(\Sir\OtBundle\Entity\Medicaltype $medicaltype)
    {
        $this->medicaltype->removeElement($medicaltype);
    }

    /**
     * Get medicaltype
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicaltype()
    {
        return $this->medicaltype;
    }
}