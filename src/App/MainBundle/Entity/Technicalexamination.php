<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technicalexamination
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Technicalexamination
{

	/**
	 * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="technicalexamination")
	 * @ORM\JoinColumn(name="equipment", referencedColumnName="id")
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
     * @ORM\Column(name="resulttext", type="string", length=255)
     */
    private $resulttext;

	/**
	 * @ORM\ManyToOne(targetEntity="Technicalexaminationkind", inversedBy="technicalexamination")
	 * @ORM\JoinColumn(name="technicalexaminationkind", referencedColumnName="id")
	 */
	protected $technicalexaminationkind;

	/**
	 * @ORM\ManyToOne(targetEntity="Technicalexaminationcause", inversedBy="technicalexamination")
	 * @ORM\JoinColumn(name="technicalexaminationcause", referencedColumnName="id")
	 */
	protected $technicalexaminationcause;

	/**
	 * @ORM\ManyToOne(targetEntity="Technicalexaminationtype", inversedBy="technicalexamination")
	 * @ORM\JoinColumn(name="technicalexaminationtype", referencedColumnName="id")
	 */
	protected $technicalexaminationtype;

	/**
	 * @var date
	 *
	 * @ORM\Column(name="plandate", type="date")
	 */
	private $plandate;

	/**
	 * @var date
	 *
	 * @ORM\Column(name="factdate", type="date")
	 */
	private $factdate;


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
     * Set resulttext
     *
     * @param string $resulttext
     * @return Technicalexamination
     */
    public function setResulttext($resulttext)
    {
        $this->resulttext = $resulttext;
    
        return $this;
    }

    /**
     * Get resulttext
     *
     * @return string 
     */
    public function getResulttext()
    {
        return $this->resulttext;
    }

    /**
     * Set plandate
     *
     * @param \DateTime $plandate
     * @return Technicalexamination
     */
    public function setPlandate($plandate)
    {
        $this->plandate = $plandate;
    
        return $this;
    }

    /**
     * Get plandate
     *
     * @return \DateTime 
     */
    public function getPlandate()
    {
        return $this->plandate;
    }

    /**
     * Set factdate
     *
     * @param \DateTime $factdate
     * @return Technicalexamination
     */
    public function setFactdate($factdate)
    {
        $this->factdate = $factdate;
    
        return $this;
    }

    /**
     * Get factdate
     *
     * @return \DateTime 
     */
    public function getFactdate()
    {
        return $this->factdate;
    }

    /**
     * Set equipment
     *
     * @param \App\MainBundle\Entity\Equipment $equipment
     * @return Technicalexamination
     */
    public function setEquipment(\App\MainBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;
    
        return $this;
    }

    /**
     * Get equipment
     *
     * @return \App\MainBundle\Entity\Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set technicalexaminationkind
     *
     * @param \App\MainBundle\Entity\Technicalexaminationkind $technicalexaminationkind
     * @return Technicalexamination
     */
    public function setTechnicalexaminationkind(\App\MainBundle\Entity\Technicalexaminationkind $technicalexaminationkind = null)
    {
        $this->technicalexaminationkind = $technicalexaminationkind;
    
        return $this;
    }

    /**
     * Get technicalexaminationkind
     *
     * @return \App\MainBundle\Entity\Technicalexaminationkind
     */
    public function getTechnicalexaminationkind()
    {
        return $this->technicalexaminationkind;
    }

    /**
     * Set technicalexaminationcause
     *
     * @param \App\MainBundle\Entity\Technicalexaminationcause $technicalexaminationcause
     * @return Technicalexamination
     */
    public function setTechnicalexaminationcause(\App\MainBundle\Entity\Technicalexaminationcause $technicalexaminationcause = null)
    {
        $this->technicalexaminationcause = $technicalexaminationcause;
    
        return $this;
    }

    /**
     * Get technicalexaminationcause
     *
     * @return \App\MainBundle\Entity\Technicalexaminationcause
     */
    public function getTechnicalexaminationcause()
    {
        return $this->technicalexaminationcause;
    }

    /**
     * Set technicalexaminationtype
     *
     * @param \App\MainBundle\Entity\Technicalexaminationtype $technicalexaminationtype
     * @return Technicalexamination
     */
    public function setTechnicalexaminationtype(\App\MainBundle\Entity\Technicalexaminationtype $technicalexaminationtype = null)
    {
        $this->technicalexaminationtype = $technicalexaminationtype;
    
        return $this;
    }

    /**
     * Get technicalexaminationtype
     *
     * @return \App\MainBundle\Entity\Technicalexaminationtype
     */
    public function getTechnicalexaminationtype()
    {
        return $this->technicalexaminationtype;
    }
}