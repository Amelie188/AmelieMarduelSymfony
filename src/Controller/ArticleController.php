<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{

    // *************** FIND ALL ***************


    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }


// *************** AJOUT EN BDD ***************

    /**
     * @Route("/add/article", name="add_article")
     */
    public function addArticle(Request $request, SluggerInterface $slugger) {
        $form = $this->createForm(ArticleType::class, new Article());
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $articles = $form->getData(); 

        $image = $form->get('image')->getData();

        if ($image) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
       
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            try {
                $image->move(
                    'images/',
                    $newFilename
                );
            } catch (FileException $e) {
            }

            $articles->setImage($newFilename);
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($articles); 
        $em->flush(); 

        } else {

        return $this->render('article/add_article.html.twig', [
        'form' => $form->createView(),
        'errors'=>$form->getErrors()
        ]);
        }
        
        return $this->redirect('/article');
    }
 

// *************** GET ONE ***************

    /**
     * @Route("/article/{id}", name="detailArticle")
     */

    public function getOne($id)
    {

    $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

    return $this->render('article/detail.html.twig', [
    
    'article' => $article,
    ]);
    }


}
