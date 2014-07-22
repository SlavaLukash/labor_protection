<?php
/**
 * @author Rustam Ibragimov
 * @mail Rustam.Ibragimov@softline.ru
 * @date 07.11.13
 */

namespace App\MainBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\ManyToMany(targetEntity="Enterprise", cascade={"persist"})
     * @ORM\JoinTable(name="user_enterprise")
     */
    private $enterprise;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var \DateTime
	 */
	protected $expiresAt;

	public function __construct()
	{
		parent::__construct();
        $this->enterprise = new ArrayCollection();
		// your own logic
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

	public function __toString()
	{
		return $this->username;
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
	 * Get ExpiresAt
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getExpiresAt()
	{
		return $this->expiresAt;
	}

	/**
	 * @param \DateTime $date
	 *
	 * @return User
	 */
	public function getCredentialsExpireAt()
	{
		return $this->credentialsExpireAt;
	}
}