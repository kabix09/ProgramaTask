<?php

declare(strict_types=1);

namespace App\Tests\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserFactory;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function testShouldCreateUserFromApiData(): void
    {
        $factory = new UserFactory();
        $apiData = [
            'id' => 1,
            'name' => 'Leanne Graham',
            'email' => 'Sincere@april.biz'
        ];

        $user = $factory->createFromApi($apiData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Leanne Graham', $user->getName());
        $this->assertEquals('Sincere@april.biz', $user->getEmail());
    }
}
