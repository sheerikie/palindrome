<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 */
class Upload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uploadName;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uploadFile;

    /**
     * @ORM\Column(type="integer", length=255,nullable=true)
     */
    private $palindromeCount;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $palindrome;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $highlight;



    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
    * @return string
    */
    public function getUploadName(): ?string
    {
        return $this->uploadName;
    }
    /**
     * @param string $uploadName
     */
    public function setUploadName(string $uploadName): self
    {
        $this->uploadName = $uploadName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUploadFile(): ?string
    {
        return $this->uploadFile;
    }
    /**
     * @param string $uploadFile
     */
    public function setUploadFile(?string $uploadFile): self
    {
        $this->uploadFile = $uploadFile;

        return $this;
    }

    /**
     * @return int
     */
    public function getPalindromeCount(): ?int
    {
        return $this->palindromeCount;
    }
    /**
    * @param int $palindromeCount
    */
    public function setPalindromeCount(?int $palindromeCount): self
    {
        $this->palindromeCount= $palindromeCount;

        return $this;
    }
    /**
    * @return string
    */
    public function getPalindrome(): ?string
    {
        return $this->palindrome;
    }
    /**
    * @param string $palindrome
    */
    public function setPalindrome(?string $palindrome): self
    {
        $this->palindrome= $palindrome;

        return $this;
    }
    /**
    * @return string
    */
    public function getHighlight(): ?string
    {
        return $this->highlight;
    }
    /**
    * @param string $highlight
    */
    public function setHighlight(?string $highlight): self
    {
        $this->highlight= $highlight;

        return $this;
    }

  
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'uploadName' => $this->getUploadName(),
            'uploadFile' => $this->getUploadFile(),
            'palindromeCount' => $this->getPalindromeCount(),
            'palindrome' => $this->getPalindrome(),
            'highlight' => $this->getHighlight(),
         
        ];
    }
}