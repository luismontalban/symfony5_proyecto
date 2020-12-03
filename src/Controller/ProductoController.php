<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Producto;
use App\Form\ProductoType;

class ProductoController extends AbstractController
{
    /**
     * @Route("/producto", name="producto")
     */
//    public function index(): Response
//    {
//        return $this->render('producto/index.html.twig', [
//            'controller_name' => 'ProductoController',
//        ]);
//    }
    
    
    public function createproducto(Request $request) {
        
        
        $producto = new Producto();
        
        $form = $this->createForm(ProductoType::class, $producto);
        
        
        //RELLENAR EL OBJETO CON LOS DATOS DEL FORM
        $form->handleRequest($request);
        
        
        //COMPROBAR SI EL FORM SE HA ENVIDO Y ES VALIDO
        if ($form->isSubmitted() && $form->isValid()) {
            
            //GUARDAR USUARIO
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();

            //SESION FLASH

            $session = new Session();

            $session->getFlashBag()->add('message', 'Producto registrado');

            return $this->redirectToRoute('crear-producto');
        }
        
        
        
        
        
        
        return $this->render('producto/index.html.twig', [
             'form' => $form->createView()
        ]);
        
        
    }
    
    
    public function misproductos()
    {
           $em = $this->getDoctrine()->getManager();

        //AQUI SACAMOS TODOS LOS REGISTROS DE LA TABLA
        $producto_repo = $this->getDoctrine()
                ->getRepository(Producto::class);

        $productos = $producto_repo->findAll();
        
                return $this->render('producto/misproductos.html.twig', [
                    'productos' => $productos
        ]);
        
        
        
    }
    
    
    
    
}
