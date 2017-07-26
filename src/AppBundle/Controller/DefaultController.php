<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Content\ArticleNode;
use AppBundle\Entity\Content\ContentNode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
		
		$multichoice1 = json_decode('{"media":{"params":{"contentName":"Image","file":{"path":"images/file-592da00abe776.jpg","mime":"image/jpeg","copyright":{"license":"U"},"width":800,"height":800},"alt":"sample ALternative Text","title":"sample hover text"},"library":"H5P.Image 1.0","subContentId":"d9fa0034-a59f-447e-a2c6-61da8c09e8d5"},"answers":[{"correct":false,"tipsAndFeedback":{"tip":"<p>sapmle tip for q1</p>\n","chosenFeedback":"<div>sample displayed message if answer is selected</div>\n","notChosenFeedback":"<div>sample msg if not selected</div>\n"},"text":"<div>option 1 text incorrect</div>\n"},{"correct":true,"tipsAndFeedback":{"tip":"<p>tip</p>\n","chosenFeedback":"<div>selected</div>\n","notChosenFeedback":"<div>why not selected</div>\n"},"text":"<div>option 1 text <strong>correct</strong></div>\n"}],"UI":{"checkAnswerButton":"Check","showSolutionButton":"Show solution","tryAgainButton":"Retry","tipsLabel":"Show tip","scoreBarLabel":"Score","tipAvailable":"Tip available","feedbackAvailable":"Feedback available","readFeedback":"Read feedback","wrongAnswer":"Wrong answer","correctAnswer":"Correct answer","feedback":"You got @score of @total points","shouldCheck":"Should have been checked","shouldNotCheck":"Should not have been checked","noInput":"Please answer before viewing the solution"},"behaviour":{"enableRetry":true,"enableSolutionsButton":true,"type":"auto","singlePoint":true,"randomAnswers":true,"showSolutionsRequiresInput":true,"disableImageZooming":false,"confirmCheckDialog":false,"confirmRetryDialog":false,"autoCheck":true,"passPercentage":100},"confirmCheck":{"header":"Finish ?","body":"Are you sure you wish to finish ?","cancelLabel":"Cancel","confirmLabel":"Finish"},"confirmRetry":{"header":"Retry ?","body":"Are you sure you wish to retry ?","cancelLabel":"Cancel","confirmLabel":"Confirm"},"question":"<p>Question 1 short-code</p>\n"}');

//		var_dump($multichoice1);
//		var_dump($multichoice1->media);
//		var_dump($multichoice1->answers);
		var_dump($multichoice1->UI);
//		var_dump($multichoice1->behaviour);
//		var_dump($multichoice1->confirmCheck);
//		var_dump($multichoice1->confirmRetry);
		var_dump($multichoice1->question);
//
//		var_dump($multichoice1->media->params);
		
		
		exit();
		
		return new Response('hello');
		
		
	}
	
	/**
	 * @Route("/get-file-url/{id}", name="get_file_url")
	 */
	public function getFileAction(Request $request, $id) {
		$secret = $request->query->get('bean-secret-key');
		if($secret === '20170727lethanhbinhahihihi') {
			$manager = $this->get('sonata.media.manager.media');
			$medium  = $manager->find($id);
			if(empty($medium)) {
				return new Response('{404}');
			}
			
			return new Response($manager->getMediaUrl($medium));
		}
		
		return new Response('{fuck-you}');
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
