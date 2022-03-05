<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) : void
    {
        $user1 = new User();
        $user1->setEmail("admin@gmail.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordEncoder->encodePassword($user1, 'test'));

        $user2 = new User();
        $user2->setEmail("laubert@gmail.com")
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->passwordEncoder->encodePassword($user1, 'mdplaubert'));

        $user3 = new User();
        $user3->setEmail("mboglet@gmail.com")
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->passwordEncoder->encodePassword($user1, 'mdpmboglet'));



        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);


        $manager->flush();

        $this->addReference('user-admin', $user1);
        $this->addReference('user-laubert', $user2);
        $this->addReference('user-mboglet', $user3);


    }
}
