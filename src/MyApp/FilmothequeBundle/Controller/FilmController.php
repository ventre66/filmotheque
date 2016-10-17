<?php

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\FilmothequeBundle\Entity\Film;
use MyApp\FilmothequeBundle\Form\FilmType;
use MyApp\FilmothequeBundle\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;

class FilmController extends Controller
{

		    public function listerAction()
		    {


			$em = $this->getDoctrine()->getManager();

				$films= $em->getRepository('MyAppFilmothequeBundle:Film')->findAll();

				return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Film:lister.html.twig',
				array(
				'films' => $films,


			 	));
		    }

		        public function listerUniqueAction($id)
		        {
		    	$em = $this->getDoctrine()->getManager();

		    		$films= $em->getRepository('MyAppFilmothequeBundle:Film')->find($id);
		    		// $images=$em->getRepository('MyAppFilmothequeBundle:Image')->find($id);
		    		// dump($films);


		    		return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Film:listerunique.html.twig',
		    		array(
		    		'films' => $films,
		    		// 'images'=> $images

		    	 	));
		        }


	    public function ajouterAction(Request $request)
	    {
		$film = new Film();
		  $form = $this->createForm(FilmType::class, $film);



		    if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
		        $em = $this->getDoctrine()->getManager();
		        $em->persist($film);
		        $em->flush();
		        $this->addFlash('info','Success!!!');

		    }

		  return $this->render(
		'MyAppFilmothequeBundle:Film:ajouter.html.twig',
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
	    			$film = $em->find('MyAppFilmothequeBundle:Film', $id);

	    			if (!$film)
	    			{
	    				$this->addFlash('info','Aucun film trouvé');
	    			}
	    		}
	    		else
	    		{
	    			// ajout d'un nouvel acteur
	    			$film = new Film();
	    		}

	    		$form = $this->createForm(FilmType::class, $film);


	    		if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
	    			$em->persist($film);
	    			$em->flush();
	    			if (isset($id))
	    			{
	    				$this->addFlash('info','film modifié avec succès !');
	    			}
	    			else
	    			{
	    				$this->addFlash('info','film ajouté avec succès !');
	    			}
	    		}
	    			return $this->container->get('templating')->renderResponse(
	    		'MyAppFilmothequeBundle:Film:modifier.html.twig',
	    			array(
	    			'form' => $form->createView(),
	    			'message' => $message,
	    			));
			}
			    public function supprimerAction($id)
			    {
				$em = $this->getDoctrine()->getManager();
				  $film = $em->find('MyAppFilmothequeBundle:Film', $id);

				  if (!$film)
				  {
				    throw new NotFoundHttpException("Film non trouvé");
				  }

				  $em->remove($film);
				  $em->flush();


				  return $this->redirect($this->generateUrl('myapp_film_lister'));
			    }
}
