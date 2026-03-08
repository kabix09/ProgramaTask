<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL\Resolver;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserResolver implements AliasedInterface
{
    public function __construct(private Security $security)
    {
    }

    public function __invoke(): ?UserInterface
    {
        return $this->security->getUser();
    }

    /**
     * @return string[]
     */
    public static function getAliases(): array
    {
        return [
            '__invoke' => 'user_resolver',
        ];
    }
}
