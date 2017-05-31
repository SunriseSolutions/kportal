<?php

namespace AppBundle\Controller\Content;

use AppBundle\Entity\Content\PieceOfContent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PieceOfContentController extends Controller {
	
	/**
	 * @Route("/sample-content", name="piece_of_content")
	 */
	public function helloAction( Request $request ) {
		
		return $this->render( 'content/piece.html.twig', [
			'base_dir' => realpath( $this->getParameter( 'kernel.root_dir' ) . '/..' ) . DIRECTORY_SEPARATOR,
		] );
	}
	
	
	/**
	 * @Route("/{entity}/{slug}", name="single_poc")
	 */
	public function singleArticleAction( $entity, $slug, Request $request ) {
		return $this->render( 'content/piece.html.twig', [
			'entity' => $entity,
			'slug' => $slug
		] );
	}
}

