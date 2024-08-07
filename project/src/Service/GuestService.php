<?php

namespace App\Service;

use App\DTO\GuestDto;
use App\Entity\Guest;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;

class GuestService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }
    public function getGuest(string $id): ?Guest
    {
        return $this->entityManager->getRepository(Guest::class)->find($id);
    }
    public function removeGuest(Guest $guest)
    {
        $this->entityManager->remove($guest);
        $this->entityManager->flush();
    }

    public function saveGuest(GuestDto $guestDto): Guest
    {
        $country = $guestDto->getCountry() ?? $this->getCountryByPhone($guestDto->getPhone());

        $guest = new Guest();
        $guest->setFirstName($guestDto->getFirstName());
        $guest->setLastName($guestDto->getLastName());
        $guest->setEmail($guestDto->getEmail());
        $guest->setPhone($guestDto->getPhone());
        $guest->setCountry($country);

        $this->entityManager->persist($guest);
        $this->entityManager->flush();

        return $guest;
    }
    public function updateGuest(Guest $guest, GuestDto $guestDto): Guest
    {
        $country = $guestDto->getCountry() ?? $this->getCountryByPhone($guestDto->getPhone());

        $guest->setFirstName($guestDto->getFirstName());
        $guest->setLastName($guestDto->getLastName());
        $guest->setEmail($guestDto->getEmail());
        $guest->setPhone($guestDto->getPhone());
        $guest->setCountry($country);

        $this->entityManager->flush();
        return $guest;
    }
    private function getCountryByPhone(string $phone): ?string
    {
        if (str_starts_with($phone, '+7')) {
            return 'Russia';
        }
        return null;
    }
}