<?php

namespace App\Entity;

use App\Repository\UploadsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadsRepository::class)
 */
class Uploads
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=60, unique=false)
     */
    private $title; 

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=60, unique=false)
     */
    private $fileName; 

    public function setFileName(string $name): self
    {
        $this->fileName = $name;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @ORM\Column(type="string", length=10, unique=false)
     */
    private $size;

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @ORM\Column(type="string", length=35, unique=false)
     */
    private $extension;

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @ORM\Column(type="string", length=35, unique=false)
     */
    private DateTimeInterface $uploaded;

    public function setUploaded(DateTimeInterface $uploaded): self
    {
        $this->uploaded = $uploaded;

        return $this;
    }
    
    public function getUploaded(): string
    {
        return $this->uploaded;
    }
}
