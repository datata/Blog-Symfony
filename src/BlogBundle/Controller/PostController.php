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
        
        $posts = $repository->findAll();
        //persistimos la entidad        
        // $em->persist($post);
        // $em->flush();
        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$posts]);

        // return new Response("Retorno post creado ->".$post->getId());
    }

    /**
    * @Route("/findtitle/{title}")
    */
    public function getPostByTitle($title)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogBundle:Post');
        
        
        $posts = $repository->findByTitle($title);

        // $posts = $repository->findBy(array('title' => $title,
        //                                    'tag'=>'tag'));

        if(!$posts) return new Response ('No existe post');

        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$posts]);
               
        //return new Response("Retorno title recuperado ->".$post->getTitle());
    }

    /**
    * @Route("/findquery/{title}")
    */
    public function getByQuery($title)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogBundle:Post');        
        
        $query = $repository->createQueryBuilder('p')
        ->where('p.title LIKE :title')
        ->setParameter('title','%'.$title.'%')
        ->getQuery();

        $posts =$query->getResult();        

        //if(!$posts) return new Response ('No existe post');

        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$posts]);
               
        //return new Response("Retorno title recuperado ->".$post->getTitle());
    }




}
