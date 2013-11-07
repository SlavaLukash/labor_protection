<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Equipment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Equipment
{

	/**
	 * @ORM\OneToMany(targetEntity="Technicalexamination", mappedBy="equipment")
	 */
	protected $technicalexamination;


	/**
	 * @ORM\ManyToOne(targetEntity="Equipmentsubgroup", inversedBy="equipment")
	 * @ORM\JoinColumn(name="equipmentsubgroup", referencedColumnName="id")
	 */
	protected $equipmentsubgroup;


	/**
	 * @ORM\ManyToOne(targetEntity="Subdivision", inversedBy="equipment")
	 * @ORM\JoinColumn(name="subdivision", referencedColumnName="id")
	 */
	protected $subdivision;


	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->technicalexamination = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;


	/**
	 * @ORM\ManyToOne(targetEntity="Registrationtype", inversedBy="equipment")
	 * @ORM\JoinColumn(name="registrationtype", referencedColumnName="id")
	 */
	protected $registrationtype;

    /**
     * @var string
     *
     * @ORM\Column(name="registrationnumber", type="string", length=20)
     */
    private $registrationnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="internalnumber", type="string", length=20)
     */
    private $internalnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="factorynumber", type="string", length=20)
     */
    private $factorynumber;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="manufacturer", type="string", length=255)
	 */
	private $manufacturer;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="productiondate", type="date")
	 */
	private $productiondate;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="startupdate", type="date")
	 */
	private $startupdate;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="life", type="integer")
	 */
	private $life;


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
     * @return Equipment
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
     * Set model
     *
     * @param string $model
     * @return Equipment
     */
    public function setModel($model)
    {
        $this->model = $model;
    
        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set registrationnumber
     *
     * @param string $registrationnumber
     * @return Equipment
     */
    public function setRegistrationnumber($registrationnumber)
    {
        $this->registrationnumber = $registrationnumber;
    
        return $this;
    }

    /**
     * Get registrationnumber
     *
     * @return string 
     */
    public function getRegistrationnumber()
    {
        return $this->registrationnumber;
    }

    /**
     * Set internalnumber
     *
     * @param string $internalnumber
     * @return Equipment
     */
    public function setInternalnumber($internalnumber)
    {
        $this->internalnumber = $internalnumber;
    
        return $this;
    }

    /**
     * Get internalnumber
     *
     * @return string 
     */
    public function getInternalnumber()
    {
        return $this->internalnumber;
    }

    /**
     * Set factorynumber
     *
     * @param string $factorynumber
     * @return Equipment
     */
    public function setFactorynumber($factorynumber)
    {
        $this->factorynumber = $factorynumber;
    
        return $this;
    }

    /**
     * Get factorynumber
     *
     * @return string 
     */
    public function getFactorynumber()
    {
        return $this->factorynumber;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     * @return Equipment
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    
        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set productiondate
     *
     * @param \DateTime $productiondate
     * @return Equipment
     */
    public function setProductiondate($productiondate)
    {
        $this->productiondate = $productiondate;
    
        return $this;
    }

    /**
     * Get productiondate
     *
     * @return \DateTime 
     */
    public function getProductiondate()
    {
        return $this->productiondate;
    }

    /**
     * Set startupdate
     *
     * @param \DateTime $startupdate
     * @return Equipment
     */
    public function setStartupdate($startupdate)
    {
        $this->startupdate = $startupdate;
    
        return $this;
    }

    /**
     * Get startupdate
     *
     * @return \DateTime 
     */
    public function getStartupdate()
    {
        return $this->startupdate;
    }

    /**
     * Set life
     *
     * @param integer $life
     * @return Equipment
     */
    public function setLife($life)
    {
        $this->life = $life;
    
        return $this;
    }

    /**
     * Get life
     *
     * @return integer 
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Add technicalexamination
     *
     * @param \Sir\OtBundle\Entity\Technicalexamination $technicalexamination
     * @return Equipment
     */
    public function addTechnicalexamination(\Sir\OtBundle\Entity\Technicalexamination $technicalexamination)
    {
        $this->technicalexamination[] = $technicalexamination;
    
        return $this;
    }

    /**
     * Remove technicalexamination
     *
     * @param \Sir\OtBundle\Entity\Technicalexamination $technicalexamination
     */
    public function removeTechnicalexamination(\Sir\OtBundle\Entity\Technicalexamination $technicalexamination)
    {
        $this->technicalexamination->removeElement($technicalexamination);
    }

    /**
     * Get technicalexamination
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTechnicalexamination()
    {
        return $this->technicalexamination;
    }

    /**
     * Set equipmentsubgroup
     *
     * @param \Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup
     * @return Equipment
     */
    public function setEquipmentsubgroup(\Sir\OtBundle\Entity\Equipmentsubgroup $equipmentsubgroup = null)
    {
        $this->equipmentsubgroup = $equipmentsubgroup;
    
        return $this;
    }

    /**
     * Get equipmentsubgroup
     *
     * @return \Sir\OtBundle\Entity\Equipmentsubgroup 
     */
    public function getEquipmentsubgroup()
    {
        return $this->equipmentsubgroup;
    }

    /**
     * Set subdivision
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivision
     * @return Equipment
     */
    public function setSubdivision(\Sir\OtBundle\Entity\Subdivision $subdivision = null)
    {
        $this->subdivision = $subdivision;
    
        return $this;
    }

    /**
     * Get subdivision
     *
     * @return \Sir\OtBundle\Entity\Subdivision 
     */
    public function getSubdivision()
    {
        return $this->subdivision;
    }

    /**
     * Set registrationtype
     *
     * @param \Sir\OtBundle\Entity\Registrationtype $registrationtype
     * @return Equipment
     */
    public function setRegistrationtype(\Sir\OtBundle\Entity\Registrationtype $registrationtype = null)
    {
        $this->registrationtype = $registrationtype;
    
        return $this;
    }

    /**
     * Get registrationtype
     *
     * @return \Sir\OtBundle\Entity\Registrationtype 
     */
    public function getRegistrationtype()
    {
        return $this->registrationtype;
    }
}