<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model", indexes={@ORM\Index(name="join_marque", columns={"make_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 */
class Model
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var Make
     *
     * @ORM\OneToOne(targetEntity="Make")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="make_id", referencedColumnName="id")
     * })
     */
    private $make;

     public function __toString(){
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Model
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
     * Set id
     *
     * @param integer $id
     *
     * @return Model
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set make
     *
     * @param Make $make
     *
     * @return Model
     */
    public function setMake(Make $make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return Make
     */
    public function getMake()
    {
        return $this->make;
    }
}
