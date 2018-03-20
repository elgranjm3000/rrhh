<?php
namespace App\Controller;

use App\Form\ProductType;
use App\Form\AsignarType;
use App\Form\UserType;
use App\Form\UsercrearType;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Asignar;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\DBAL\Types\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;




class AdminController extends Controller
{
	

    /**
     * @Route("/registrar", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_registration');
        }

        return $this->render(
            'admin/registrar.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/registrarfront", name="user_registrarfront")
     */
    public function registerfrontAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

      $possibleRoles = array(
        'ADMINISTRADOR' => 'ROLE_ADMIN',
        'USUARIOS'  => 'ROLE_USER',
        'CLIENTES' => 'ROL_CLIENTES'
    );
      
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UsercrearType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(array($possibleRoles['CLIENTES']));

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_registrarfront');
        }

        return $this->render(
            'lucky/registrar.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/material", name="material_add")
     */

      
    public function materialaddAction(Request $request)
    {

        $material = new Product();
        $form = $this->createForm(ProductType::class, $material);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

              $filearchivo = $form['image']->getData();
              $file = $material->getImage();

            
              $foto_type = $filearchivo->guessExtension();
              $foto_ext = $filearchivo->getMimeType();              
              $foto_name = $filearchivo->getClientOriginalName();
              $foto_size = $filearchivo->getClientSize();
            //  $foto_temporal = $file;
              //$f1= fopen($foto_temporal,"rb");      
              //$foto_reconvertida = fread($f1, $foto_size);

//              $stream = fopen($material->getImage(),'rb');
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

  $file->move($this->getParameter('brochures_directory'),
                $fileName
            );

              //$material->setImage(stream_get_contents($stream));
              $material->setImage($fileName);
              $material->setTamano($foto_size);
              $material->setFormato($foto_ext); 

              $em = $this->getDoctrine()->getManager();
              $em->persist($material);
              $em->flush();

               $this->addFlash(
            'notice',
            'Archivos guardados con exito'
        );
             return $this->redirectToRoute('material_listado');
        }
 

        return $this->render(
            'admin/materialadd.html.twig',
            array('form' => $form->createView())
        );

    }
    
    
      /**
     * @Route("/material/{id}/edit", name="material_edit")
     * @Method({"GET", "POST"})
     */

      
    public function materialeditAction(Request $request,$id)
    {

          $em = $this->getDoctrine();

        $entity = $em->getRepository(Product::class)->find($id);

        //$material = new Product();
        $form = $this->createForm(\App\Form\ProductType::class, $entity);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
                      
        
         $filearchivo = $form['image']->getData();
              $file = $entity->getImage();

            
              $foto_type = $filearchivo->guessExtension();
              $foto_ext = $filearchivo->getMimeType();              
              $foto_name = $filearchivo->getClientOriginalName();
              $foto_size = $filearchivo->getClientSize();
            //  $foto_temporal = $file;
              //$f1= fopen($foto_temporal,"rb");      
              //$foto_reconvertida = fread($f1, $foto_size);

//              $stream = fopen($material->getImage(),'rb');
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

  $file->move($this->getParameter('brochures_directory'),
                $fileName
            );

              //$material->setImage(stream_get_contents($stream));
              $entity->setImage($fileName);
              $entity->setTamano($foto_size);
              $entity->setFormato($foto_ext); 

              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();

               $this->addFlash(
            'notice',
            'Archivos actualizado con exito'
        );
             return $this->redirectToRoute('material_listado');
        }
 

        return $this->render(
            'admin/materialaedit.html.twig',
            array('form' => $form->createView())
        );

    }


    /**
     * @Route("material/index", name="material_listado")
     */

      
    public function materialindexAction(Request $request)
    {
         $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
        
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
        
      return $this->render('material/index.html.twig',array('productos'=>$product,'user'=>$user));
    }


   /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
 * @Route("/material/{id}", name="product_show")
 */
public function showAction($id)
{
    $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

    if (!$product) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }



$file = $product->getImage();
$response = new \Symfony\Component\HttpFoundation\Response(stream_get_contents($file), 200, array(
        'Content-Type' => $product->getFormato(),
        'Content-Length' => $product->getTamano(),
        'Content-Disposition' => 'attachment; filename="'.$product->getName().'"',
));

return $response;



   // return new Response('Check out this great product: '.$product->getName());

    // or render a template
    // in the template, print things with {{ product.name }}
    // return $this->render('product/show.html.twig', ['product' => $product]);
}



