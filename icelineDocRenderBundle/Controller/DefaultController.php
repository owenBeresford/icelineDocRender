<?php

namespace icelineLtd\icelineDocRenderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('icelineLtdicelineDocRenderBundle:Default:index.html.twig');
    }
}
