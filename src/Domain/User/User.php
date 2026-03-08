<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Common\AggregateRootTrait;
use App\Domain\User\Event\UserCreatedEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use AggregateRootTrait;

    #[ORM\Id, ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(unique: true, nullable: true)]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    /** @var array|string[]  */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    public function __construct(Uuid $id, ?int $externalId, string $name, string $email, array $roles = ['ROLE_USER'])
    {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;

        $this->recordEvent(new UserCreatedEvent(
            $this->id->toRfc4122(),
            $this->email
        ));
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // Nie przechowujemy surowych haseł, więc zostawiamy puste
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getExternalId(): int
    {
        return $this->externalId;
    }
}
