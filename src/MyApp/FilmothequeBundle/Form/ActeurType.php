<?php

namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ActeurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('attr' => array('class' => "form-control",)))
            ->add('prenom',TextType::class,array('attr' => array('class' => "form-control",)))
            ->add('dateNaissance',BirthdayType::class,array('attr' => array('class' => "datepicker form-control",)))
            ->add('sexe',ChoiceType::class,array('choices' => array('Féminin'=>'Féminin','Masculin'=>'Masculin'),'attr' => array('class' => "form-control",)))
            ->add('submit',SubmitType::class,array('attr' => array('class'=>"btn btn-simple btn-primary btn-lg",)))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\FilmothequeBundle\Entity\Acteur'
        ));
    }
}
