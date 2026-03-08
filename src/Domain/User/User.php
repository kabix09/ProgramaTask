<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Common\AggregateRootTrait;
use App\Domain\User\Event\UserCreatedEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    use AggregateRootTrait;

    #[ORM\Id, ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(unique: true)]
    private int $externalId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    public function __construct(Uuid $id, int $externalId, string $name, string $email)
    {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->name = $name;
        $this->email = $email;

        $this->recordEvent(new UserCreatedEvent(
            $this->id->toRfc4122(),
            $this->email
        ));
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
}
