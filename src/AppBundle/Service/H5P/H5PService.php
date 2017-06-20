<?php

namespace AppBundle\Service\H5P;

use Symfony\Component\DependencyInjection\ContainerInterface;

class H5PService {
	/** @var  ContainerInterface */
	private $container;
	
	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
	}
	
	public function getCoreSettings() {
		$request = $this->container->get( 'request_stack' )->getCurrentRequest();
		$baseUrl = $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
		
		$settings = array(
			'baseUrl'            => $baseUrl,
			'url'                => $request->getBasePath().'/assets/h5p/plugins',
			'postUserStatistics' => false,
			'ajax'               => array(
				'setFinished'     => 'http:\/\/localhost\/001\/wordpress\/wp-admin\/admin-ajax.php?token=bb437e0543&action=h5p_setFinished',
				'contentUserData' => 'http:\/\/localhost\/001\/wordpress\/wp-admin\/admin-ajax.php?token=4a4cf5bc89&action=h5p_contents_user_data&content_id=:contentId&data_type=:dataType&sub_content_id=:subContentId'
			),
			'saveFreq'           => false,
			'siteUrl'            => $baseUrl,
			'l10n'               => array(
				'H5P' => array(
					'fullscreen'            => 'Fullscreen',
					'disableFullscreen'     => 'Disable fullscreen',
					'download'              => 'Download',
					'copyrights'            => 'Rights of use',
					'embed'                 => 'Embed',
					'size'                  => 'Size',
					'showAdvanced'          => 'Show advanced',
					'hideAdvanced'          => 'Hide advanced',
					'advancedHelp'          => 'Include this script on your website if you want dynamic sizing of the embedded content:',
					'copyrightInformation'  => 'Rights of use',
					'close'                 => 'Close',
					'title'                 => 'Title',
					'author'                => 'Author',
					'year'                  => 'Year',
					'source'                => 'Source',
					'license'               => 'License',
					'thumbnail'             => 'Thumbnail',
					'noCopyrights'          => 'No copyright information available for this content.',
					'downloadDescription'   => 'Download this content as a H5P file.',
					'copyrightsDescription' => 'View copyright information for this content.',
					'embedDescription'      => 'View the embed code for this content.',
					'h5pDescription'        => 'Visit H5P.org to check out more cool content.',
					'contentChanged'        => 'This content has changed since you last used it.',
					'startingOver'          => "You'll be starting over.",
					'confirmDialogHeader'   => 'Confirm action',
					'confirmDialogBody'     => 'Please confirm that you wish to proceed. This action is not reversible.',
					'cancelLabel'           => 'Cancel',
					'confirmLabel'          => 'Confirm'
				)
			),
			'hubIsEnabled'       => true
		);
		
		return $settings;
	}
}