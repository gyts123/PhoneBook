<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\SharedEntriesRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\PhoneBookEntry;

/**
 * @ORM\Entity(repositoryClass=ShatredEntriesRepository::class)
 */
class SharedEntries
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
     * @var \PhoneBookEntry
     *
     * @ORM\ManyToOne(targetEntity="PhoneBookEntry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_phone_book_entry", referencedColumnName="id")
     * })
     */
    private $fkPhoneBookEntry;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user", referencedColumnName="id")
     * })
     */
    private $fkUser;

    /**
     * @return \User
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    public function setFkUser(?User $fkUser): self
    {
        $this->fkUser = $fkUser;

        return $this;
    }
    public function getFkPhoneBookEntry()
    {
        return $this->fkPhoneBookEntry;
    }

    public function setFkPhoneBookEntry(?PhoneBookEntry $fkPhoneBookEntry): self
    {
        $this->fkPhoneBookEntry = $fkPhoneBookEntry;

        return $this;
    }

}
