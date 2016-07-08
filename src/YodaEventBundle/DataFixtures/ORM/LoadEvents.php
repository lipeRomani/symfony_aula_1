<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 06/07/16
 * Time: 15:03
 */

namespace YodaEventBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use YodaEventBundle\Entity\Event;

class LoadEvents implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Darth\'s Birthday Party!');
        $event1->setLocation('Deathstar');
        $event1->setTime(new \DateTime('tomorrow noon'));
        $event1->setDetails('Ha! Darth HATES surprises!!!');
        $event1->setOwner($this->getOwner($manager));
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('Rebellion Fundraiser Bake Sale!');
        $event2->setLocation('Endor');
        $event2->setTime(new \DateTime('Thursday noon'));
        $event2->setDetails('Ewok pies! Support the rebellion!');
        $event2->setOwner($this->getOwner($manager));
        $manager->persist($event2);

        $manager->flush();
    }

    private function getOwner(ObjectManager $manager){
        return $manager->getRepository('UserBundle:User')
            ->findByUsernameOrEmail('bar');
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
};