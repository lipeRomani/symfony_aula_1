<?php

namespace UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
            $user->setPassword($this->encodePassword($user,$user->getPlainPassword()));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return ['form' => $form->createView()];
    }

    private function encodePassword(User $user, $plainPassword){

        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

}