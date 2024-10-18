<?php

namespace App\Controller;

use App\Entity\Associate;
use App\Entity\Organization;
use App\Repository\AssociateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/organizations/{organization}/associates', name: 'organizations.associates')]
final class AssociateController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(
        AssociateRepository $associateRepository,
        Organization $organization,
    ): Response {
        return $this->json(['data' => $associateRepository->findByOrganizationId($organization->getId())]);
    }

    #[Route(name: 'store', methods: ['POST'])]
    public function store(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Organization $organization,
    ): Response {
        $input = $request->getPayload();

        $associate = (new Associate())
            ->setName($input->get('name'))
            ->setDocument($input->get('document'))
            ->setOrganization($organization);

        if (count($errors = $validator->validate($associate)) > 0) {
            return $this->json($errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($associate);
        $entityManager->flush();

        return $this->json(['data' => $associate], status: Response::HTTP_CREATED);
    }

    #[Route('/{associate}', name: 'show', methods: ['GET'])]
    public function show(
        AssociateRepository $associateRepository,
        Organization $organization,
        Associate $associate,
    ): Response {
        $associate = $this->getAssociate($associateRepository, $organization, $associate);

        if (is_null($associate)) {
            return $this->json([], status: Response::HTTP_NOT_FOUND);
        }

        return $this->json(['data' => $associate]);
    }

    #[Route('/{associate}', name: 'update', methods: ['PUT'])]
    public function update(
        Request $request,
        AssociateRepository $associateRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Organization $organization,
        Associate $associate,
    ): Response {
        $associate = $this->getAssociate($associateRepository, $organization, $associate);

        if (is_null($associate)) {
            return $this->json([], status: Response::HTTP_NOT_FOUND);
        }

        $input = $request->getPayload();

        $associate
            ->setName($input->get('name'))
            ->setDocument($associate->getDocument())
            ->setOrganization($organization);

        if (count($errors = $validator->validate($associate)) > 0) {
            return $this->json($errors, status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($organization);
        $entityManager->flush();

        return $this->json(['data' => $organization]);
    }

    #[Route('/{associate}', name: 'delete', methods: ['DELETE'])]
    public function delete(
        Request $request,
        AssociateRepository $associateRepository,
        EntityManagerInterface $entityManager,
        Organization $organization,
        Associate $associate,
    ): Response {
        $associate = $this->getAssociate($associateRepository, $organization, $associate);

        if (is_null($associate)) {
            return $this->json([], status: Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($associate);
        $entityManager->flush();

        return $this->json([], status: Response::HTTP_NO_CONTENT);
    }

    private function getAssociate(
        AssociateRepository $associateRepository,
        Organization $organization,
        Associate $associate,
    ): ?Associate {
        return $associateRepository->findOneByOrganizationId($organization->getId(), $associate->getId());
    }
}
