<?php
namespace App\Form;


use App\Entity\Asignar;
use App\Entity\Product;
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
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





class AsignarType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add('usuarioasignado', EntityType::class, array(
                  'class' => User::class,
                   'choice_label' => 'email',
            ))
            ->add('materialasignado', EntityType::class, array(
                  'class' => Product::class,
                   'choice_label' => 'description',
            )) 
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