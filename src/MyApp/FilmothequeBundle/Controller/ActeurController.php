<?php

namespace MyApp\FilmothequeBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\FilmothequeBundle\Entity\Acteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\FilmothequeBundle\Form\ActeurType;
use Symfony\Component\HttpFoundation\Request;
use MyApp\FilmothequeBundle\Form\ActeurRechercheType;

class ActeurController extends Controller
{
    public function listerAction()
    {
    $form = $this->createForm(ActeurRechercheType::class);
	$em = $this->getDoctrine()->getManager();

		$acteurs= $em->getRepository('MyAppFilmothequeBundle:Acteur')->findAll();
		// dump($acteurs);
		// die();

		return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Acteur:lister.html.twig',
		array(
		'acteurs' => $acteurs,
		'form' => $form->createView()
	 	));
    }

        public function listerUniqueAction($id)
        {
    	$em = $this->getDoctrine()->getManager();

    		$acteurs= $em->getRepository('MyAppFilmothequeBundle:Acteur')->find($id);
    		// $images=$em->getRepository('MyAppFilmothequeBundle:Image')->find($id);
    		// dump($films);


    		return $this->container->get('templating')->renderResponse('MyAppFilmothequeBundle:Acteur:listerunique.html.twig',
    		array(
    		'acteurs' => $acteurs,
    		// 'images'=> $images

    	 	));
        }


    public function ajouterAction(Request $request)
    {
	$acteur = new Acteur();
	  $form = $this->createForm(ActeurType::class, $acteur);



	    if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
	        $em = $this->getDoctrine()->getManager();
	        $em->persist($acteur);
	        $em->flush();
	        $this->addFlash('info','Success!!!');

	    }

	  return $this->render(
	'MyAppFilmothequeBundle:Acteur:ajouter.html.twig',
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
			$acteur = $em->find('MyAppFilmothequeBundle:Acteur', $id);

			if (!$acteur)
			{
				$this->addFlash('info','Aucun acteur trouvé');
			}
		}
		else
		{
			// ajout d'un nouvel acteur
			$acteur = new Acteur();
		}

		$form = $this->createForm(ActeurType::class, $acteur);


		if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
			$em->persist($acteur);
			$em->flush();
			if (isset($id))
			{
				$this->addFlash('info','Acteur modifié avec succès !');
			}
			else
			{
				$this->addFlash('info','Acteur ajouté avec succès !');
			}
		}


		return $this->container->get('templating')->renderResponse(
	'MyAppFilmothequeBundle:Acteur:modifier.html.twig',
		array(
		'form' => $form->createView(),
		'message' => $message,
		));
    }

    public function supprimerAction($id)
    {
	$em = $this->getDoctrine()->getManager();
	  $acteur = $em->find('MyAppFilmothequeBundle:Acteur', $id);

	  if (!$acteur)
	  {
	    throw new NotFoundHttpException("Acteur non trouvé");
	  }

	  $em->remove($acteur);
	  $em->flush();


	 return $this->redirect($this->generateUrl('myapp_acteur_lister'));
    }

    public function rechercherAction(Request $request)
    {


        if($request->isXmlHttpRequest())
        {
            $motcle = '';
            $motcle = $request->get('motcle');


            $em = $this->container->get('doctrine')->getEntityManager();

            if($motcle != '')
            {
                   $qb = $em->createQueryBuilder();

                   $qb->select('a')
                      ->from('MyAppFilmothequeBundle:Acteur', 'a')
                      ->where("a.nom LIKE :motcle OR a.prenom LIKE :motcle")
                      ->orderBy('a.nom', 'ASC')
                      ->setParameter('motcle', '%'.$motcle.'%');

                   $query = $qb->getQuery();
                   $acteurs = $query->getResult();
            }
            else {
                $acteurs = $em->getRepository('MyAppFilmothequeBundle:Acteur')->findAll();
            }

            return $this->render('MyAppFilmothequeBundle:Acteur:liste.html.twig', array(
                'acteurs' => $acteurs
                ));
        }
        else {
            return $this->listerAction();

        }
    }
}