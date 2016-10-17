<?php

namespace MyApp\FilmothequeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use MyApp\FilmothequeBundle\Entity\Image;
use MyApp\FilmothequeBundle\Entity\Video;


class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,array('attr' => array('class' => "form-control",)))
            ->add('description',TextareaType::class,array('attr' => array('class' => "form-control",)))
            ->add('images',CollectionType::class,array(
                'entry_type'=> ImageType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'data'=>array(new Image()),
                'required'=>false,))
            ->add('video',CollectionType::class,array('entry_type'=>VideoType::class,'label'=>false,'allow_add'=>true,
                'allow_delete'=>true,
                'data'=>array(new Video()),
                'required'=>false,))
            ->add('categorie',EntityType::class,array(
                'class'=>'MyAppFilmothequeBundle:Categorie',
                'choice_label'=>'nom',
                'multiple'=>false,'attr' => array('class' => "form-control")))
             ->add('acteurs',EntityType::class,array(
                'class'=>'MyAppFilmothequeBundle:Acteur',
                'choice_label'=>'Full',
                'multiple'=>true,'attr' => array('class' => "form-control")))
            ->add('submit',SubmitType::class,array('attr' => array('class'=>"btn btn-simple btn-primary btn-lg",)))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\FilmothequeBundle\Entity\Film'
        ));
    }
}
