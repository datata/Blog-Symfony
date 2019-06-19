<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Response;

use BlogBundle\Entity\Post;

/**
* @Route("/post")
*/


class PostController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction()
    {
        // cargar entity manager
        $em = $this->getDoctrine()->getManager();
        //dump($em);
        //creamos la entidad que hemos creado
        $post = new Post();
        $post->setTitle('Prueba');
        $post->setBody('Es el cuerpo');
        $post->setTag('untag');
        $post->setCreateAt(new \DateTime('now'));
        $post->setIduser(1);

        //persistimos la entidad        
        $em->persist($post);
        $em->flush();

        return new Response("Retorno post creado ->".$post->getId());
    }

    /**
     * @Route("/getall")
     */
    public function getAllAction()
    {
        // recuperamos entity manager
        $em = $this->getDoctrine()->getManager();
        //indicamos el repositorio que queremos
        $repository = $em->getRepository('BlogBundle:Post');
        
        dump($repository->findAll());
        //persistimos la entidad        
        // $em->persist($post);
        // $em->flush();
        return $this->render('@Blog/Default/posts.html.twig');

        // return new Response("Retorno post creado ->".$post->getId());
    }
}
