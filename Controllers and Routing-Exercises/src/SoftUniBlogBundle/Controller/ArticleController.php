<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/create", name="article_create")
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createNewArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $article->setViewCount(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_view")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewArticle($id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['id' => $id]);

        $article->setViewCount($article->getViewCount() + 1);

        $em = $this
            ->getDoctrine()
            ->getManager();
        $em->persist($article);
        $em->flush();

        return $this->render('article/article.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if ($article === null) {
            return $this->redirectToRoute('blog_index');
        }

        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();

        if (!$currentUser->isAuthor($article)
            && !$currentUser->isAdmin()
            && !$currentUser->isModerator()){
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $article->setDateAdded(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->merge($article); //!!!!!!!!!
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/edit.html.twig',
            ['form' => $form->createView(),
                'article' => $article]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if ($article === null) {
            return $this->redirectToRoute('blog_index');
        }


        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();

        if (!$currentUser->isAuthor($article)
            && !$currentUser->isAdmin()
            && !$currentUser->isModerator()){
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article); //!!!!!!!!!
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('article/delete.html.twig',
            ['form' => $form->createView(),
                'article' => $article]);
    }

    /**
     * @Route("/myArticles", name="myArticles")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function myArticles(){
        $myArticles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['author' => $this->getUser()]);

        return $this->render('article/myArticles.html.twig',
            ['articles' => $myArticles]);
    }
}