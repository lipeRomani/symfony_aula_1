<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 11/07/16
 * Time: 11:48
 */

namespace YodaEventBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{

    /**
     * @Route("/events/report/recentlyUpdated.csv",name="report_csv")
     */
    public function updatedEventsAction(){
        $events = $this->getDoctrine()
            ->getRepository('YodaEventBundle:Event')
            ->getRecentlyUpdatedEvent();

        $rows = [];
        foreach($events as $event){
            $data = [$event->getId(), $event->getName(), $event->getTime()->format('Y-m-d H:i:s')];
            $rows[] = implode(',',$data);
        }

        $content = implode("\n",$rows);

        return new Response($content,200,['Content-Type' =>"text/csv"]);

    }
}