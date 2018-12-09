<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use App\Repository\ProductRepository;

require_once __DIR__ . '/../../vendor/php_wsdl/class.phpwsdl.php';

class ProductStatusMsg {
  public $code=200;
  public $message='OK';
  public function __construct($code=200, $message='OK'){
    $this->code = $code;
    $this->message = $message;    
  }
}
class ProductOut {
  public $product = null;
  public $status = null;
  public function __construct($product, $status=null){
    $this->product = $product;
    $this->status = $status;
  }
}
class ProductListOut {
  public $product = Array();
  public $status;
  public function __construct($product, $status=null){
    $this->product = $product;
    $this->status = $status;
  }
}

class ProductService {
private $doctrine;
public function __construct(Registry $doctrine){
  $this->doctrine = $doctrine;
}
 
public function __getcomplex(){
  return Array(
        new \PhpWsdlComplex('Product', Array(
        new \PhpWsdlElement('id',                 'int',              Array('nillable'=>'false','minoccurs'=>'0', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('name',               'string',           Array('nillable'=>'false','minoccurs'=>'0', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('manufacturer',       'string',           Array('nillable'=>'true', 'minoccurs'=>'1', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('country',            'string',           Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('price',              'float',            Array('nillable'=>'false','minoccurs'=>'1', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('expiration',         'dateTime',         Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'1')),
        new \PhpWsdlElement('section',            'int',              Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'1')),        
        )),
        new \PhpWsdlComplex('ProductStatusMsg',  Array(
          new \PhpWsdlElement('code',             'int',              Array('nillable'=>'false','minoccurs'=>'1', 'maxoccurs'=>'1')),
          new \PhpWsdlElement('message',          'string',           Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'1')),
        )),
        new \PhpWsdlComplex('ProductOut',        Array(
          new \PhpWsdlElement('product',          'Product',          Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'1')),
          new \PhpWsdlElement('status',           'ProductStatusMsg', Array('nillable'=>'false','minoccurs'=>'1', 'maxoccurs'=>'1')),
        )),
        new \PhpWsdlComplex('ProductListOut',    Array(
          new \PhpWsdlElement('product',          'Product',          Array('nillable'=>'true', 'minoccurs'=>'0', 'maxoccurs'=>'unbounded')),
          new \PhpWsdlElement('status',           'ProductStatusMsg', Array('nillable'=>'false','minoccurs'=>'1', 'maxoccurs'=>'1')),
        )),
      );
}
  
/**
* @param int $id
* @return ProductOut The object
*/
  public function product_get($id) {
    $msg = null;
    $product =  $this->doctrine->getRepository(Product::class)->find($id);
    if (!$product) {
      return new ProductOut(null, new ProductStatusMsg(401, 'No product found for id '.$id));
    }
    $product = $product->setSectionid($product->getSection());
    return new ProductOut($product, new ProductStatusMsg());
  }
/**
* @return ProductListOut
*/
  public function product_list() {
    $product = $this->doctrine->getRepository(Product::class)->findAll();
    if (!$product) {
      return new ProductListOut(null, new ProductStatusMsg(401, 'No products found'));
    }
    foreach($product as $p){
      $p = $p->setSectionid($p->getSection());
    }
    return new ProductListOut($product, new ProductStatusMsg());    
  }
  
}
