<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 08/07/16
 * Time: 14:57
 */

namespace YodaEventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use YodaEventBundle\Entity\Event;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Controller extends BaseController
{
    /**
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    public function getAuthorizationChecker(){
        return $this->get('security.authorization_checker');
    }

    /**
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage     *
     */
    public function getTokenStorage(){
        return $this->get('security.token_storage');
    }

    public function eventOwnerSecurity(Event $event){
        $user = $this->getUser();

        if($user != $event->getOwner()){
            throw new AccessDeniedException("Vc não é o proprietário desse evento");
        }
    }
}