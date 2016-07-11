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
use YodaEventBundle\Reporting\EventReportManager;

class ReportController extends Controller
{

    /**
     * @Route("/events/report/recentlyUpdated.csv",name="report_csv")
     */
    public function updatedEventsAction(){

        $rm = $this->get('event_report_manager');
        $content = $rm->getRecentlyUpdatedReport();
        return new Response($content,200,['Content-Type' =>"text/csv"]);

    }
}