<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
      * @ORM\Column(type="text")
      */
     private $description;

     /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob", nullable=true)
     */
    private $image;


     /**
     * @var string
     *
     * @ORM\Column(name="tamano", type="string", length=15, nullable=true)
     */
    private $tamano;


    /**
     * @var string
     *
     * @ORM\Column(name="formato", type="string", length=10, nullable=true)
     */
    private $formato;

    
    public function getId()
    {
        return $this->id;
    }
     public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }

      public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getTamano()
    {
        return $this->tamano;
    }
    public function setTamano($tamano)
    {
        $this->tamano = $tamano;
    }

     public function getFormato()
    {
        return $this->formato;
    }
    public function setFormato($formato)
    {
        $this->formato = $formato;
    }


     
}
