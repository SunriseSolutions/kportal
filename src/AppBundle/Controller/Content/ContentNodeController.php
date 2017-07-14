<?php

namespace AppBundle\Controller\Content;

use AppBundle\Entity\Content\ContentNode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
	 * @Route("/{entity}/post/{slug}", name="content_single_node")
	 */
	public function singleArticleAction($entity, $slug, Request $request) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
		$h5p     = $this->get('app.h5p');
		$h5pHtml = $h5p->getHtml([ 1, 2 ]);
		
		$settings    = json_encode($h5p->getSettings());
		$setting     = $h5p->getSettings();
		$contentTest = [];
		foreach($setting['contents'] as $content) {
			$contentTest[] = json_decode($content['jsonContent']);
		}
		
		return $this->render('content/node.html.twig', [
			'contentTest' => $contentTest,
			'styles'      => $h5p->getStyles(),
			'scripts'     => $h5p->getScripts(),
			'settingRaw'  => $h5p->getSettings(),
			'h5pHtml'     => $h5pHtml,
			'h5pSettings' => $settings,
			'entity'      => $entity,
			'slug'        => $slug
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

