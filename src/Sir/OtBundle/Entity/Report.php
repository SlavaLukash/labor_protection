<?php

namespace Sir\OtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Report
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="params", type="string")
	 */
	private $params;

	/**
	 * @ORM\ManyToOne(targetEntity="CategoryReport", inversedBy="report")
	 * @ORM\JoinColumn(name="categoryreport", referencedColumnName="id")
	 */
	protected $categoryreport;

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
     * @return Report
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
     * Set params
     *
     * @param string $params
     * @return Report
     */
    public function setParams($params)
    {
        $this->params = $params;
    
        return $this;
    }

    /**
     * Get params
     *
     * @return string 
     */
    public function getParams()
    {
        return $this->params;
    }

	public function __toString()
	{
		return $this->categoryreport;
	}

    /**
     * Set categoryreport
     *
     * @param \Sir\OtBundle\Entity\CategoryReport $categoryreport
     * @return Report
     */
    public function setCategoryreport(\Sir\OtBundle\Entity\CategoryReport $categoryreport = null)
    {
        $this->categoryreport = $categoryreport;
    
        return $this;
    }

    /**
     * Get categoryreport
     *
     * @return \Sir\OtBundle\Entity\CategoryReport 
     */
    public function getCategoryreport()
    {
        return $this->categoryreport;
    }
}