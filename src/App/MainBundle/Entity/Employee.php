<?php

namespace App\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Employee
{


	/**
	 * @ORM\OneToMany(targetEntity="Medical", mappedBy="employee")
	 */
	protected $medical;

	/**
	 * @ORM\OneToMany(targetEntity="Trauma", mappedBy="employee")
	 */
	protected $trauma;

//	/**
//	 * @ORM\ManyToOne(targetEntity="Enterprise", inversedBy="employee")
//	 * @ORM\JoinColumn(name="enterprise", referencedColumnName="id")
//	 */
//	protected $enterprise;

    /**
     * @ORM\ManyToMany(targetEntity="Enterprise", cascade={"persist"})
     * @ORM\JoinTable(name="employee_enterprise")
     */
    private $enterprise;

	/**
	 * @ORM\ManyToOne(targetEntity="Marriagekind", inversedBy="employee")
	 * @ORM\JoinColumn(name="marriagekind", referencedColumnName="id", nullable=true)
	 */
	protected $marriagekind;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Profession", inversedBy="employee")
	 * @ORM\JoinColumn(name="profession", referencedColumnName="id", nullable=true)
	 */
    private $profession;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
	 */
	private $lastname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
	 */
	private $firstname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="middlename", type="string", length=255, nullable=true)
	 */
	private $middlename;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="sex", type="integer")
	 */
	private $sex;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="bithday", type="date", nullable=true)
	 */
	private $bithday;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="date_first_medical", type="date", nullable=true)
	 */
	private $date_first_medical;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="date_instruction", type="date", nullable=true)
	 */
	private $date_instruction;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enterprise = new ArrayCollection();
        $this->medical = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trauma = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastname
     *
     * @param string $lastname
     * @return Employee
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Employee
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set middlename
     *
     * @param string $middlename
     * @return Employee
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    
        return $this;
    }

    /**
     * Get middlename
     *
     * @return string 
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     * @return Employee
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    
        return $this;
    }

    /**
     * Get sex
     *
     * @return integer 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set bithday
     *
     * @param \DateTime $bithday
     * @return Employee
     */
    public function setBithday($bithday)
    {
        $this->bithday = $bithday;
    
        return $this;
    }

    /**
     * Get bithday
     *
     * @return \DateTime 
     */
    public function getBithday()
    {
        return $this->bithday;
    }

    /**
     * Set date_first_medical
     *
     * @param \DateTime $dateFirstMedical
     * @return Employee
     */
    public function setDateFirstMedical($dateFirstMedical)
    {
        $this->date_first_medical = $dateFirstMedical;
    
        return $this;
    }

    /**
     * Get date_first_medical
     *
     * @return \DateTime 
     */
    public function getDateFirstMedical()
    {
        return $this->date_first_medical;
    }

    /**
     * Set date_instruction
     *
     * @param \DateTime $dateInstruction
     * @return Employee
     */
    public function setDateInstruction($dateInstruction)
    {
        $this->date_instruction = $dateInstruction;
    
        return $this;
    }

    /**
     * Get date_instruction
     *
     * @return \DateTime 
     */
    public function getDateInstruction()
    {
        return $this->date_instruction;
    }

    /**
     * Add medical
     *
     * @param \App\MainBundle\Entity\Medical $medical
     * @return Employee
     */
    public function addMedical(\App\MainBundle\Entity\Medical $medical)
    {
        $this->medical[] = $medical;
    
        return $this;
    }

    /**
     * Remove medical
     *
     * @param \App\MainBundle\Entity\Medical $medical
     */
    public function removeMedical(\App\MainBundle\Entity\Medical $medical)
    {
        $this->medical->removeElement($medical);
    }

    /**
     * Get medical
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedical()
    {
        return $this->medical;
    }

    /**
     * Add trauma
     *
     * @param \App\MainBundle\Entity\Trauma $trauma
     * @return Employee
     */
    public function addTrauma(\App\MainBundle\Entity\Trauma $trauma)
    {
        $this->trauma[] = $trauma;
    
        return $this;
    }

    /**
     * Remove trauma
     *
     * @param \App\MainBundle\Entity\Trauma $trauma
     */
    public function removeTrauma(\App\MainBundle\Entity\Trauma $trauma)
    {
        $this->trauma->removeElement($trauma);
    }

    /**
     * Get trauma
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrauma()
    {
        return $this->trauma;
    }

    /**
     * Set enterprise
     *
     * @param \App\MainBundle\Entity\Enterprise $enterprise
     * @return Employee
     */
    public function setEnterprise(Enterprise $enterprise = null)
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

    /**
     * Set marriagekind
     *
     * @param Marriagekind $marriagekind
     * @return Employee
     */
    public function setMarriagekind(Marriagekind $marriagekind = null)
    {
        $this->marriagekind = $marriagekind;
    
        return $this;
    }

    /**
     * Get marriagekind
     *
     * @return Marriagekind
     */
    public function getMarriagekind()
    {
        return $this->marriagekind;
    }

    /**
     * Set profession
     *
     * @param Profession $profession
     * @return Employee
     */
    public function setProfession($profession = null)
    {
        $this->profession = $profession;
    
        return $this;
    }

    /**
     * Get profession
     *
     * @return Profession
     */
    public function getProfession()
    {
        return $this->profession;
    }

	public function __toString()
	{
		return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
	}
}