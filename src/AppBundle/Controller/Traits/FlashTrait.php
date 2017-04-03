<?php

namespace AppBundle\Controller\Traits;

trait FlashTrait
{
    /**
     * @param string $type
     * @param string $message
     * @param bool   $translate
     * @param array  $parameters
     * @param null   $translationDomain
     */
    public function addFlash($type, $message, $translate = true, array $parameters = [], $translationDomain = null)
    {
        if ($translate) {
            $message = $this->get('translator')->trans($message, $parameters, $translationDomain);
        }
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}
