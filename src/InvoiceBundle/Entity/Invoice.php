<?php

namespace InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="InvoiceBundle\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Product", mappedBy="invoice")
     */
    private $products;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    public function __construct(){
        $this->products = new ArrayCollection();
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
     * Set number
     *
     * @param integer $number
     * @return Invoice
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Invoice
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Invoice
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

//    /**
//     * Add products
//     *
//     * @param \InvoiceBundle\Entity\Product $products
//     * @return Invoice
//     */
//    public function addProduct(\InvoiceBundle\Entity\Product $products)
//    {
//        $this->products[] = $products;
//
//        return $this;
//    }
//
//    /**
//     * Remove products
//     *
//     * @param \InvoiceBundle\Entity\Product $products
//     */
//    public function removeProduct(\InvoiceBundle\Entity\Product $products)
//    {
//        $this->products->removeElement($products);
//    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    public function __toString() {
        return (string)$this->getNumber();
    }

    /**
     * Add products
     *
     * @param \InvoiceBundle\Entity\Product $products
     * @return Invoice
     */
    public function addProduct(\InvoiceBundle\Entity\Product $products)
    {
        //$products->setInvoice($this);
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \InvoiceBundle\Entity\Product $products
     */
    public function removeProduct(\InvoiceBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }
}
