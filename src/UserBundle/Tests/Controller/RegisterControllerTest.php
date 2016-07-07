<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 07/07/16
 * Time: 15:41
 */

namespace UserBundle\Tests\Controller;




use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegister(){
        $client = static::createClient();

        $crawler = $client->request('GET','/register');
        $response = $client->getResponse();

        $usernameVal = $crawler->filter('#user_register_username')
            ->attr('value');

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertContains('Register',$response->getContent());
        $this->assertEquals('Leia',$usernameVal);
    }

    public function testUserBlankRegister(){

        $client = static::createClient();
        $crawler = $client->request('GET','/register');
        $form = $crawler->selectButton('Registrar')->form();

        $crawler = $client->submit($form);

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertRegExp('/Email não pode ser deixao em branco/',$client->getResponse()->getContent());
    }

    public function testUserRegisterAllInformation(){
        $client  = static::createClient();

        $crawler = $client->request('GET','/register');
        $form = $crawler->selectButton('Registrar')->form();
        $form['user_register[username]'] = 'user6';
        $form['user_register[email]'] = 'user6@user.com';
        $form['user_register[plainPassword][first]'] = 'C1c';
        $form['user_register[plainPassword][second]'] = 'C1c';

        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains('Welcome to the Death Star',$client->getResponse()->getContent());

    }
}