<?php

namespace UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use YodaEventBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Form\RegisterFormType;

class RegisterController extends Controller
{
    /**
     * @Route("/register",name="user_register")
     * @Template()
     */
    public function registerAction(Request $request){

        $user = new User();
        $user->setUsername('Leia');

        $form = $this->createForm(new RegisterFormType(),$user);

        $form->handleRequest($request);

        //o is valid ja retorna false caso o submit nao tenha sido post, o isSubmitted esta ai para fins de estudo
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $user->setRoles(['ROLE_ADMIN']);
            $user->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->authenticateUser($user);
            $this->addFlash('notice','Welcome to the Death Star');
            return $this->redirectToRoute('event_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @param User $user
     * @Route("/user/{id}")
     */
    public function showAction(User $user){

    }

    private function authenticateUser(User $user){

        //firewall name inside app/config/security.yml
        $providerkey = 'secured_area';

        $token = new UsernamePasswordToken($user,null,$providerkey,$user->getRoles());
        $this->getTokenStorage()->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));

    }

}