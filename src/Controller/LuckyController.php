<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class LuckyController extends Controller
{
	/**
      * @Route("/", name="home")
   	*/
    public function number()
    {
        $number = mt_rand(0, 100);

        /*return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );*/
      return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }

    /**
      * @Route("/parametros/{slug}", name="parametros")
   	*/


   	public function parametros($slug)
    {
        

        return new Response(
            '<html><body>Tu nombre es: '.$slug.'</body></html>'
        );
      
    }

    /**
      * @Route("/nosotros", name="sobrenosotros")
    */
    public function nosotros()
    {
        $number = mt_rand(0, 100);

        /*return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );*/
      return $this->render('lucky/nosotros.html.twig');
    }

     /**
      * @Route("/informacion", name="informacion")
    */
    public function informacion()
    {
      return $this->render('lucky/informacion.html.twig');
    }

    /**
      * @Route("/servicios", name="servicios")
    */
    public function servicios()
    {
      return $this->render('lucky/servicios.html.twig');
    }

    /**
      * @Route("/contacto", name="contacto")
    */
    public function contacto(Request $request)
    {
       $form = $this->createFormBuilder()
            ->add('nombre', TextType::class)
            ->add('email', EmailType::class)
            ->add('asunto', TextType::class)
            ->add('mensaje', TextareaType::class, array(
    'attr' => array('class' => 'tinymce'),
))
            ->add('save', SubmitType::class, array('label' => 'Enviar'))
            ->getForm();

            $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $nombre  = $form["nombre"]->getData();
        $email   = $form["email"]->getData();
        $asunto  = $form["asunto"]->getData();
        $mensaje = $form["mensaje"]->getData();

        
        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($task);
        // $em->flush();
        mail('solucionesintegraleshumano@gmail.com', $asunto, $mensaje);
         $this->addFlash(
            'notice',
            'TU MENSAJE FUE ENVIADO, EN BREVE NOS COMUNICAREMOS CON USTED.'
        );

        return $this->redirectToRoute('contacto');
    }


      return $this->render('lucky/contacto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}