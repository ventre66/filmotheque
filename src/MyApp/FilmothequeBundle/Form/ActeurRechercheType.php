<?php

namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActeurRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('motcle',TextType::class, array('label' => 'Mot-clé'))
        ->add('submit',SubmitType::class,array('attr' => array('class'=>"btn btn-simple btn-primary btn-lg",)))
        ;
    }

    public function getName()
    {
        return 'acteur_recherche';
    }
}