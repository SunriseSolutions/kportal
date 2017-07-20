<?php

namespace AppBundle\Controller\Content;

use AppBundle\Entity\Content\ArticleNode;
use AppBundle\Entity\Content\BlogItem;
use AppBundle\Entity\Content\BlogNode;
use AppBundle\Entity\Content\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentNodeController extends Controller {
	
	/**
	 * @Route("/sample-content", name="content_node")
	 */
	public function helloAction(Request $request) {
		
		return $this->render('content/node.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
		]);
	}
	
	
	/**
	 * @Route("/{entitySlug}/post/{articleSlug}", name="content_article")
	 */
	public function singleArticleAction($entitySlug, $articleSlug, Request $request) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
		$registry    = $this->getDoctrine();
		$articleRepo = $registry->getRepository(ArticleNode::class);
		$entityRepo  = $registry->getRepository(ContentEntity::class);
		$entity      = $entityRepo->findOneBy([ 'slug' => $entitySlug ]);
		$manager     = $this->get('doctrine.orm.default_entity_manager');
		
		if(empty($entity)) {
			throw new NotFoundHttpException();
		}
		$article = $articleRepo->findOneBy([ 'slug' => $articleSlug, 'owner' => $entity->getId() ]);
		if(empty($article)) {
			throw new NotFoundHttpException();
		}
		
		$h5p     = $this->get('app.h5p');
		$h5pHtml = $h5p->getHtml([ 1, 2 ]);
		
		$settings    = json_encode($h5p->getSettings());
		$setting     = $h5p->getSettings();
		$contentTest = [];
		foreach($setting['contents'] as $content) {
			$contentTest[] = json_decode($content['jsonContent']);
		}
		
		return $this->render('content/article.html.twig', [
			'contentTest' => $contentTest,
			'styles'      => $h5p->getStyles(),
			'scripts'     => $h5p->getScripts(),
			'settingRaw'  => $h5p->getSettings(),
			'h5pHtml'     => $h5pHtml,
			'h5pSettings' => $settings,
			'entitySlug'  => $entitySlug,
			'slug'        => $articleSlug,
			'entity'      => $entity,
			'article'     => $article
		]);
	}
	
	/**
	 * @Route("/{slug}{trailingSlash}", name="content_blog", requirements={"slug":"^(?!admin|login).+", "trailingSlash" = "[/]"} )
	 */
	public function blogAction($slug, $trailingSlash, Request $request) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
//		$h5p     = $this->get('app.h5p');
//		$h5pHtml = $h5p->getHtml([ 1, 2 ]);
		
		$registry = $this->getDoctrine();
		$blogRepo = $registry->getRepository(BlogNode::class);
		$blog     = $blogRepo->findOneBy([ 'slug' => $slug ]);
		if(empty($blog)) {
			throw new NotFoundHttpException();
		}
		$entityManager = $this->get('doctrine.orm.default_entity_manager');
		$queryBuilder  = $entityManager->createQueryBuilder();
		$expr          = $queryBuilder->expr();
		$queryBuilder->select('item')
		             ->from(BlogItem::class, 'item')
		             ->join('item.blog', 'blog')
		             ->where($expr->eq('blog.id', ':blogId'))
		             ->setParameter('blogId', $blog->getId());
		
		$adapter    = new DoctrineORMAdapter($queryBuilder);
		$pagerfanta = new Pagerfanta($adapter);

//		$settings    = json_encode($h5p->getSettings());
//		$setting     = $h5p->getSettings();
		$contentTest = [];
//		foreach($setting['contents'] as $content) {
//			$contentTest[] = json_decode($content['jsonContent']);
//		}
		
		return $this->render('content/blog.html.twig', [
			'contentTest' => $contentTest,
//			'styles'      => $h5p->getStyles(),
//			'scripts'     => $h5p->getScripts(),
//			'settingRaw'  => $h5p->getSettings(),
//			'h5pHtml'     => $h5pHtml,
//			'h5pSettings' => $settings,
			'slug'        => $slug,
			'blog'        => $blog,
			'items'       => $pagerfanta->getCurrentPageResults(),
			'pager'       => $pagerfanta
		]);
	}
	
	
	/**
	 * @Route("/{entity}/post/{slug}/edit", name="content_single_node_edit")
	 */
	public function singleArticleAdminAction($entity, $slug, Request $request) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
		$h5p     = $this->get('app.h5p');
		$h5pHtml = $h5p->getHtml(1);
		
		$settings = json_encode($h5p->getSettings());
		
		return $this->render('content/node-edit.html.twig', [
			'styles'      => $h5p->getStyles(),
			'scripts'     => $h5p->getScripts(),
			'h5pHtml'     => $h5pHtml,
			'h5pSettings' => $settings,
			'entity'      => $entity,
			'slug'        => $slug
		]);
	}
}

