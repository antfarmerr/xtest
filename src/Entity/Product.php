<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
* @ORM\Table(name="product")
*/
class Product {
  /**
  * --------------------------------------------
  * @var int
  * 
  * @ORM\Id()
  * @ORM\GeneratedValue()
  * @ORM\Column(type="integer")
  * 
  */
  private $id;

  /**
  * --------------------------------------------
  * @var string
  * 
  * @ORM\Column(type="text")
  * 
  */
  private $name;

  /**
  * --------------------------------------------
  * @var string
  * 
  * @ORM\Column(type="string", length=255, nullable=true)
  * 
  * Правильно было бы вынести эту сущность в отдельный справочник
  */
  private $manufacturer;

  /**
  * --------------------------------------------
  * @var string
  * 
  * @ORM\Column(type="string", length=255, nullable=true)
  * 
  * Правильно было бы вынести эту сущность в отдельный справочник и хранить код ISO 3166
  */
  private $country;

  /**
  * --------------------------------------------
  * @var float 
  * 
  * @ORM\Column(type="decimal", precision=11, scale=2)
  * 
  * Правильно было бы вынести эту сущность в отдельный справочник
  * Хорошая практика хранить цену в "копейках"
  * Не раскрыта тема используемой валюты
  * Цен одновременно может быть много
  */
  private $price;

  /**
  * --------------------------------------------
  * @var \DateTime
  * 
  * @ORM\Column(type="datetime", nullable=true)
  */
  private $expiration;

  /**
  * --------------------------------------------
  * @var int
  * @ORM\ManyToOne(targetEntity="App\Entity\Section", fetch="EAGER")
  * @ORM\JoinColumn(name="section", referencedColumnName="id", nullable=true, onDelete="SET NULL")
  */
  private $section;
 
  public function getId(): ?int {
    return $this->id;
  }
  public function getName(): ?string {
    return $this->name;
  }
  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }
  public function getManufacturer(): ?string {
    return $this->manufacturer;
  }
  public function setManufacturer(?string $manufacturer): self {
    $this->manufacturer = $manufacturer;
    return $this;
  }
  public function getCountry(): ?string {
    return $this->country;
  }
  public function setCountry(?string $country): self {
    $this->country = $country;
    return $this;
  }
  public function getPrice() {
    return $this->price;
  }
  public function setPrice($price): self {
    $this->price = $price;
    return $this;
  }
  public function getExpiration(): ?\DateTimeInterface {
    return $this->expiration;
  }
  public function setExpiration(?\DateTimeInterface $expiration): self {
    $this->expiration = $expiration;
    return $this;
  }
  public function getSection(): ?int {
    return ($this->section)?$this->section->getId():null;
  }
  public function setSection(Section $section): self {
    $this->section = $section;
    return $this;
  }
  public function setSectionid(?int $section): self {
    $this->section = $section;
    return $this;
  }
}
