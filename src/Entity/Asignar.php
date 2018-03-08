<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Asignar
{

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="asignar")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    protected $usuarioasignado;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="asignar")
     * @ORM\JoinColumn(name="idmaterial", referencedColumnName="id")
     */
    protected $materialasignado;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="integer")
     */
    private $idusuario;

    /**
     * @ORM\Column(type="integer")
     */
    private $idmaterial;

    

    
    public function getId()
    {
        return $this->id;
    }
     public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdusuario()
    {
        return $this->idusuario;
    }
     public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }


    public function getIdmaterial()
    {
        return $this->idmaterial;
    }
    public function setIdmaterial($idmaterial)
    {
        $this->idmaterial = $idmaterial;
    }


     public function getUsuarioasignado()
    {
        return $this->usuarioasignado;
    }
    public function setUsuarioasignado($usuarioasignado)
    {
        $this->usuarioasignado = $usuarioasignado;
    }


    public function getMaterialasignado()
    {
        return $this->materialasignado;
    }
    public function setMaterialasignado($materialasignado)
    {
        $this->materialasignado = $materialasignado;
    }
   
 public function __toString()
   {
      return strval($this->getId());
   }
   


     
}
