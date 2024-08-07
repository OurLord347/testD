<?php

namespace App\Controller;

use App\DTO\GuestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\GuestService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GuestController extends AbstractController
{
    private SerializerInterface $serializer;
    public function __construct(
        private GuestService $guestService,
        private ValidatorInterface $validator
    )
    {
        $this->serializer = new Serializer(
            [new ObjectNormalizer()]
            , [new JsonEncoder()]);
    }

    #[Route('/guests/{id}', name: 'get_guest', methods: ['GET'])]
    public function getGuest(string $id): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            return $this->json(['error' => 'Invalid UUID'], 400);
        }

        $guest = $this->guestService->getGuest($id);
        if (!$guest) {
            return $this->json(['error' => 'Guest not found'], 404);
        }
        return $this->json($guest);
    }

    #[Route('/guest', name: 'create_guest', methods: ['POST'])]
    public function createGuest(Request $request): JsonResponse
    {
        $data = $request->getContent();

        $guestDto = $this->serializer->deserialize($data, GuestDto::class, 'json');

        $errors = $this->validator->validate($guestDto);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $guest = $this->guestService->saveGuest($guestDto);

        return $this->json($guest, 200);
    }
    #[Route('/guests/{id}', name: 'update_guest', methods: ['PUT'])]
    public function updateGuest(Request $request, string $id): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            return $this->json(['error' => 'Invalid UUID'], 400);
        }

        $guest = $this->guestService->getGuest($id);
        if (!$guest) {
            return $this->json(['error' => 'Guest not found'], 404);
        }

        $data = $request->getContent();
        $guestDto = $this->serializer->deserialize($data, GuestDto::class, 'json');
        $errors = $this->validator->validate($guestDto);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }
        $guest = $this->guestService->updateGuest($guest, $guestDto);

        return $this->json($guest);
    }

    #[Route('/guests/{id}', name: 'delete_guest', methods: ['DELETE'])]
    public function deleteGuest(string $id): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            return $this->json(['error' => 'Invalid UUID'], 400);
        }
        $guest = $this->guestService->getGuest($id);
        if (!$guest) {
            return $this->json(['error' => 'Guest not found'], 404);
        }
        $this->guestService->removeGuest($guest);
        return $this->json(null, 200);
    }
}
