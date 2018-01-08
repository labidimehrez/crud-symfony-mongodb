<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Product;
use AppBundle\Form\ProductType;


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

        $dm = $this->get('doctrine_mongodb')->getManager();

        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $request = $this->getRequest();
        if ($request->isMethod('Post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $product = $form->getData();
                $dm->persist($product);
                $dm->flush();
                // Puis met le flash dans la session de l'utilisateur
              
                return $this->redirectToRoute('create');
            }
        }
 
        return $this->render('AppBundle:product:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AppBundle:Product')->find($id);
 
        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }else{
            $form = $this->createForm(new ProductType(), $product);
            $request = $this->getRequest();
                if ($request->isMethod('Post')) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {
                        $product = $form->getData();
                        $dm->persist($product);
                        $dm->flush();
                        // Puis met le flash dans la session de l'utilisateur

                        return $this->redirectToRoute('homepage');
                    }
                }
            }

        

        return $this->render('AppBundle:product:update.html.twig', array('form' => $form->createView()));
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
