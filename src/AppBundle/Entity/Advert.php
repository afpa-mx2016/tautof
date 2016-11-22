<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table(name="advert", indexes={@ORM\Index(name="join_utilisateur", columns={"user_id"}), @ORM\Index(name="id_couleur", columns={"color_id"}), @ORM\Index(name="id_marque", columns={"model_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertRepository")
 */
class Advert
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer", nullable=false)
     */
    private $cost;

    /**
     * @var integer
     *
     * @ORM\Column(name="km", type="integer", nullable=false)
     */
    private $km;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", length=65535, nullable=false)
     */
    private $descr;

    /**
     * @var string
     *
     * @ORM\Column(name="pic1", type="string", length=150, nullable=false)
     */
    private $pic1;

    /**
     * @var string
     *
     * @ORM\Column(name="pic2", type="string", length=150, nullable=true)
     */
    private $pic2;

    /**
     * @var string
     *
     * @ORM\Column(name="pic3", type="string", length=150, nullable=true)
     */
    private $pic3;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Color
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="color_id", referencedColumnName="id")
     * })
     */
    private $color;

    /**
     * @var \AppBundle\Entity\Model
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     * })
     */
    private $model;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return Advert
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set km
     *
     * @param integer $km
     *
     * @return Advert
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return integer
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set descr
     *
     * @param string $descr
     *
     * @return Advert
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * Get descr
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set pic1
     *
     * @param string $pic1
     *
     * @return Advert
     */
    public function setPic1($pic1)
    {
        $this->pic1 = $pic1;

        return $this;
    }

    /**
     * Get pic1
     *
     * @return string
     */
    public function getPic1()
    {
        return $this->pic1;
    }

    /**
     * Set pic2
     *
     * @param string $pic2
     *
     * @return Advert
     */
    public function setPic2($pic2)
    {
        $this->pic2 = $pic2;

        return $this;
    }

    /**
     * Get pic2
     *
     * @return string
     */
    public function getPic2()
    {
        return $this->pic2;
    }

    /**
     * Set pic3
     *
     * @param string $pic3
     *
     * @return Advert
     */
    public function setPic3($pic3)
    {
        $this->pic3 = $pic3;

        return $this;
    }

    /**
     * Get pic3
     *
     * @return string
     */
    public function getPic3()
    {
        return $this->pic3;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Advert
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Advert
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
     * Set color
     *
     * @param \AppBundle\Entity\Color $color
     *
     * @return Advert
     */
    public function setColor(\AppBundle\Entity\Color $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \AppBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Advert
     */
    public function setModel(\AppBundle\Entity\Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
