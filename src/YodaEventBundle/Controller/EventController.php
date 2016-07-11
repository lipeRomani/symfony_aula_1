<?php

namespace YodaEventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use YodaEventBundle\Entity\Event;
use YodaEventBundle\Form\EventType;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{

    /**
     * Lists all Event entities.
     * @Template()
     * @Route("/",name="event_index")
     */
    public function indexAction()
    {
        /*
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('YodaEventBundle:Event')->upcomingEvents();
        return ['events' => $events]; */
        return [];
    }

    /**
     * Creates a new Event entity.
     * @Route("/new",name="event_new")
     * @Security("has_role('ROLE_EVENT_CREATE')")
     */
    public function newAction(Request $request)
    {


        $event = new Event();
        $form = $this->createForm('YodaEventBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $event->setOwner($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('slug' => $event->getSlug()));
        }

        return $this->render('@YodaEvent/Event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     * @Route("/{slug}/show",name="event_show")
     */
    public function showAction($slug)
    {
        $event = $this->getDoctrine()
            ->getRepository("YodaEventBundle:Event")
            ->findOneBy(['slug' => $slug]);

        $deleteForm = $this->createDeleteForm($event);

        return $this->render('@YodaEvent/Event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function attendAction($id,$format){

        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository("YodaEventBundle:Event")
                    ->find($id);

        if(!$event) throw $this->createNotFoundException("Event not found for id " . $id);
        if(!$event->hasAttendee($this->getUser())){
            $event->getAttendees()->add($this->getUser());
            $em->persist($event);
            $em->flush();
        }

        return $this->createAttendingResponse($event,$format);
    }

    public function unattendAction($id,$format){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('YodaEventBundle:Event')->find($id);

        if(!$event)
            throw $this->createNotFoundException('Event not found for id ' . $id);

        if($event->hasAttendee($this->getUser()));
            $event->getAttendees()->removeElement($this->getUser());

        $em->persist($event);
        $em->flush();

       return $this->createAttendingResponse($event,$format);

    }

    /**
     * Displays a form to edit an existing Event entity.
     * @Route("/{id}/edit",name="event_edit",methods={"GET","POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Event $event)
    {
        $this->eventOwnerSecurity($event);

        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('YodaEventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('@YodaEvent/Event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     * @Route("/{id}/delete",name="event_delete",methods={"DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function enforceUserSecurity($role = 'ROLE_USER'){

        if(!$this->getAuthorizationChecker()->isGranted($role))
            throw new AccessDeniedException('Need ' . $role);
    }

    /**
     * @param Event $event
     * @param $format
     * @return Response
     */
    private function createAttendingResponse(Event $event, $format){

        $data = ['attending' => $event->hasAttendee($this->getUser())];

        if($format == 'json')
            return new JsonResponse($data);
        else
            return $this->redirectToRoute('event_show',['slug' => $event->getSlug()]);

    }

    public function _upcomingEventsAction($max = null){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository("YodaEventBundle:Event")
                    ->upcomingEvents($max);

        return $this->render('@YodaEvent/Event/_upcomingEvents.html.twig',['events' => $events]);
    }
}
