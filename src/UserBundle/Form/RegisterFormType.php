<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 07/07/16
 * Time: 14:15
 */

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function getBlockPrefix(){
        return 'user_register';
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('username',TextType::class,[
                'attr' => ['class'=>'form-control']
            ])
            ->add('email',EmailType::class,[
                'required' => false,
                'label' => 'Email address',
                'attr' => ['class' => 'form-control']
            ])
            ->add('plainPassword',RepeatedType::class,[
                'type' => PasswordType::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }


}