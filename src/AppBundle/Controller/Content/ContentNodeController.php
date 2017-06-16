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
	public function helloAction( Request $request ) {
		
		return $this->render( 'content/node.html.twig', [
			'base_dir' => realpath( $this->getParameter( 'kernel.root_dir' ) . '/..' ) . DIRECTORY_SEPARATOR,
		] );
	}
	
	
	/**
	 * @Route("/{entity}/post/{slug}", name="content_single_node")
	 */
	public function singleArticleAction( $entity, $slug, Request $request ) {
		//$scripts = \H5PCore::$scripts;
		//array_shift( $scripts );
		
		return $this->render( 'content/node.html.twig', [
			'styles'  => \H5PCore::$styles,
			'scripts' => \H5PCore::$scripts,
			'entity'  => $entity,
			'slug'    => $slug
		] );
	}
}

