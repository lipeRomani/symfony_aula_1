<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use YodaEventBundle\Entity\Event;


/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__.'/app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request',$request);

/*
$event = new Event();
$event->setName("Darth birthday 3");
$event->setLocation("deathstar");
$event->setTime(new \DateTime('tomorrow noon'));
$event->setDetails("Vaders party, awsome");

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();
*/

$em = $container->get('doctrine')->getManager();

$user = $em->getRepository('UserBundle:User')
    ->findByUsernameOrEmail("bar");

$user->setPlainPassword('123');
$em->persist($user);
$em->flush();


