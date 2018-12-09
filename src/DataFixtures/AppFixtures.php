<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\Section;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cou = ['RU','CN','US','EU','UK',''];
        $man = ['Manufacturer1','Manufacturer2','Manufacturer3','Manufacturer4','Manufacturer5',''];
        foreach (range(1, 5) as $i) {
          $section = new Section();
          $section->setName('section-'.$i.'-0');
          $manager->persist($section);
          $this->addReference('section-'.$i.'-0', $section);
          foreach (range(1, 3) as $ii) {
            $section = new Section();
            $section->setName('section-'.$i.'-'.$ii);
            $section->setSection($this->getReference('section-'.$i.'-0'));
            $manager->persist($section);
            $this->addReference('section-'.$i.'-'.$ii, $section);
          }
          
        }
        $manager->flush();
        
        foreach (range(1, 20) as $i) {
          $product = new Product();
          $product->setName('product-'.$i);
          $product->setPrice(rand(1,1000));
          $product->setSection($this->getReference('section-'.rand(1,5).'-'.rand(0,3)));
          $product->setManufacturer($man[rand(0,5)]);
          $product->setCountry($cou[rand(0,5)]);
          $product->setExpiration(new \DateTime('now + '.rand(10,50).'days + '.rand(0,60*60*24).' seconds'));
          $manager->persist($product);
        }
        foreach (range(1, 5) as $i) {
          $product = new Product();
          $product->setName('product-'.$i);
          $product->setPrice(rand(1,1000));
          $product->setManufacturer($man[rand(0,5)]);
          $product->setCountry($cou[rand(0,5)]);
          $product->setExpiration(new \DateTime('now + '.rand(10,50).'days + '.rand(0,60*60*24).' seconds'));
          $manager->persist($product);
        }
        $manager->flush();

}
}
