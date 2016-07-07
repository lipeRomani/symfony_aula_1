<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 07/07/16
 * Time: 14:15
 */

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function getName(){
        return 'user_register';
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('username','text',[
                'attr' => ['class'=>'form-control']
            ])
            ->add('email','email',[
                'required' => false,
                'label' => 'Email address',
                'attr' => ['class' => 'form-control']
            ])
            ->add('plainPassword','repeated',[
                'type' => 'password',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }


}