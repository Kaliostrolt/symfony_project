<?php

namespace App\Service;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $encoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param userPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, userPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
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
            ->setData();
        $password = $this->encoder->encodePassword($admin, $passwd);
        $admin->setPassword($password);
        $entityManager->persist($admin);
        $entityManager->flush();
    }
}
