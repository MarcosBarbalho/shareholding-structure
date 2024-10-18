<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/organizations', name: 'organizations.')]
final class OrganizationController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(OrganizationRepository $organizationRepository): Response
    {
        return $this->json(['data' => $organizationRepository->findAll()]);
    }

    #[Route(name: 'store', methods: ['POST'])]
    public function store(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $input = $request->getPayload();

        $organization = (new Organization())
            ->setName($input->get('name'))
            ->setDocument($input->get('document'));

        if (count($errors = $validator->validate($organization)) > 0) {
            return $this->json($errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($organization);
        $entityManager->flush();

        return $this->json(['data' => $organization], status: Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Organization $organization): Response
    {
        return $this->json(['data' => $organization]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Request $request,
        Organization $organization,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $input = $request->getPayload();

        $organization
            ->setName($input->get('name'))
            ->setDocument($organization->getDocument());

        if (count($errors = $validator->validate($organization)) > 0) {
            return $this->json($errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($organization);
        $entityManager->flush();

        return $this->json(['data' => $organization]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(
        Request $request,
        Organization $organization,
        EntityManagerInterface $entityManager,
    ): Response {
        $entityManager->remove($organization);
        $entityManager->flush();

        return $this->json([], status: Response::HTTP_NO_CONTENT);
    }
}
