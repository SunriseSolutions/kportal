<?php

namespace AppBundle\Service\H5P;

use AppBundle\Entity\H5P\Content;
use AppBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class H5PService extends BaseService {
	private $settings;
	private $baseURL;
	private $fullH5PExtensionURL;
	private $fullH5PLibraryURL;
	private $fullH5PEditorLibraryURL;
	private $fullH5PAdminLibraryURL;
	private $fullH5PExtensionFilePath;
	private $fullH5PEditorFilePath;
	
	private $absoluteH5PExtensionURL;
	private $absoluteH5PLibraryURL;
	private $absoluteH5PEditorLibraryURL;
	private $absoluteH5PAdminLibraryURL;
	
	private $scripts = [];
	private $styles = [];
	private $interface = null;
	private $h5pEditor;
	
	/**
	 * Instance of H5P Core.
	 *
	 * @since 1.0.0
	 * @var \H5PCore
	 */
	private $core = null;
	
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 * Keeping track of the DB version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const VERSION = '1.8.3';
	
	public function __construct(ContainerInterface $container, AppH5PFramework $h5pF) {
		parent::__construct($container);
		$request                           = $this->container->get('request_stack')->getCurrentRequest();
		$this->baseURL                     = $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
		$this->absoluteH5PExtensionURL     = $request->getBasePath() . '/assets/h5p/extension';
		$this->absoluteH5PLibraryURL       = $request->getBasePath() . '/assets/h5p';
		$this->absoluteH5PEditorLibraryURL = $request->getBasePath() . '/assets/h5p-editor';
		$this->absoluteH5PAdminLibraryURL  = $request->getBasePath() . '/assets/h5p-bo';
		
		$this->fullH5PExtensionURL     = $this->baseURL . '/assets/h5p/extension';
		$this->fullH5PLibraryURL       = $this->baseURL . '/assets/h5p';
		$this->fullH5PEditorLibraryURL = $this->baseURL . '/assets/h5p-editor';
		$this->fullH5PAdminLibraryURL  = $this->baseURL . '/assets/h5p-bo';
		
		$this->fullH5PExtensionFilePath = $container->get('kernel')->getRootDir() . '/../web' . '/assets/h5p/extension';
		$this->fullH5PEditorFilePath    = $container->get('kernel')->getRootDir() . '/../web' . '/assets/h5p-editor';
		
		$this->interface             = $h5pF;
		$language                    = $this->getLanguage();
		$this->core                  = new \H5PCore($this->interface, $this->fullH5PExtensionFilePath, $this->absoluteH5PExtensionURL, $language, true);
		$this->core->aggregateAssets = ! (defined('H5P_DISABLE_AGGREGATION') && H5P_DISABLE_AGGREGATION === true);
		// Add core assets
		$this->addCoreAssets();
	}
	
	public function getH5PInstance($type) {
		switch($type) {
			case 'validator':
				return new \H5PValidator($this->interface, $this->core);
			case 'storage':
				return new \H5PStorage($this->interface, $this->core);
			case 'contentvalidator':
				return new \H5PContentValidator($this->interface, $this->core);
			case 'export':
				return new \H5PExport($this->interface, $this->core);
			case 'interface':
				return $this->interface;
			case 'core':
				return $this->core;
		}
	}
	
	
	/**
	 * Returns the instance of the h5p editor library.
	 *
	 * @since 1.1.0
	 * @return \H5peditor
	 */
	public function getH5PEditorInstance() {
		if($this->h5pEditor === null) {
			$this->h5pEditor = $this->container->get('app.h5p_editor');
		}
		
		return $this->h5pEditor;
	}
	
	public function getHtml($ids) {
		if(is_array($ids)) {
			foreach($ids as $id) {
				$content = $this->getContent($id);
				if( ! empty($content)) {
					$html = $this->addAssets($content);
				} else {
					$html = '';
				}
			}
		} else {
			$content = $this->getContent($ids);
			if( ! empty($content)) {
				$html = $this->addAssets($content);
			} else {
				$html = '';
			}
		}
		
		return $html;
	}
	
	/**
	 * @param int $id
	 *
	 * @return array
	 */
	public function getContent($id) {
		if($id === false || $id === null) {
			return ('Missing H5P identifier.');
		}
		
		// Try to find content with $id.
		$core    = $this->getH5PInstance('core');
		$content = $core->loadContent($id);
		
		if( ! $content) {
//			return sprintf('Cannot find H5P content with id: %d.', $id);
			return null;
		}
		
		$content['language'] = $this->getLanguage();
		
		return $content;
	}
	
	public function getCoreSettings() {
		if(empty($this->settings)) {
			$this->settings = array(
				'baseUrl'            => $this->baseURL,
				'url'                => $this->absoluteH5PExtensionURL,
				'postUserStatistics' => false,
				'ajax'               => array(
					'setFinished'     => '',
					'contentUserData' => ''
				),
				'saveFreq'           => false,
				'siteUrl'            => $this->baseURL,
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
		}
		
		return $this->settings;
	}
	
	public function getLanguage() {
		return $this->container->get('request_stack')->getCurrentRequest()->getLocale();
	}
	
	
	/**
	 * Include settings and assets for the given content.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $content
	 * @param boolean $no_cache
	 *
	 * @return string Embed code
	 */
	public function addAssets($content, $no_cache = false) {
		// Add core assets
//		$this->addCoreAssets();
		
		// Detemine embed type
		$embed = \H5PCore::determineEmbedType($content['embedType'], $content['library']['embedTypes']);
		
		// Make sure content isn't added twice
		$cid = 'cid-' . $content['id'];
		if( ! isset($this->settings['contents'][ $cid ])) {
			$this->settings['contents'][ $cid ] = $this->getContentSettings($content);
			$core                               = $this->getH5PInstance('core');
			
			// Get assets for this content
			$preloaded_dependencies = $core->loadContentDependencies($content['id'], 'preloaded');
			$files                  = $core->getDependenciesFiles($preloaded_dependencies);
//			$this->alter_assets( $files, $preloaded_dependencies, $embed );
			
			if($embed === 'div') {
				$this->enqueue_assets($files);
			} elseif($embed === 'iframe') {
				$this->settings['contents'][ $cid ]['scripts'] = $core->getAssetsUrls($files['scripts']);
				$this->settings['contents'][ $cid ]['styles']  = $core->getAssetsUrls($files['styles']);
			}
		}
		
		if($embed === 'div') {
			return '<div class="h5p-content" data-content-id="' . $content['id'] . '"></div>';
		} else {
			return '<div class="h5p-iframe-wrapper"><iframe id="h5p-iframe-' . $content['id'] . '" class="h5p-iframe" data-content-id="' . $content['id'] . '" style="height:1px" src="about:blank" frameBorder="0" scrolling="no"></iframe></div>';
		}
	}
	
	public function getContentActualEmbedType(Content $content) {
		return \H5PCore::determineEmbedType($content->getEmbedType(), $content->getLibrary()->getEmbedTypes());
	}
	
	public function getContentHtml(Content $content, $params = array()) {
		$embed = \H5PCore::determineEmbedType($content->getEmbedType(), $content->getLibrary()->getEmbedTypes());
		if(array_key_exists('class', $params)) {
			$class = ' ' . $params['class'];
		} else {
			$class = '';
		}
		if(array_key_exists('id', $params)) {
			$idAttr = ' id="' . $params['id'] . '"';
		} else {
			$idAttr = '';
		}
		if($embed === 'div') {
			return '<div' . $idAttr . ' class="h5p-content' . $class . '" data-content-id="' . $content->getId() . '"></div>';
		} else {
			return '<div' . $idAttr . ' class="h5p-iframe-wrapper' . $class . '"><iframe id="h5p-iframe-' . $content->getId() . '" class="h5p-iframe" data-content-id="' . $content->getId() . '" style="height:1px" src="about:blank" frameBorder="0" scrolling="no"></iframe></div>';
		}
	}
	
	/**
	 * Get settings for given content
	 *
	 * @since 1.5.0
	 *
	 * @param array $content
	 *
	 * @return array
	 */
	public
	function getContentSettings(
		$content
	) {
		$core            = $this->getH5PInstance('core');
		$safe_parameters = $core->filterParameters($content);
//		if ( has_action( 'h5p_alter_filtered_parameters' ) ) {
//
//		}
		
		// Getting author's user id
		$author_id = (int) (is_array($content) ? $content['user_id'] : $content->user_id);
		
		// Add JavaScript settings for this content
		$settings = array(
			'library'         => \H5PCore::libraryToString($content['library']),
			'jsonContent'     => $safe_parameters,
			'fullScreen'      => $content['library']['fullscreen'],
			'exportUrl'       => true ? $this->absoluteH5PExtensionURL . '/exports/' . ($content['slug'] ? $content['slug'] . '-' : '') . $content['id'] . '.h5p' : '',
			'embedCode'       => '<iframe src="' . $this->admin_url('admin-ajax.php?action=h5p_embed&id=' . $content['id']) . '" width=":w" height=":h" frameborder="0" allowfullscreen="allowfullscreen"></iframe>',
			'resizeCode'      => '<script src="' . $this->plugins_url('h5p/h5p-php-library/js/h5p-resizer.js') . '" charset="UTF-8"></script>',
			'url'             => $this->admin_url('admin-ajax.php?action=h5p_embed&id=' . $content['id']),
			'title'           => $content['title'],
			'displayOptions'  => $core->getDisplayOptionsForView($content['disable'], $author_id),
			'contentUserData' => array(
				0 => array(
					'state' => '{}'
				)
			)
		);
		
		// Get preloaded user data for the current user
		$current_user = $this->container->get('app.user')->getUser(false);
		if($this->get_option('h5p_save_content_state', false) && $current_user->getId()) {
//			$results = $wpdb->get_results( $wpdb->prepare(
//				"SELECT hcud.sub_content_id,
//                hcud.data_id,
//                hcud.data
//          FROM {$wpdb->prefix}h5p_contents_user_data hcud
//          WHERE user_id = %d
//          AND content_id = %d
//          AND preload = 1",
//				$current_user->ID, $content['id']
//			) );
			$results = false;
			if($results) {
				foreach($results as $result) {
					$settings['contentUserData'][ $result->sub_content_id ][ $result->data_id ] = $result->data;
				}
			}
		}
		
		return $settings;
	}
	
	public
	function admin_url(
		$hello
	) {
		$hello = '';
		
		return $hello;
	}
	
	public
	function plugins_url(
		$hello
	) {
		return $hello;
	}
	
	public
	function get_option(
		$a, $default
	) {
		return $default;
	}
	
	/**
	 * Set core JavaScript settings and add core assets.
	 *
	 * @since 1.0.0
	 */
	public
	function addCoreAssets() {
		if($this->settings !== null) {
			return; // Already added
		}
		
		$this->settings              = $this->getCoreSettings();
		$this->settings['core']      = array(
			'styles'  => array(),
			'scripts' => array()
		);
		$this->settings['loadedJs']  = array();
		$this->settings['loadedCss'] = array();
		$cache_buster                = '?ver=' . self::VERSION;
		
		// Use absolute URL to support both http and https.
		$lib_url  = $this->fullH5PLibraryURL . '/';
		$rel_path = $this->absoluteH5PLibraryURL;
		
		// Add core stylesheets
		foreach(\H5PCore::$styles as $style) {
			$this->settings['core']['styles'][] = $rel_path . '/' . $style . $cache_buster;
//			$assetPath                          = $this->asset_handle( 'core-' . $style );
//			wp_enqueue_style( $assetPath, $lib_url . $style, array(), self::VERSION );
			$this->styles[] = $rel_path . '/' . $style . $cache_buster;
		}
		
		// Add core JavaScript
		foreach(\H5PCore::$scripts as $script) {
			$this->settings['core']['scripts'][] = $rel_path . '/' . $script . $cache_buster;
//			wp_enqueue_script( $this->asset_handle( 'core-' . $script ), $lib_url . $script, array(), self::VERSION );
			$this->scripts[] = $rel_path . '/' . $script . $cache_buster;
		}
	}
	
	/**
	 * Enqueue assets for content embedded by div.
	 *
	 * @param array $assets
	 */
	public
	function enqueue_assets(
		&$assets
	) {
		$abs_url = $this->fullH5PExtensionURL;
		$rel_url = $this->absoluteH5PExtensionURL;
		foreach($assets['scripts'] as $script) {
			$url = $rel_url . $script->path . $script->version;
			if( ! in_array($url, $this->settings['loadedJs'])) {
				$this->settings['loadedJs'][] = $url;
				$this->scripts[]              = $url;
//				wp_enqueue_script( $this->asset_handle( trim( $script->path, '/' ) ), $abs_url . $script->path, array(), str_replace( '?ver', '', $script->version ) );
			}
		}
		foreach($assets['styles'] as $style) {
			$url = $rel_url . $style->path . $style->version;
			if( ! in_array($url, $this->settings['loadedCss'])) {
				$this->settings['loadedCss'][] = $url;
				$this->styles[]                = $url;
//				wp_enqueue_style( $this->asset_handle( trim( $style->path, '/' ) ), $abs_url . $style->path, array(), str_replace( '?ver', '', $style->version ) );
			}
		}
	}
	
	
	/**
	 * Add assets and JavaScript settings for the editor.
	 *
	 * @since 1.1.0
	 *
	 * @param int $id optional content identifier
	 */
//	public function addEditorAssets($id = null) {
//		$this->addCoreAssets();
//
//		// Make sure the h5p classes are loaded
//		$this->getH5PInstance('core');
//		$this->getH5PEditorInstance();
//
//		// Add JavaScript settings
//		$settings     = $this->getSettings();
//		$cache_buster = '?ver=' . self::VERSION;
//
//		// Use jQuery and styles from core.
//		$assets = array(
//			'css' => $settings['core']['styles'],
//			'js'  => $settings['core']['scripts']
//		);
//
//		// Use absolute URL to support both http and https.
//		$upload_dir = $this->fullH5PEditorLibraryURL;
//		$url        = '/' . preg_replace('/^[^:]+:\/\/[^\/]+\//', '', $upload_dir) . '/';
//
//		// Add editor styles
//		foreach(\H5peditor::$styles as $style) {
//			$assets['css'][] = $url . $style . $cache_buster;
//		}
//
//		// Add editor JavaScript
//		foreach(\H5peditor::$scripts as $script) {
//			// We do not want the creator of the iframe inside the iframe
//			if($script !== 'scripts/h5peditor-editor.js') {
//				$assets['js'][] = $url . $script . $cache_buster;
//			}
//		}
//
//
//		// Add translation
//		$language        = $this->container->get('app.site')->getLocale();
//		$language_script = $this->fullH5PEditorFilePath . '/language/' . $language . '.js';
//		if( ! file_exists($language_script)) {
//			$language_script = $this->fullH5PEditorLibraryURL . '/language/en.js';
//		}
//
//		// Add JavaScript with library framework integration (editor part)
//		$h5pAssets = [
//			'scripts' => [
//				$this->fullH5PEditorLibraryURL . '/' . 'scripts/h5peditor-editor.js',
//				$this->fullH5PAdminLibraryURL . '/' . 'scripts/h5p-editor.js',
//				$language_script
//			],
//			'styles'  => []
//		];
//
//		$this->enqueue_assets($h5pAssets);
//
//		// Add JavaScript settings
//		$content_validator  = $this->getH5PInstance('contentvalidator');
//		$settings['editor'] = array(
//			'filesPath'          => $this->fullH5PExtensionFilePath . '/editor',
//			'fileIcon'           => array(
//				'path'   => $this->fullH5PEditorFilePath . '/images/binary-file.png',
//				'width'  => 50,
//				'height' => 50,
//			),
//			'ajaxPath'           => $this->admin_url('admin-ajax.php?token=sample-token' . '&action=h5p_'),
//			'libraryUrl'         => $this->fullH5PEditorLibraryURL,
//			'copyrightSemantics' => $content_validator->getCopyrightSemantics(),
//			'assets'             => $assets,
//			'deleteMessage'      => 'Are you sure you wish to delete this content?',
//			'apiVersion'         => \H5PCore::$coreApi
//		);
//
//		if($id !== null) {
//			$settings['editor']['nodeVersionId'] = $id;
//		}
//		$this->settings = $settings;
//	}
	
	/**
	 * @return array
	 */
	public
	function getScripts() {
		return $this->scripts;
	}
	
	
	/**
	 * @return array
	 */
	public
	function getStyles() {
		return $this->styles;
	}
	
	/**
	 * @return mixed
	 */
	public
	function getSettings() {
		return $this->settings;
	}
	
	/**
	 * @return string
	 */
	public
	function getFullH5PExtensionFilePath() {
		return $this->fullH5PExtensionFilePath;
	}
	
	/**
	 * @param string $fullH5PExtensionFilePath
	 */
	public
	function setFullH5PExtensionFilePath(
		$fullH5PExtensionFilePath
	) {
		$this->fullH5PExtensionFilePath = $fullH5PExtensionFilePath;
	}
	
	
}