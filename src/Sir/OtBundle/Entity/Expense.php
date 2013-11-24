<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expense
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Expense
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


	/**
	 * @ORM\ManyToOne(targetEntity="Enterprise", inversedBy="expense")
	 * @ORM\JoinColumn(name="enterprise", referencedColumnName="id")
	 */
	protected $enterprise;


	/**
	 * @ORM\ManyToOne(targetEntity="Expensekind", inversedBy="expense")
	 * @ORM\JoinColumn(name="expensekind", referencedColumnName="id")
	 */
	protected $expensekind;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="year", type="date")
	 */
	private $year;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum1;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum2;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum3;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum4;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum5;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum6;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum7;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum8;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum9;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum10;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum11;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	protected $sum12;
	

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
     * Set year
     *
     * @param \DateTime $year
     * @return Expense
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set sum1
     *
     * @param float $sum1
     * @return Expense
     */
    public function setSum1($sum1)
    {
        $this->sum1 = $sum1;
    
        return $this;
    }

    /**
     * Get sum1
     *
     * @return float 
     */
    public function getSum1()
    {
        return $this->sum1;
    }

    /**
     * Set sum2
     *
     * @param float $sum2
     * @return Expense
     */
    public function setSum2($sum2)
    {
        $this->sum2 = $sum2;
    
        return $this;
    }

    /**
     * Get sum2
     *
     * @return float 
     */
    public function getSum2()
    {
        return $this->sum2;
    }

    /**
     * Set sum3
     *
     * @param float $sum3
     * @return Expense
     */
    public function setSum3($sum3)
    {
        $this->sum3 = $sum3;
    
        return $this;
    }

    /**
     * Get sum3
     *
     * @return float 
     */
    public function getSum3()
    {
        return $this->sum3;
    }

    /**
     * Set sum4
     *
     * @param float $sum4
     * @return Expense
     */
    public function setSum4($sum4)
    {
        $this->sum4 = $sum4;
    
        return $this;
    }

    /**
     * Get sum4
     *
     * @return float 
     */
    public function getSum4()
    {
        return $this->sum4;
    }

    /**
     * Set sum5
     *
     * @param float $sum5
     * @return Expense
     */
    public function setSum5($sum5)
    {
        $this->sum5 = $sum5;
    
        return $this;
    }

    /**
     * Get sum5
     *
     * @return float 
     */
    public function getSum5()
    {
        return $this->sum5;
    }

    /**
     * Set sum6
     *
     * @param float $sum6
     * @return Expense
     */
    public function setSum6($sum6)
    {
        $this->sum6 = $sum6;
    
        return $this;
    }

    /**
     * Get sum6
     *
     * @return float 
     */
    public function getSum6()
    {
        return $this->sum6;
    }

    /**
     * Set sum7
     *
     * @param float $sum7
     * @return Expense
     */
    public function setSum7($sum7)
    {
        $this->sum7 = $sum7;
    
        return $this;
    }

    /**
     * Get sum7
     *
     * @return float 
     */
    public function getSum7()
    {
        return $this->sum7;
    }

    /**
     * Set sum8
     *
     * @param float $sum8
     * @return Expense
     */
    public function setSum8($sum8)
    {
        $this->sum8 = $sum8;
    
        return $this;
    }

    /**
     * Get sum8
     *
     * @return float 
     */
    public function getSum8()
    {
        return $this->sum8;
    }

    /**
     * Set sum9
     *
     * @param float $sum9
     * @return Expense
     */
    public function setSum9($sum9)
    {
        $this->sum9 = $sum9;
    
        return $this;
    }

    /**
     * Get sum9
     *
     * @return float 
     */
    public function getSum9()
    {
        return $this->sum9;
    }

    /**
     * Set sum10
     *
     * @param float $sum10
     * @return Expense
     */
    public function setSum10($sum10)
    {
        $this->sum10 = $sum10;
    
        return $this;
    }

    /**
     * Get sum10
     *
     * @return float 
     */
    public function getSum10()
    {
        return $this->sum10;
    }

    /**
     * Set sum11
     *
     * @param float $sum11
     * @return Expense
     */
    public function setSum11($sum11)
    {
        $this->sum11 = $sum11;
    
        return $this;
    }

    /**
     * Get sum11
     *
     * @return float 
     */
    public function getSum11()
    {
        return $this->sum11;
    }

    /**
     * Set sum12
     *
     * @param float $sum12
     * @return Expense
     */
    public function setSum12($sum12)
    {
        $this->sum12 = $sum12;
    
        return $this;
    }

    /**
     * Get sum12
     *
     * @return float 
     */
    public function getSum12()
    {
        return $this->sum12;
    }

    /**
     * Set enterprise
     *
     * @param \Sir\OtBundle\Entity\Enterprise $enterprise
     * @return Expense
     */
    public function setEnterprise(\Sir\OtBundle\Entity\Enterprise $enterprise = null)
    {
        $this->enterprise = $enterprise;
    
        return $this;
    }

    /**
     * Get enterprise
     *
     * @return \Sir\OtBundle\Entity\Enterprise 
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * Set expensekind
     *
     * @param \Sir\OtBundle\Entity\Expensekind $expensekind
     * @return Expense
     */
    public function setExpensekind(\Sir\OtBundle\Entity\Expensekind $expensekind = null)
    {
        $this->expensekind = $expensekind;
    
        return $this;
    }

    /**
     * Get expensekind
     *
     * @return \Sir\OtBundle\Entity\Expensekind 
     */
    public function getExpensekind()
    {
        return $this->expensekind;
    }
}