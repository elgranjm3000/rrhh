<?php
namespace App\Controller;

use App\Form\ProductType;
use App\Form\UserType;
use App\Entity\User;
use App\Entity\Product;
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
     * @Route("/material", name="material_add")
     */

      
    public function materialaddAction(Request $request)
    {

        $material = new Product();
        $form = $this->createForm(ProductType::class, $material);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

              $file = $form['image']->getData();
            
              $foto_type = $file->guessExtension();
              $foto_ext = $file->getMimeType();              
              $foto_name = $file->getClientOriginalName();
              $foto_size = $file->getClientSize();
              $foto_temporal = $file;
              //$f1= fopen($foto_temporal,"rb");      
              //$foto_reconvertida = fread($f1, $foto_size);

              $stream = fopen($material->getImage(),'rb');

              $material->setImage(stream_get_contents($stream));
              $material->setTamano($foto_size);
              $material->setFormato($foto_ext); 

              $em = $this->getDoctrine()->getManager();
              $em->persist($material);
              $em->flush();
             return $this->redirectToRoute('material_add');
        }


        return $this->render(
            'admin/materialadd.html.twig',
            array('form' => $form->createView())
        );

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

}