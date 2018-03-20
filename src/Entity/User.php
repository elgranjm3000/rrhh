<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email ya esta registrado")
 * @UniqueEntity(fields="username", message="Username ya esta registrado")

 */
class User implements UserInterface, \Serializable
{


    /**
     * @ORM\OneToMany(targetEntity="Asignar", mappedBy="usuarioasignado", cascade={"remove","persist"}, orphanRemoval=true)
     */
    protected $asignar;
 
    
    public static $possibleRoles = array(
        'ADMINISTRADOR' => 'ROLE_ADMIN',
        'USUARIOS'  => 'ROLE_USER',
        'CLIENTES' => 'ROLE_CLIENTES'
    );
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Campo Obligatorio")
     */
    private $username;


     /**
     * @Assert\NotBlank(message="Campo Obligatorio")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;



    /**
     * @ORM\Column(type="simple_array", length=20)
     *  @Assert\NotBlank(message="Campo Obligatorio")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Campo Obligatorio")
     * @Assert\Email(message="Email invalido")
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->asignar = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getUsername()
    {
        return $this->username;
    }
     public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

  

    public function getRoles()
    {
        //return array('ROLE_USER');
       /* if (is_null($this->roles)) {
            return [];
        }*/
        
        //return array($this->roles);
        return $this->roles;
    }
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
 

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }


     public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }


     public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

   public function __toString()
   {
      return strval($this->getId());
   }


    


}