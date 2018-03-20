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
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Asignar;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

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
            'number' => $number,'idcampo'=>1
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
      return $this->render('lucky/nosotros.html.twig',array('idcampo'=>2));
    }

     /**
      * @Route("/informacion", name="informacion")
    */
    public function informacion()
    {
      return $this->render('lucky/informacion.html.twig',array('idcampo'=>3));
    }

    /**
      * @Route("/servicios", name="servicios")
    */
    public function servicios()
    {

      $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
      return $this->render('lucky/servicios.html.twig',array('productos'=>$product,'idcampo'=>4));
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
            'form' => $form->createView(),'idcampo'=>5
        ));
    }


    /**
     * @Route("/administrator/admin", name="admin")
     */
    public function admin(AuthorizationCheckerInterface $authChecker)
    {
      //$session = $request->getRoles();
 if ($authChecker->isGranted('ROLE_CLIENTES')) {
        
            return $this->redirectToRoute('servicios');
  
    }
  if ($authChecker->isGranted('ROLE_ADMIN')) {
        
            //return $this->render('admin/index.html.twig');
            return $this->redirectToRoute('material_listado');
            
        }
    }


     /**
     * @Route("/olvido", name="forgot_password")
     */
    public function olvido()
    {
        return new Response('<html><body>olvido clave ?</body></html>');
    }


   /**
      * @Route("/mimaterial", name="mimaterial")
    */
    public function mimaterialAction(Request $request)
    {

      $idudusarios = $this->getUser();




      $asignar = $this->getDoctrine()
        ->getRepository(Asignar::class)
        ->findBy(['idusuario' => $this->getUser()]);
        
        if(!$asignar){
            $this->addFlash(
            'notice',
            'NO TIENE MATERIAL ASIGNADO.'
        );
        }
        
      return $this->render('lucky/mimaterial.html.twig',array('productos'=>$asignar,'idcampo'=>7));

    }
    
    
    
    /**
      * @Route("/miperfil", name="miperfil")
    */
    public function miperfilAction(Request $request)
    {
        
         $em = $this->getDoctrine();
         
           if(!$this->getUser()){
                    return $this->redirectToRoute('login');

        }

        $entity = $em->getRepository(User::class)->find($this->getUser());

       
        if(!$entity){
                    return $this->redirectToRoute('login');

        }
        
       $form = $this->createFormBuilder($entity)
       ->setAction($this->generateUrl('miperfil'))
    ->setMethod('POST')
           ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('save', SubmitType::class, array('label' => 'Modificar'))
            ->getForm();

            $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        
        
        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $em = $this->getDoctrine()->getManager();
         $em->persist($entity);
         $em->flush();
       
         $this->addFlash(
            'notice',
            'TUS DATOS FUERON MODIFICADOS'
        );

        return $this->redirectToRoute('miperfil');
    }


      return $this->render('lucky/perfil.html.twig', array(
            'form' => $form->createView(),'idcampo'=>6
        ));
    }
    

}