<?php

namespace UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername("bar")
            ->setPassword($this->encodePwd($user,"bar"))
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive(true)
            ->setEmail("bar@bar.com");

        $manager->persist($user);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function encodePwd(User $user, $plainPassword){

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($plainPassword,$user->getSalt());
    }
}