/**
 * @Route("/material/delete/{id}",name="material_delete")
 */
public function deletematerialAction(Request $request,$id)
{
   
    
       $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository(Product::class)->find($id);
      

    if (!$entity) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }

    //$product->setName('New product name!');
    $em->remove($entity);
    $em->flush();

   
    $this->addFlash(
            'notice',
            'Archivos Eliminado'
    );
    return $this->redirectToRoute('material_listado');
}


 /**
 * @Route("/pagar/{id}", name="pagar_now")
 */
public function paypalAction($id)
{
   
 $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

    if (!$product) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }


  $paypal_business = "softreligion@gmail.com";
  $paypal_currency = "USD";
  $paypal_cursymbol = "&usd";
  $paypal_location = "MX";
  $paypal_returnurl = "http://localhost/paypal-ex1/done.php";
  $paypal_returntxt = "Pago Realizado Exitosamente!";
  $paypal_cancelurl = "http://localhost/paypal-ex1/cancel.php";

  
  $ppurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_cart";
  $ppurl .= "&business=".$paypal_business;
  $ppurl .= "&no_note=1";
  $ppurl .= "&currency_code=".$paypal_currency;
  $ppurl .= "&charset=utf-8&rm=1&upload=1";
  $ppurl .= "&business=".$paypal_business;
  $ppurl .= "&return=".urlencode($paypal_returnurl);
  $ppurl .= "&cancel_return=".urlencode($paypal_cancelurl);
  $ppurl .= "&page_style=&paymentaction=sale&bn=katanapro_cart&invoice=KP-";
//  echo $ppurl;
  $i=1;




  $q = 1;
  $valor = $product->getPrice();
  $producto = $product->getName();
    $ppurl.="&item_name_$i=".urlencode($producto)."&quantity_$i=$q&amount_$i=".$valor."&item_number_$i=";

  $ppurl.= "&tax_cart=0.00";


header("Location: $ppurl");

 exit;
}


/**
 * @Route("/asignar", name="asignar_now")
 */
public function asignarAction(Request $request)
{
      // 1) build the form
        $asignar = new Asignar();
        $form = $this->createForm(AsignarType::class, $asignar);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($asignar);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('asignar_now');
        }

        return $this->render(
            'asignar/save.html.twig',
            array('form' => $form->createView())
        );
}


/**
 * @Route("/asignar/now", name="asignar_now")
 */

 public function datosAction(Request $request){
                        $ip=$this->getDoctrine()->getEntityManager();  

         $idmaterial = $request->request->get('idmaterial');
         $idusuario = $request->request->get('idusuario');
         $id = 16;
         
          $material = new Asignar();
          $material->setUsuarioasignado($ip->getReference(User::class,$idusuario));
          $material->setMaterialasignado($ip->getReference(Product::class,$idmaterial));
         $em = $this->getDoctrine()->getManager();
            $em->persist($material);
            $em->flush();
                                     
        //sleep(2);
        
              exit;
            //return new JsonResponse($generardatos);
    }
    

/**
     * @Route("usuarios/", name="usuarios_listado")
     */

      
    public function usuariosindexAction(Request $request)
    {
         
        
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
        
      return $this->render('usuarios/index.html.twig',array('user'=>$user));
    }
    
    
    
     /**
     * @Route("/usuarios/{id}/edit", name="usuarios_edit")
     * @Method({"GET", "POST"})
     */

      
    public function usuarioseditAction(Request $request,$id)
    {

          $em = $this->getDoctrine();

        $entity = $em->getRepository(User::class)->find($id);

        //$material = new Product();
        $form = $this->createForm(\App\Form\UserType::class, $entity);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();

               $this->addFlash(
            'notice',
            'Archivos actualizado con exito'
        );
             return $this->redirectToRoute('usuarios_listado');
        }
 

        return $this->render(
            'usuarios/edit.html.twig',
            array('form' => $form->createView())
        );

    }
    
    
    /**
 * @Route("/usuarios/delete/{id}",name="usuarios_delete")
 */
public function deleteusuarioslAction(Request $request,$id)
{
   
    
       $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository(User::class)->find($id);
      

    if (!$entity) {
        throw $this->createNotFoundException(
            'USUARIOS NO ENCONTRADO '.$id
        );
    }

    //$product->setName('New product name!');
    $em->remove($entity);
    $em->flush();

   
    $this->addFlash(
            'notice',
            'Usuario Eliminado'
    );
    return $this->redirectToRoute('usuarios_listado');
}
    

}