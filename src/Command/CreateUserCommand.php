<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Updated interface

class CreateUserCommand extends Command
{
    private $entityManager;
    private $passwordHasher; 

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher) // Updated type hint
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        parent::__construct();
    }

    protected static $defaultName = 'app:create-user';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail('baba@gmail.com');
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'passer123'); 
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_RT']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Utilisateur crée avec succés!');

        return Command::SUCCESS;
    }
}