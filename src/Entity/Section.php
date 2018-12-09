<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
* @ORM\Table(name="section")
*/
class Section {
  /**
  * --------------------------------------------
  * @var int
  * 
  * @ORM\Id()
  * @ORM\GeneratedValue()
  * @ORM\Column(type="integer")
  */
  private $id;
  /**
  * --------------------------------------------
  * @var string
  * 
  * @ORM\Column(type="string", length=255)
  */
  private $name;
  /**
  * --------------------------------------------
  * @var int
  * 
  * @ORM\ManyToOne(targetEntity="App\Entity\Section", fetch="EAGER")
  * @ORM\JoinColumn(name="section", referencedColumnName="id", nullable=true, onDelete="SET NULL")
  */
  private $section;
  /**
  * -------------------------------------------- 
  */
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
  public function getSection(): ?int {
    return $this->section;
  }
  public function setSection(Section $section): self {
    $this->section = $section;
    return $this;
  }
}
