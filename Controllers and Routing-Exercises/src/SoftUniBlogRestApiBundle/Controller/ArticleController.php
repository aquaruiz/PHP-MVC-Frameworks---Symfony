<?php

namespace SoftUniBlogRestApiBundle\Controller;

use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/articles", name="rest_api_article", methods={"GET"})
     * @return Response
     */
    public function articlesAction()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        $serializer =$this->container->get('jms_serializer');
        $json = $serializer->serialize($articles, 'json');

        return new Response($json,
            Response::HTTP_OK,
             array('content-type' => 'application/json'));
    }

    /**
     * @Route("/articles/{id}", methods={"GET"})
     * @param $id article id
     * @return Response
     */
    public function articleAction($id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if(null == $article){
            return new Response(json_encode(array('error' => 'Recource not found')),
                Response::HTTP_NOT_FOUND,
                array('content-type'=>'application/json')
            );
        }

        $serializer =$this->container->get('jms_serializer');
        $articleJson = $serializer->serialize($article, 'json');


        return new Response($articleJson,
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }

    /**
     * @Route("/articles/create", methods={"POST"}, name="rest_api_article_create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request){
        try{
            // process submitted data
            $this->createNewArticle($request);

            return new Response(null, Response::HTTP_CREATED);
        } catch (\Exception $exception){
            return new Response(json_encode(['error' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                array(['content-type' => 'application/json'])
            );
        }
    }

    /**
     * Creates new article from requested parameters and persists it
     * @param Request $request
     * @return Article - persisted article
     * @throws \Exception
     */
    private function createNewArticle(Request $request)
    {
        /** @var Article $article */
        $article = new Article();
        $parameters = $request->request->all();
        $persistType = $this->processForm($article, $parameters, 'POST');
        return $persistType;
    }

    /**
     * Processes form
     * @param $article
     * @param $params
     * @param string $method
     * @return Article
     * @throws \Exception
     */
    private function processForm($article, $params, $method = "PUT")
    {
        foreach ($params as $param => $paramValue){
            if (null === $paramValue || 0 === strlen(trim($paramValue))){
                throw new \Exception("Invalid data: $param");
            }

            if (!array_key_exists("authorId", $params)){
                throw new \Exception("Invalid data : authorID");
            }

            $currentUser = $this
                ->getDoctrine()
                ->getRepository(User::class)
                ->find($params['authorId']);

            if(null === $currentUser){
                throw new \Exception('Invalid user id.');
            }

            $form = $this->createForm(
                Article::class,
                $article,
                ['method' => $method]
            );

            $form->submit($params);

            if($form->isSubmitted()){
                /** @var Article $article */
                $article->setAuthor($currentUser);

                //get entity manager
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $article;
            }

            throw new \Exception('Submitted data is invalid!');
        }
    }

    /**
     * @Route("articles/{id}", name="rest_api_article_edit", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id){
        try {
            $article = $this
                ->getDoctrine()
                ->getRepository(Article::class)
                ->find($id);

            if(null === $article){
                //create new article
                $this->createNewArticle($request);
                $statusCode = Response::HTTP_CREATED;
            } else {
                // update existing article
                $this->processForm($article, $request->request->all(), "PUT");
                $statusCode = Response::HTTP_NO_CONTENT;
            }

            return new Response(null, $statusCode);
        } catch (\Exception $exception){
            return new Response(json_encode(['error' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'application/json')
            );
        }
    }

    /**
     * @Route("/articles/{id}", methods={"DELETE"}, name="rest_api_article_delete")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function deleteAction(Request $request, $id){
        try {
            $article = $this
                ->getDoctrine()
                ->getRepository(Article::class)
                ->find($id);

            if(null === $article){
                $statusCode = Response::HTTP_NOT_FOUND;
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();

                $statusCode = Response::HTTP_NO_CONTENT;
            }

            return new Response(null, $statusCode);
        } catch (\Exception $exception){
            return new Response(json_encode(['error' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'application/json')
            );
        }
    }
}