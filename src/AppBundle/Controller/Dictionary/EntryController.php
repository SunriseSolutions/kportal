<?php

namespace AppBundle\Controller\Dictionary;

use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\BlogItem;
use AppBundle\Entity\Content\NodeType\Blog\BlogNode;
use AppBundle\Entity\Content\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Dictionary\Entry;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntryController extends Controller {
	
	public function helloAction(Request $request) {
		
		return $this->render('content/node.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
		]);
	}
	
	
	/**
	 * @Route("/{entry}", name="entry_detail")
	 */
	public function entryDetailAction(Entry $entry, Request $request) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
		$registry    = $this->getDoctrine();
		$articleRepo = $registry->getRepository(ArticleNode::class);
		$entityRepo  = $registry->getRepository(ContentEntity::class);

		$manager     = $this->get('doctrine.orm.default_entity_manager');
		
		
		return $this->render('default/index.html.twig', [
//			'contentTest'   => $contentTest,
//			'h5pContentIds' => $h5pContentIds
		]);
	}
}

