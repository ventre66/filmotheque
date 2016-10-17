<?php

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use MyApp\FilmothequeBundle\Entity\Categorie;

class DefaultController extends Controller
{
    public function layoutAction()
    {
    	$em = $this->container->get('doctrine')->getEntityManager();
    		$categories = $em->getRepository('MyAppFilmothequeBundle:Categorie')->findAll();

    		return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Default:layout.html.twig',array(
    			 'categories' => $categories)
    		);
    }
}
