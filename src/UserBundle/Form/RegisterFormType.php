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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function getBlockPrefix(){
        return 'user_register';
    }

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('username',TextType::class)
            ->add('email',EmailType::class)
            ->add('plainPassword',RepeatedType::class,[
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'form-control']]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view['email']->vars['help'] = "Email tamem poderá ser utilizado para login.";
    }


}