<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Content\ArticleNode;
use AppBundle\Entity\Content\ContentNode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	
	/**
	 * @Route("/hello", name="hello")
	 */
	public function helloAction(Request $request) {
		$content = new ArticleNode();
		$content->setBody('olala');
		$content->setH5pContent([
			3     => 'sidebar-left',
			'id1' => 'inline',
			'id2' => 'bottom-left',
			'id3' => 'bottom-right'
		]);
		
		$manager = $this->get('doctrine.orm.default_entity_manager');
//		$manager->persist($content);
//		$manager->flush();
		
		$repo    = $this->getDoctrine()->getRepository(ArticleNode::class);
		$article = $repo->find('4DOS-0000-0000-00OT-EJ17');
		
		$testArray = [ 0 => 'number', '0' => 'letter' ];
		
		return new JsonResponse($article->getH5pContent()[3]);
	}
	
	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction(Request $request) {
		$isExistent        = $this->container->hasParameter('non_existent_param');
		$httpHost1         = $request->server->getAlnum('HTTP_HOST');
		$host              = $request->getHost();
		$httpHost2         = $request->getHttpHost();
		$schemeAndHttpHost = $request->getSchemeAndHttpHost();
//        if ($this->container->hasParameter($host)) {
//            $themeName = $this->getParameter($host);
//            $activeTheme = $this->get('liip_theme.active_theme');
//            $activeThemeName = $activeTheme->getName();
//            $activeTheme->setName($themeName);
//        }
		
		// replace this example code with whatever you need
		return $this->render('default/index.html.twig', [
			'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
		]);
	}
}
