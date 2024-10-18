<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use geekcom\ValidatorDocs\Rules\Cnpj;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[UniqueEntity('document', message: 'The provided document is already registered.')]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 14)]
    #[Assert\Type('digit')]
    private ?string $document = null;

    #[ORM\OneToMany(targetEntity: Associate::class, mappedBy: 'organization', orphanRemoval: true)]
    private Collection $associates;

    public function __construct()
    {
        $this->associates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): static
    {
        $this->document = $document;

        return $this;
    }

    #[Ignore]
    public function getAssociates(): Collection
    {
        return $this->associates;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if ((new Cnpj())->validateCnpj('', $this->getDocument())) {
            return;
        }

        $context->buildViolation('Document structure is invalid.')
            ->atPath('document')
            ->addViolation();
    }
}
