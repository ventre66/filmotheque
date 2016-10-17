<?php

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\FilmothequeBundle\Entity\Categorie;
use MyApp\FilmothequeBundle\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
		    public function listerAction()
		    {
			$em = $this->getDoctrine()->getManager();

				$categories= $em->getRepository('MyAppFilmothequeBundle:Categorie')->findAll();

				return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Categorie:lister.html.twig',
				array(
				'categories' => $categories
			 	));
		    }

	    public function ajouterAction(Request $request)
	    {
		$categorie = new Categorie();
		  $form = $this->createForm(CategorieType::class, $categorie);



		    if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
		        $em = $this->getDoctrine()->getManager();
		        $em->persist($categorie);
		        $em->flush();
		        $this->addFlash('info','Success!!!');

		    }

		  return $this->render(
		'MyAppFilmothequeBundle:Categorie:ajouter.html.twig',
		  array(
		    'form' => $form->createView(),
		    'message' => ''
		  ));
	    }

	            public function modifierAction(Request $request,$id)
	            {
	        	$message='';
	        		$em = $this->getDoctrine()->getManager();

	        		if (isset($id))
	        		{
	        			// modification d'un acteur existant : on recherche ses données
	        			$categorie = $em->find('MyAppFilmothequeBundle:Categorie', $id);

	        			if (!$categorie)
	        			{
	        				$this->addFlash('info','Aucune categorie trouvé');
	        			}
	        		}
	        		else
	        		{
	        			// ajout d'un nouvel acteur
	        			$categorie = new Categorie();
	        		}

	        		$form = $this->createForm(CategorieType::class, $categorie);


	        		if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
	        			$em->persist($categorie);
	        			$em->flush();
	        			if (isset($id))
	        			{
	        				$this->addFlash('info','categorie modifié avec succès !');
	        			}
	        			else
	        			{
	        				$this->addFlash('info','categorie ajouté avec succès !');
	        			}
	        		}
	        			return $this->container->get('templating')->renderResponse(
	        		'MyAppFilmothequeBundle:Categorie:modifier.html.twig',
	        			array(
	        			'form' => $form->createView(),
	        			'message' => $message,
	        			));
	    		}

	    		    public function supprimerAction($id)
	    		    {
	    			$em = $this->getDoctrine()->getManager();
	    			  $categorie = $em->find('MyAppFilmothequeBundle:Categorie', $id);

	    			  if (!$categorie)
	    			  {
	    			    throw new NotFoundHttpException("Categorie non trouvé");
	    			  }

	    			  $em->remove($categorie);
	    			  $em->flush();


	    			 return $this->redirect($this->generateUrl('myapp_categorie_lister'));
	    		    }
}
