<?php

namespace AppBundle\Service\H5P;

use AppBundle\Service\BaseService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class H5PService extends BaseService {
	private $settings;
	private $baseURL;
	private $absoluteH5PExtensionURL;
	private $absoluteH5PLibraryURL;
	private $relativeH5PExtensionURL;
	private $relativeH5PLibraryURL;
	private $scripts = [];
	private $styles = [];
	private $interface = null;
	
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
		$request                       = $this->container->get('request_stack')->getCurrentRequest();
		$this->baseURL                 = $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
		$this->relativeH5PExtensionURL = $request->getBasePath() . '/assets/h5p/extension';
		$this->relativeH5PLibraryURL   = $request->getBasePath() . '/assets/h5p';
		$this->absoluteH5PExtensionURL = $this->baseURL . '/assets/h5p/extension';
		$this->absoluteH5PLibraryURL   = $this->baseURL . '/assets/h5p';
		
		$this->interface             = $h5pF;
		$language                    = $this->getLanguage();
		$this->core                  = new \H5PCore($this->interface, $this->relativeH5PExtensionURL, $this->relativeH5PExtensionURL, $language, true);
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
	
	public function getHtml($id) {
		$content = $this->getContent($id);
		
		return $this->addAssets($content);
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
			return sprintf('Cannot find H5P content with id: %d.', $id);
		}
		
		$content['language'] = $this->getLanguage();
		
		return $content;
	}
	
	public function getCoreSettings() {
		if(empty($this->settings)) {
			$this->settings = array(
				'baseUrl'            => $this->baseURL,
				'url'                => $this->relativeH5PExtensionURL,
				'postUserStatistics' => false,
				'ajax'               => array(
					'setFinished'     => 'http:\/\/localhost\/001\/wordpress\/wp-admin\/admin-ajax.php?token=bb437e0543&action=h5p_setFinished',
					'contentUserData' => 'http:\/\/localhost\/001\/wordpress\/wp-admin\/admin-ajax.php?token=4a4cf5bc89&action=h5p_contents_user_data&content_id=:contentId&data_type=:dataType&sub_content_id=:subContentId'
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
			return '<h1>class-h5p-plugin.php::942</h1><div class="h5p-content" data-content-id="' . $content['id'] . '"></div>';
		} else {
			return '<div class="h5p-iframe-wrapper"><iframe id="h5p-iframe-' . $content['id'] . '" class="h5p-iframe" data-content-id="' . $content['id'] . '" style="height:1px" src="about:blank" frameBorder="0" scrolling="no"></iframe></div>';
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
	public function getContentSettings($content) {
		// TODO: Implement method.
		
		
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
			'exportUrl'       => true ? $this->relativeH5PExtensionURL . '/exports/' . ($content['slug'] ? $content['slug'] . '-' : '') . $content['id'] . '.h5p' : '',
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
	
	public function admin_url($hello) {
		return $hello;
	}
	
	public function plugins_url($hello) {
		return $hello;
	}
	
	public function get_option($a, $default) {
		return $default;
	}
	
	/**
	 * Set core JavaScript settings and add core assets.
	 *
	 * @since 1.0.0
	 */
	public function addCoreAssets() {
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
		
		// Use relative URL to support both http and https.
		$lib_url  = $this->absoluteH5PLibraryURL . '/';
		$rel_path = $this->relativeH5PLibraryURL;
		
		// Add core stylesheets
		foreach(\H5PCore::$styles as $style) {
			$this->settings['core']['styles'][] = $rel_path . $style . $cache_buster;
//			$assetPath                          = $this->asset_handle( 'core-' . $style );
//			wp_enqueue_style( $assetPath, $lib_url . $style, array(), self::VERSION );
			$this->styles[] = $style;
		}
		
		// Add core JavaScript
		foreach(\H5PCore::$scripts as $script) {
			$this->settings['core']['scripts'][] = $rel_path . $script . $cache_buster;
//			wp_enqueue_script( $this->asset_handle( 'core-' . $script ), $lib_url . $script, array(), self::VERSION );
			$this->scripts[] = $script;
		}
	}
	
	/**
	 * Enqueue assets for content embedded by div.
	 *
	 * @param array $assets
	 */
	public function enqueue_assets(&$assets) {
		$abs_url = $this->absoluteH5PExtensionURL;
		$rel_url = $this->relativeH5PExtensionURL;
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
	 * @return array
	 */
	public function getScripts() {
		return $this->scripts;
	}
	
	
	/**
	 * @return array
	 */
	public function getStyles() {
		return $this->styles;
	}
	
	/**
	 * @return mixed
	 */
	public function getSettings() {
		return $this->settings;
	}
	
}