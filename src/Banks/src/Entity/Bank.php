<?php


namespace Banks\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="banks")
 */
class Bank
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="parent_id", nullable=false)
     */
    protected $parent_id;

    /**
     * One Bank Has Many Banks
     * @ORM\OneToMany(targetEntity="Banks\Entity\Bank", mappedBy="parent")
     */
    private $children;

    /**
     * Many Banks Belong To One Bank
     * @ORM\ManyToOne(targetEntity="Banks\Entity\Bank", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="phone", nullable=false)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", name="fax", nullable=false)
     */
    protected $fax;

    /**
     * @ORM\Column(type="string", name="address1", nullable=false)
     */
    protected $address1;

    /**
     * @ORM\Column(type="string", name="address2", nullable=false)
     */
    protected $address2;

    /**
     * @ORM\Column(type="string", name="city", nullable=false)
     */
    protected $city;

    /**
     * @ORM\Column(type="integer", name="zone_id", nullable=false)
     */
    protected $zone_id;

    /**
     * @ORM\Column(type="string", name="zip", nullable=false)
     */
    protected $zip;

    /**
     * @ORM\Column(type="decimal", name="product_1_price", nullable=false)
     */
    protected $product_1_price;

    /**
     * @ORM\Column(type="decimal", name="product_2_price", nullable=false)
     */
    protected $product_2_price;

    /**
     * @ORM\Column(type="integer", name="allow_email_attachment", nullable=false)
     */
    protected $allow_email_attachment;

    /**
     * @ORM\Column(type="integer", name="is_active", nullable=false)
     */
    protected $is_active;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $modified;

    /**
     * Bank constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }


    /**
     * @param array $requestBody
     * @throws \Exception
     */
    public function setBank(array $requestBody)
    {
        $this->setName($requestBody['name']);
        $this->setParentId($requestBody['parent_id']);
        $this->setPhone($requestBody['phone']);
        $this->setFax($requestBody['fax']);
        $this->setAddress1($requestBody['address1']);
        $this->setAddress2($requestBody['address2']);
        $this->setCity($requestBody['city']);
        $this->setZoneId($requestBody['zone_id']);
        $this->setZip($requestBody['zip']);
        $this->setProduct1Price($requestBody['product_1_price']);
        $this->setProduct2Price($requestBody['product_2_price']);
        $this->setAllowEmailAttachment($requestBody['allow_email_attachment']);
        $this->setModified(new \DateTime("now"));

        if(!isset($requestBody['is_active']))
        {
            $this->setIsActive(1);
        } else {
            $this->setIsActive($requestBody['is_active']);
        }
    }

    /**
     * @return Collection|null
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * @param $bank
     */
    public function setParent($bank): void
    {
        $this->parent = $bank;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1($address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2($address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * @param int $zone_id
     */
    public function setZoneId($zone_id): void
    {
        $this->zone_id = $zone_id;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return double
     */
    public function getProduct1Price()
    {
        return $this->product_1_price;
    }

    /**
     * @param double $product_1_price
     */
    public function setProduct1Price($product_1_price): void
    {
        $this->product_1_price = $product_1_price;
    }

    /**
     * @return double
     */
    public function getProduct2Price()
    {
        return $this->product_2_price;
    }

    /**
     * @param double $product_2_price
     */
    public function setProduct2Price($product_2_price): void
    {
        $this->product_2_price = $product_2_price;
    }

    /**
     * @return int
     */
    public function getAllowEmailAttachment()
    {
        return $this->allow_email_attachment;
    }

    /**
     * @param int $allow_email_attachment
     */
    public function setAllowEmailAttachment($allow_email_attachment): void
    {
        $this->allow_email_attachment = $allow_email_attachment;
    }

    /**
     * @return int
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param int $is_active
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @throws \Exception
     */
    public function setCreated(\DateTime $created): void
    {
        if(!$created && empty($this->getId())) {
            $this->created = new \DateTime("now");
        } else {
            $this->created = $created;
        }
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     * @throws \Exception
     */
    public function setModified(\DateTime $modified): void
    {
        if(!$modified && empty($this->getId())) {
            $this->modified = new \DateTime("now");
        } else {
            $this->modified = $modified;
        }
    }


}