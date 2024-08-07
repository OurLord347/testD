<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
class GuestDto
{
    #[SerializedName('first_name')]
    #[Assert\NotBlank]
    private $firstName;

    #[SerializedName('last_name')]
    #[Assert\NotBlank]
    private $lastName;

    #[SerializedName('email')]
    #[Assert\Email]
    #[Assert\NotBlank]
    private $email;

    #[SerializedName('phone')]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?/',
        message: 'The phone number is not valid'
    )]
    private $phone;

    #[SerializedName('country')]
    private $country;

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }

    public function getCountry(): ?string { return $this->country; }
    public function setCountry(?string $country): self { $this->country = $country; return $this; }

}