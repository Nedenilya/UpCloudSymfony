<?php

namespace App\Entity;

use App\Repository\UploadsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=150, unique=false)
     *
     * @Assert\File(
     *     maxSize = "1024M")
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
    private string $uploaded;

    public function setUploaded(string $uploaded): self
    {
        $this->uploaded = $uploaded;

        return $this;
    }
    
    public function getUploaded(): string
    {
        return $this->uploaded;
    }
}
