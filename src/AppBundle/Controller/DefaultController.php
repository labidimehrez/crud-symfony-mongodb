<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction() {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();
//        var_dump($product->getName());exit;
        return new Response('Created product id ' . $product->getId());
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AppBundle:Product')->find($id);
//        var_dump($product->getName());exit;
        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $product->setName('New product name!');
        $dm->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/show", name="show")
     */
    public function showAction() {
        $products = $this->get('doctrine_mongodb')
                ->getRepository('AppBundle:Product')
                ->findAll();

        if (!$products) {
            throw $this->createNotFoundException('No product found ');
        }
        return $this->render('AppBundle:product:show.html.twig', array('products' => $products));
    }

}
