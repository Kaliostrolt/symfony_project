<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
     /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $encoder;
    private $faker;

    /**
     * @param EntityManagerInterface $entityManager
     * @param userPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, userPasswordEncoderInterface $encoder)
    {
        $this->faker = Factory::create();
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public static function getGroups(): array
    {
         return ['createUserManager'];
    }

    public function load(ObjectManager $entityManager)
    {
        $entityManager = $this->entityManager;
        $rolesReposiroty = $this->entityManager->getRepository(Role::class);

        /** @var Role $userRole */
        $nameRole = $rolesReposiroty->findOneBy(['name' => 'user']);
        $passwd = $this->faker->password;
        $email = $this->faker->email;
        $user = (new User())
            ->setRoles($nameRole)
            ->setEmail($email)
            ->setData();
        $password = $this->encoder->encodePassword($user, $passwd);
        $user->setPassword($password);
        $entityManager->persist($user);

        /** @var Role $managerRole */
        $nameRole = $rolesReposiroty->findOneBy(['name' => 'manager']);
        $passwd = $this->faker->password;
        $email = $this->faker->email;
        $user = (new User())
            ->setRoles($nameRole)
            ->setEmail($email)
            ->setData();
        $password = $this->encoder->encodePassword($user, $passwd);
        $user->setPassword($password);
        $entityManager->persist($user);
        $entityManager->flush();
    }
}
