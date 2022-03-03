<?php
namespace App\DataFixtures;

use App\Entity\Crypto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TuteurFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager) : void
    {
        $crypto1 = new Crypto();
        $crypto1->setNom("Bitcoin")
            ->setSymbole("BTC")
            ->setDateCreation(new \DateTime('-4807 days'))
            ->setCreateur("Satoshi Nakamoto")
            ->setMinable("Oui");

        $crypto2 = new Crypto();
        $crypto2->setNom("Ethereum")
            ->setSymbole("ETH")
            ->setDateCreation(new \DateTime('-2408 days'))
            ->setCreateur("Vitalik Buterin")
            ->setMinable("Oui");

        $crypto3 = new Crypto();
        $crypto3->setNom("Ripple")
            ->setSymbole("XRP")
            ->setDateCreation(new \DateTime('-3714 days'))
            ->setCreateur("Arthur Britto")
            ->setMinable("Non");

        $crypto4 = new Crypto();
        $crypto4->setNom("Litecoin")
            ->setSymbole("LTC")
            ->setDateCreation(new \DateTime('-3889 days'))
            ->setCreateur("Charles Lee")
            ->setMinable("Oui");

        $crypto5 = new Crypto();
        $crypto5->setNom("Dash")
            ->setSymbole("DASH")
            ->setDateCreation(new \DateTime('-2966 days'))
            ->setCreateur("Evan Duffield")
            ->setMinable("Oui");


        $manager->persist($crypto1);
        $manager->persist($crypto2);
        $manager->persist($crypto3);
        $manager->persist($crypto4);
        $manager->persist($crypto5);

        $manager->flush();

        $this->addReference('crypto-Bitcoin', $crypto1);
        $this->addReference('crypto-Ethereum', $crypto2);
        $this->addReference('crypto-Ripple', $crypto3);
        $this->addReference('crypto-Litecoin', $crypto4);
        $this->addReference('crypto-Dash', $crypto5);


    }
}
