<?php

namespace YodaEventBundle\Twig;


use YodaEventBundle\Util\DateUtil;

class EventExtension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "event";
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ago',[$this, 'calculateAgo'])
        ];
    }

    /**
     * @param \DateTime $dt
     * @return string
     */
    public function calculateAgo(\DateTime $dt){
        return DateUtil::ago($dt);
    }


}