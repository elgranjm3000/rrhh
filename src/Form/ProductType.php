<?php
namespace App\Form;


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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProductType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder        
            ->add('name', TextType::class)
            ->add('price', MoneyType::class, array(
                  'divisor' => 1,
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array('class' => 'tinymce'),
            ))
         
             ->add('image', FileType::class,array("data_class" => null))
        ;


      
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class,
        ));
    }
}