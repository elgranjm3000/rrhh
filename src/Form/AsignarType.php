<?php
namespace App\Form;


use App\Entity\Asignar;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class AsignarType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add('usuarioasignado')
            ->add('materialasignado') 
            ->add('idusuario', HiddenType::class)
            ->add('idmaterial', HiddenType::class)     


            
        ;


      
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Asignar::class,
        ));
    }
}