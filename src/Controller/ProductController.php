<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Service\ProductService;

require_once __DIR__ . '/../../vendor/php_wsdl/class.phpwsdl.php';

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    /**
     * @Route("/product/soap", name="product_soap")
     */
    public function soap() {
    \PhpWsdl::$UseProxyWsdl=true;
    \PhpWsdl::$EncodeProxyReturn=false;
    $soap = \PhpWsdl::CreateInstance(
      $this->generateUrl('product_soap', array(), false).'/',
      $this->generateUrl('product_soap', array(), false),
      null,//__DIR__. '/../../var/cache',
      Array(
        dirname(__FILE__). '/../Service/ProductService.php',
        dirname(__FILE__). '/../Entity/Product.php',
      ),
      'ProductService',
      null,
      \App\Service\ProductService::__getcomplex(),
      true,
      false
    );
    $soap->ParseDocs=false;
    $soap->IncludeDocs=false;

    if($soap->IsWsdlRequested()){
      $soap->Optimize=false;
    }
    $soap->SoapServerOptions['soap_version']=SOAP_1_2;
    $soap->RunServer(null, Array('App\Service\ProductService',new ProductService($this->getDoctrine())));
    }



}
