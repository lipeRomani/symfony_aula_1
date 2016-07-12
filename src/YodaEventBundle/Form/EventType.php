<?php

namespace YodaEventBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('time', DateTimeType::class,[
            ])
            ->add('location',TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('details',TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'YodaEventBundle\Entity\Event'
        ));
    }
}
