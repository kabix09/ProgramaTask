<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'app:user:create')]
class CreateUserCommand extends Command
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $hasher,
        private UserFactory $userFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
            ->addOption('admin', null, InputOption::VALUE_NONE, 'Assign ROLE_ADMIN');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $isAdmin = $input->getOption('admin');

        $user = $this->userFactory->createLocalUser(
            $email,
            $isAdmin ? 'Administrator' : 'Local User',
            $isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER']
        );

        $hashedPassword = $this->hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);

        $output->writeln("User <info>$email</info> created successfully!");

        return Command::SUCCESS;
    }
}
