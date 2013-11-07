<?php

namespace Sir\OtBundle\Entity;

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
	 * @ORM\ManyToOne(targetEntity="Subdivision", inversedBy="employee")
	 * @ORM\JoinColumn(name="subdivision", referencedColumnName="id")
	 */
	protected $subdivision;

	/**
	 * @ORM\ManyToOne(targetEntity="Marriagekind", inversedBy="employee")
	 * @ORM\JoinColumn(name="marriagekind", referencedColumnName="id")
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
	 * @ORM\JoinColumn(name="profession", referencedColumnName="id")
	 */
    private $profession;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lastname", type="string", length=255)
	 */
	private $lastname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="firstname", type="string", length=255)
	 */
	private $firstname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="middlename", type="string", length=255)
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
	 * @ORM\Column(name="bithday", type="date")
	 */
	private $bithday;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="date_first_medical", type="date")
	 */
	private $date_first_medical;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="date_instruction", type="date")
	 */
	private $date_instruction;


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
     * Set subdivision
     *
     * @param \Sir\OtBundle\Entity\Subdivision $subdivision
     * @return Employee
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
     * Set profession
     *
     * @param \Sir\OtBundle\Entity\Profession $profession
     * @return Employee
     */
    public function setProfession(\Sir\OtBundle\Entity\Profession $profession = null)
    {
        $this->profession = $profession;
    
        return $this;
    }

    /**
     * Get profession
     *
     * @return \Sir\OtBundle\Entity\Profession 
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set marriagekind
     *
     * @param \Sir\OtBundle\Entity\Marriagekind $marriagekind
     * @return Employee
     */
    public function setMarriagekind(\Sir\OtBundle\Entity\Marriagekind $marriagekind = null)
    {
        $this->marriagekind = $marriagekind;
    
        return $this;
    }

    /**
     * Get marriagekind
     *
     * @return \Sir\OtBundle\Entity\Marriagekind 
     */
    public function getMarriagekind()
    {
        return $this->marriagekind;
    }
}