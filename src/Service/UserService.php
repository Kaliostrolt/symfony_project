<?php

namespace App\Service;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $email
     * @param string $passwd
     * @throws \Exception
     */
    public function createAdmin(string $email, string  $passwd)
    {
        $entityManager = $this->entityManager;
        $rolesReposiroty = $this->entityManager->getRepository(Role::class);

        /** @var Role $adminRole */
        $adminRole = $rolesReposiroty->findOneBy(['name' => 'admin']);

        $admin = (new User())
            ->setRoles($adminRole)
            ->setEmail($email)
            ->setPassword($passwd)
            ->setData();
        $entityManager->persist($admin);
        $entityManager->flush();
    }
}
