<?php

namespace AppBundle\Service\H5P;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentLibrary;
use AppBundle\Entity\H5P\Dependency;
use AppBundle\Entity\H5P\Library;
use AppBundle\Entity\Media\Media;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;
use stdClass;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppH5PFramework implements \H5PFrameworkInterface {
	/**
	 * @var ContainerInterface $container
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	/**
	 * Returns info for the current platform
	 *
	 * @return array
	 *   An associative array containing:
	 *   - name: The name of the platform, for instance "Wordpress"
	 *   - version: The version of the platform, for instance "4.0"
	 *   - h5pVersion: The version of the H5P plugin/module
	 */
	public function getPlatformInfo() {
		// TODO: Implement getPlatformInfo() method.
	}
	
	/**
	 * Fetches a file from a remote server using HTTP GET
	 *
	 * @param string $url Where you want to get or send data.
	 * @param array  $data Data to post to the URL.
	 * @param bool   $blocking Set to 'FALSE' to instantly time out (fire and forget).
	 * @param string $stream Path to where the file should be saved.
	 *
	 * @return string The content (response body). NULL if something went wrong
	 */
	public function fetchExternalData($url, $data = null, $blocking = true, $stream = null) {
		// TODO: Implement fetchExternalData() method.
	}
	
	/**
	 * Set the tutorial URL for a library. All versions of the library is set
	 *
	 * @param string $machineName
	 * @param string $tutorialUrl
	 */
	public function setLibraryTutorialUrl($machineName, $tutorialUrl) {
		// TODO: Implement setLibraryTutorialUrl() method.
	}
	
	/**
	 * Show the user an error message
	 *
	 * @param string $message
	 *   The error message
	 */
	public function setErrorMessage($message) {
		// TODO: Implement setErrorMessage() method.
	}
	
	/**
	 * Show the user an information message
	 *
	 * @param string $message
	 *  The error message
	 */
	public function setInfoMessage($message) {
		// TODO: Implement setInfoMessage() method.
	}
	
	/**
	 * Translation function
	 *
	 * @param string $message
	 *  The english string to be translated.
	 * @param array  $replacements
	 *   An associative array of replacements to make after translation. Incidences
	 *   of any key in this array are replaced with the corresponding value. Based
	 *   on the first character of the key, the value is escaped and/or themed:
	 *    - !variable: inserted as is
	 *    - @variable: escape plain text to HTML
	 *    - %variable: escape text and theme as a placeholder for user-submitted
	 *      content
	 *
	 * @return string Translated string
	 * Translated string
	 */
	public function t($message, $replacements = array()) {
		// TODO: Implement t() method.
	}
	
	/**
	 * Get URL to file in the specific library
	 *
	 * @param string $libraryFolderName
	 * @param string $fileName
	 *
	 * @return string URL to file
	 */
	public function getLibraryFileUrl($libraryFolderName, $fileName) {
		// TODO: Implement getLibraryFileUrl() method.
	}
	
	/**
	 * Get the Path to the last uploaded h5p
	 *
	 * @return string
	 *   Path to the folder where the last uploaded h5p for this session is located.
	 */
	public function getUploadedH5pFolderPath() {
		// TODO: Implement getUploadedH5pFolderPath() method.
	}
	
	/**
	 * Get the path to the last uploaded h5p file
	 *
	 * @return string
	 *   Path to the last uploaded h5p
	 */
	public function getUploadedH5pPath() {
		// TODO: Implement getUploadedH5pPath() method.
	}
	
	/**
	 * Get a list of the current installed libraries
	 *
	 * @return array
	 *   Associative array containing one entry per machine name.
	 *   For each machineName there is a list of libraries(with different versions)
	 */
	public function loadLibraries() {
		// TODO: Implement loadLibraries() method.
	}
	
	/**
	 * Returns the URL to the library admin page
	 *
	 * @return string
	 *   URL to admin page
	 */
	public function getAdminUrl() {
		// TODO: Implement getAdminUrl() method.
	}
	
	/**
	 * Get id to an existing library.
	 * If version number is not specified, the newest version will be returned.
	 *
	 * @param string $machineName
	 *   The librarys machine name
	 * @param int    $majorVersion
	 *   Optional major version number for library
	 * @param int    $minorVersion
	 *   Optional minor version number for library
	 *
	 * @return int
	 *   The id of the specified library or FALSE
	 */
	public function getLibraryId($machineName, $majorVersion = null, $minorVersion = null) {
		// TODO: Implement getLibraryId() method.
	}
	
	/**
	 * Get file extension whitelist
	 *
	 * The default extension list is part of h5p, but admins should be allowed to modify it
	 *
	 * @param boolean $isLibrary
	 *   TRUE if this is the whitelist for a library. FALSE if it is the whitelist
	 *   for the content folder we are getting
	 * @param string  $defaultContentWhitelist
	 *   A string of file extensions separated by whitespace
	 * @param string  $defaultLibraryWhitelist
	 *   A string of file extensions separated by whitespace
	 */
	public function getWhitelist($isLibrary, $defaultContentWhitelist, $defaultLibraryWhitelist) {
		// TODO: Implement getWhitelist() method.
	}
	
	/**
	 * Is the library a patched version of an existing library?
	 *
	 * @param object $library
	 *   An associative array containing:
	 *   - machineName: The library machineName
	 *   - majorVersion: The librarys majorVersion
	 *   - minorVersion: The librarys minorVersion
	 *   - patchVersion: The librarys patchVersion
	 *
	 * @return boolean
	 *   TRUE if the library is a patched version of an existing library
	 *   FALSE otherwise
	 */
	public function isPatchedLibrary($library) {
		// TODO: Implement isPatchedLibrary() method.
	}
	
	/**
	 * Is H5P in development mode?
	 *
	 * @return boolean
	 *  TRUE if H5P development mode is active
	 *  FALSE otherwise
	 */
	public function isInDevMode() {
		return false;
	}
	
	/**
	 * Is the current user allowed to update libraries?
	 *
	 * @return boolean
	 *  TRUE if the user is allowed to update libraries
	 *  FALSE if the user is not allowed to update libraries
	 */
	public function mayUpdateLibraries() {
		// TODO: Implement mayUpdateLibraries() method.
	}
	
	/**
	 * Store data about a library
	 *
	 * Also fills in the libraryId in the libraryData object if the object is new
	 *
	 * @param object $libraryData
	 *   Associative array containing:
	 *   - libraryId: The id of the library if it is an existing library.
	 *   - title: The library's name
	 *   - machineName: The library machineName
	 *   - majorVersion: The library's majorVersion
	 *   - minorVersion: The library's minorVersion
	 *   - patchVersion: The library's patchVersion
	 *   - runnable: 1 if the library is a content type, 0 otherwise
	 *   - fullscreen(optional): 1 if the library supports fullscreen, 0 otherwise
	 *   - embedTypes(optional): list of supported embed types
	 *   - preloadedJs(optional): list of associative arrays containing:
	 *     - path: path to a js file relative to the library root folder
	 *   - preloadedCss(optional): list of associative arrays containing:
	 *     - path: path to css file relative to the library root folder
	 *   - dropLibraryCss(optional): list of associative arrays containing:
	 *     - machineName: machine name for the librarys that are to drop their css
	 *   - semantics(optional): Json describing the content structure for the library
	 *   - language(optional): associative array containing:
	 *     - languageCode: Translation in json format
	 * @param bool   $new
	 *
	 * @return
	 */
	public function saveLibraryData(&$libraryData, $new = true) {
		// TODO: Implement saveLibraryData() method.
	}
	
	/**
	 * Insert new content.
	 *
	 * @param array $content
	 *   An associative array containing:
	 *   - id: The content id
	 *   - params: The content in json format
	 *   - library: An associative array containing:
	 *     - libraryId: The id of the main library for this content
	 * @param int   $contentMainId
	 *   Main id for the content if this is a system that supports versions
	 */
	public function insertContent($content, $contentMainId = null) {
		// TODO: Implement insertContent() method.
	}
	
	/**
	 * Update old content.
	 *
	 * @param array $content
	 *   An associative array containing:
	 *   - id: The content id
	 *   - params: The content in json format
	 *   - library: An associative array containing:
	 *     - libraryId: The id of the main library for this content
	 * @param int   $contentMainId
	 *   Main id for the content if this is a system that supports versions
	 */
	public function updateContent($content, $contentMainId = null) {
		// TODO: Implement updateContent() method.
	}
	
	/**
	 * Resets marked user data for the given content.
	 *
	 * @param int $contentId
	 */
	public function resetContentUserData($contentId) {
		// TODO: Implement resetContentUserData() method.
	}
	
	/**
	 * Save what libraries a library is depending on
	 *
	 * @param int    $libraryId
	 *   Library Id for the library we're saving dependencies for
	 * @param array  $dependencies
	 *   List of dependencies as associative arrays containing:
	 *   - machineName: The library machineName
	 *   - majorVersion: The library's majorVersion
	 *   - minorVersion: The library's minorVersion
	 * @param string $dependency_type
	 *   What type of dependency this is, the following values are allowed:
	 *   - editor
	 *   - preloaded
	 *   - dynamic
	 */
	public function saveLibraryDependencies($libraryId, $dependencies, $dependency_type) {
		// TODO: Implement saveLibraryDependencies() method.
	}
	
	/**
	 * Give an H5P the same library dependencies as a given H5P
	 *
	 * @param int $contentId
	 *   Id identifying the content
	 * @param int $copyFromId
	 *   Id identifying the content to be copied
	 * @param int $contentMainId
	 *   Main id for the content, typically used in frameworks
	 *   That supports versions. (In this case the content id will typically be
	 *   the version id, and the contentMainId will be the frameworks content id
	 */
	public function copyLibraryUsage($contentId, $copyFromId, $contentMainId = null) {
		// TODO: Implement copyLibraryUsage() method.
	}
	
	/**
	 * Deletes content data
	 *
	 * @param int $contentId
	 *   Id identifying the content
	 */
	public function deleteContentData($contentId) {
		// TODO: Implement deleteContentData() method.
	}
	
	/**
	 * Delete what libraries a content item is using
	 *
	 * @param int $contentId
	 *   Content Id of the content we'll be deleting library usage for
	 */
	public function deleteLibraryUsage($contentId) {
		// TODO: Implement deleteLibraryUsage() method.
	}
	
	/**
	 * Saves what libraries the content uses
	 *
	 * @param int   $contentId
	 *   Id identifying the content
	 * @param array $librariesInUse
	 *   List of libraries the content uses. Libraries consist of associative arrays with:
	 *   - library: Associative array containing:
	 *     - dropLibraryCss(optional): comma separated list of machineNames
	 *     - machineName: Machine name for the library
	 *     - libraryId: Id of the library
	 *   - type: The dependency type. Allowed values:
	 *     - editor
	 *     - dynamic
	 *     - preloaded
	 */
	public function saveLibraryUsage($contentId, $librariesInUse) {
		// TODO: Implement saveLibraryUsage() method.
	}
	
	/**
	 * Get number of content/nodes using a library, and the number of
	 * dependencies to other libraries
	 *
	 * @param int $libraryId
	 *   Library identifier
	 *
	 * @return array
	 *   Associative array containing:
	 *   - content: Number of content using the library
	 *   - libraries: Number of libraries depending on the library
	 */
	public function getLibraryUsage($libraryId) {
		// TODO: Implement getLibraryUsage() method.
	}
	
	/**
	 * Loads a library
	 *
	 * @param string $machineName
	 *   The library's machine name
	 * @param int    $majorVersion
	 *   The library's major version
	 * @param int    $minorVersion
	 *   The library's minor version
	 *
	 * @return array|FALSE
	 *   FALSE if the library does not exist.
	 *   Otherwise an associative array containing:
	 *   - libraryId: The id of the library if it is an existing library.
	 *   - title: The library's name
	 *   - machineName: The library machineName
	 *   - majorVersion: The library's majorVersion
	 *   - minorVersion: The library's minorVersion
	 *   - patchVersion: The library's patchVersion
	 *   - runnable: 1 if the library is a content type, 0 otherwise
	 *   - fullscreen(optional): 1 if the library supports fullscreen, 0 otherwise
	 *   - embedTypes(optional): list of supported embed types
	 *   - preloadedJs(optional): comma separated string with js file paths
	 *   - preloadedCss(optional): comma separated sting with css file paths
	 *   - dropLibraryCss(optional): list of associative arrays containing:
	 *     - machineName: machine name for the librarys that are to drop their css
	 *   - semantics(optional): Json describing the content structure for the library
	 *   - preloadedDependencies(optional): list of associative arrays containing:
	 *     - machineName: Machine name for a library this library is depending on
	 *     - majorVersion: Major version for a library this library is depending on
	 *     - minorVersion: Minor for a library this library is depending on
	 *   - dynamicDependencies(optional): list of associative arrays containing:
	 *     - machineName: Machine name for a library this library is depending on
	 *     - majorVersion: Major version for a library this library is depending on
	 *     - minorVersion: Minor for a library this library is depending on
	 *   - editorDependencies(optional): list of associative arrays containing:
	 *     - machineName: Machine name for a library this library is depending on
	 *     - majorVersion: Major version for a library this library is depending on
	 *     - minorVersion: Minor for a library this library is depending on
	 */
	public function loadLibrary($machineName, $majorVersion, $minorVersion) {
//		global $wpdb;

//		$library = $wpdb->get_row($wpdb->prepare(
//			"SELECT id as libraryId, name as machineName, title, major_version as majorVersion, minor_version as minorVersion, patch_version as patchVersion,
//          embed_types as embedTypes, preloaded_js as preloadedJs, preloaded_css as preloadedCss, drop_library_css as dropLibraryCss, fullscreen, runnable,
//          semantics, has_icon as hasIcon
//        FROM {$wpdb->prefix}h5p_libraries
//        WHERE name = %s
//        AND major_version = %d
//        AND minor_version = %d",
//			$name,
//			$majorVersion,
//			$minorVersion),
//			ARRAY_A
//		);
		/** @var QueryBuilder $libraryQb */
		$libraryQb = $this->container->get('doctrine')->getManager()->createQueryBuilder();
		$expr      = $libraryQb->expr();
		$libraryQb->select(array(
			'lib.id as libraryId',
			'lib.machineName',
			'lib.title',
			'lib.majorVersion',
			'lib.minorVersion',
			'lib.patchVersion',
			'lib.embedTypes',
			'lib.preloadedJs',
			'lib.preloadedCss',
			'lib.dropLibraryCss',
			'lib.fullscreen',
			'lib.runnable',
			'lib.semantics',
			'lib.iconIncluded as hasIcon'
		))->from(Library::class, 'lib')
		          ->where(
			          $expr->andX(
				          $expr->eq('lib.machineName', ':libName'),
				          $expr->eq('lib.majorVersion', ':libMajorVersion'),
				          $expr->eq('lib.minorVersion', ':libMinorVersion')
			          )
		          )
		          ->setParameter('libName', $machineName)
		          ->setParameter('libMajorVersion', $majorVersion)
		          ->setParameter('libMinorVersion', $minorVersion);
		
		$library = $libraryQb->getQuery()->setMaxResults(1)->getOneOrNullResult();
		
		/** @var QueryBuilder $dependencyQb */
		$dependencyQb = $this->container->get('doctrine')->getManager()->createQueryBuilder();
		$dependencyQb->select(
			array(
				'dependee.machineName',
				'dependee.majorVersion',
				'dependee.minorVersion',
				'o.dependencyType',
			)
		)->from(Dependency::class, 'o')
		             ->join('o.dependee', 'dependee')
		             ->join('o.dependency', 'dependency')
		             ->where($expr->eq('dependency.id', ':dependencyId'))
		             ->setParameter('dependencyId', $library['libraryId']);
		
		$query        = $dependencyQb->getQuery()->getSQL();
		$dependencies = $dependencyQb->getQuery()->getResult();

//		$dependencies = $wpdb->get_results($wpdb->prepare(
//			"SELECT hl.name as machineName, hl.major_version as majorVersion, hl.minor_version as minorVersion, hll.dependency_type as dependencyType
//        FROM {$wpdb->prefix}h5p_libraries_libraries hll
//        JOIN {$wpdb->prefix}h5p_libraries hl ON hll.required_library_id = hl.id
//        WHERE hll.library_id = %d",
//			$library['libraryId'])
//		);
		
		foreach($dependencies as $dependency) {
			$library[ $dependency['dependencyType'] . 'Dependencies' ][] = array(
				'machineName'  => $dependency['machineName'],
				'majorVersion' => $dependency['majorVersion'],
				'minorVersion' => $dependency['minorVersion'],
			);
		}
		
		if($this->isInDevMode()) {
			$semantics = $this->getSemanticsFromFile($library['machineName'], $library['majorVersion'], $library['minorVersion']);
			if($semantics) {
				$library['semantics'] = $semantics;
			}
		}
		
		return $library;
	}
	
	
	/**
	 * Loads library semantics.
	 *
	 * @param string $machineName
	 *   Machine name for the library
	 * @param int    $majorVersion
	 *   The library's major version
	 * @param int    $minorVersion
	 *   The library's minor version
	 *
	 * @return string
	 *   The library's semantics as json
	 */
	public function loadLibrarySemantics($machineName, $majorVersion, $minorVersion) {
//		global $wpdb;
		$semantics = $this->getSemanticsFromFile($machineName, $majorVersion, $minorVersion);
//		if ($this->isInDevMode()) {
//			$semantics = $this->getSemanticsFromFile($name, $majorVersion, $minorVersion);
//		}
//		else {
//			$semantics = $wpdb->get_var($wpdb->prepare(
//				"SELECT semantics
//          FROM {$wpdb->prefix}h5p_libraries
//          WHERE name = %s
//          AND major_version = %d
//          AND minor_version = %d",
//				$name, $majorVersion, $minorVersion)
//			);
//		}
		return ($semantics === false ? null : $semantics);
	}
	
	private function getSemanticsFromFile($name, $majorVersion, $minorVersion) {
		$semanticsPath = $this->container->getParameter('kernel.root_dir') . '/../web/assets/h5p/extension' . '/libraries/' . $name . '-' . $majorVersion . '.' . $minorVersion . '/semantics.json';
		if(file_exists($semanticsPath)) {
			$semantics = file_get_contents($semanticsPath);
			if( ! json_decode($semantics, true)) {
				$this->setErrorMessage($this->t('Invalid json in semantics for %library', array( '%library' => $name )));
			}
			
			return $semantics;
		}
		
		return false;
	}
	
	
	/**
	 * Makes it possible to alter the semantics, adding custom fields, etc.
	 *
	 * @param array  $semantics
	 *   Associative array representing the semantics
	 * @param string $machineName
	 *   The library's machine name
	 * @param int    $majorVersion
	 *   The library's major version
	 * @param int    $minorVersion
	 *   The library's minor version
	 */
	public function alterLibrarySemantics(&$semantics, $machineName, $majorVersion, $minorVersion) {
		// TODO: Implement alterLibrarySemantics() method.
	}
	
	/**
	 * Delete all dependencies belonging to given library
	 *
	 * @param int $libraryId
	 *   Library identifier
	 */
	public function deleteLibraryDependencies($libraryId) {
		// TODO: Implement deleteLibraryDependencies() method.
	}
	
	/**
	 * Start an atomic operation against the dependency storage
	 */
	public function lockDependencyStorage() {
		// TODO: Implement lockDependencyStorage() method.
	}
	
	/**
	 * Stops an atomic operation against the dependency storage
	 */
	public function unlockDependencyStorage() {
		// TODO: Implement unlockDependencyStorage() method.
	}
	
	/**
	 * Delete a library from database and file system
	 *
	 * @param stdClass $library
	 *   Library object with id, name, major version and minor version.
	 */
	public function deleteLibrary($library) {
		// TODO: Implement deleteLibrary() method.
	}
	
	/**
	 * Load content.
	 *
	 * @param int $id
	 *   Content identifier
	 *
	 * @return array
	 *   Associative array containing:
	 *   - contentId: Identifier for the content
	 *   - params: json content as string
	 *   - embedType: csv of embed types
	 *   - title: The contents title
	 *   - language: Language code for the content
	 *   - libraryId: Id for the main library
	 *   - libraryName: The library machine name
	 *   - libraryMajorVersion: The library's majorVersion
	 *   - libraryMinorVersion: The library's minorVersion
	 *   - libraryEmbedTypes: CSV of the main library's embed types
	 *   - libraryFullscreen: 1 if fullscreen is supported. 0 otherwise.
	 */
	public function loadContent($id) {
//		$content = [
//			'id'     => "1",
//			'title'  => "Quiz 1",
//			'params' => '{"media":{"params":{"contentName":"Image","file":{"path":"images/file-592da00abe776.jpg","mime":"image/jpeg","copyright":{"license":"U"},"width":800,"height":800},"alt":"sample ALternative Text","title":"sample hover text"},"library":"H5P.Image 1.0","subContentId":"d9fa0034-a59f-447e-a2c6-61da8c09e8d5"},"answers":[{"correct":false,"tipsAndFeedback":{"tip":"<p>sapmle tip for q1</p>\n","chosenFeedback":"<div>sample displayed message if answer is selected</div>\n","notChosenFeedback":"<div>sample msg if not selected</div>\n"},"text":"<div>option 1 text incorrect</div>\n"},{"correct":true,"tipsAndFeedback":{"tip":"<p>tip</p>\n","chosenFeedback":"<div>selected</div>\n","notChosenFeedback":"<div>why not selected</div>\n"},"text":"<div>option 1 text <strong>correct</strong></div>\n"}],"UI":{"checkAnswerButton":"Check","showSolutionButton":"Show solution","tryAgainButton":"Retry","tipsLabel":"Show tip","scoreBarLabel":"Score","tipAvailable":"Tip available","feedbackAvailable":"Feedback availab"}}',
//
//			'filtered'            =>
//				'{"media":{"params":{"contentName":"Image","file":{"path":"images\/file-592da00abe776.jpg","mime":"image\/jpeg","copyright":{"license":"U"},"width":800,"height":800},"alt":"sample ALternative Text","title":"sample hover text"},"library":"H5P.Image 1.0","subContentId":"d9fa0034-a59f-447e-a2c6-61da8c09e8d5"},"answers":[{"correct":false,"tipsAndFeedback":{"tip":"<p>sapmle tip for q1<\/p>\n","chosenFeedback":"<div>sample displayed message if answer is selected<\/div>\n","notChosenFeedback":"<div>sample msg if not selected<\/div>\n"},"text":"<div>option 1 text incorrect<\/div>\n"},{"correct":true,"tipsAndFeedback":{"tip":"<p>tip<\/p>\n","chosenFeedback":"<div>selected<\/div>\n","notChosenFeedback":"<div>why not selected<\/div>\n"},"text":"<div>option 1 text <strong>correct<\/strong><\/div>\n"}],"UI":{"checkAnswerButton":"Check","showSolutionButton":"Show solution","tryAgainButton":"Retry","tipsLabel":"Show tip","scoreBarLabel":"Score","tipAvailable":"Tip available","feedbackAvailable":"Feedback available","readFeedback":"Read feedback","wrongAnswer":"Wrong answer","correctAnswer":"Correct answer","feedback":"You got @score of @total points","shouldCheck":"Should have been checked","shouldNotCheck":"Should not have been checked","noInput":"Please answer before viewing the solution"},"behaviour":{"enableRetry":true,"enableSolutionsButton":true,"type":"auto","singlePoint":true,"randomAnswers":true,"showSolutionsRequiresInput":true,"disableImageZooming":false,"confirmCheckDialog":false,"confirmRetryDialog":false,"autoCheck":true,"passPercentage":100},"confirmCheck":{"header":"Finish ?","body":"Are you sure you wish to finish ?","cancelLabel":"Cancel","confirmLabel":"Finish"},"confirmRetry":{"header":"Retry ?","body":"Are you sure you wish to retry ?","cancelLabel":"Cancel","confirmLabel":"Confirm"},"question":"<p>Question 1<\/p>\n"}'
//			,
//			'slug'                => "quiz-1",
//			'user_id'             => "1",
//			'embedType'           => "div",
//			'disable'             => "15",
//			'libraryId'           => "6",
//			'libraryName'         => "H5P.MultiChoice",
//			'libraryMajorVersion' => "1",
//			'libraryMinorVersion' => "9",
//			'libraryEmbedTypes'   => "",
//			'libraryFullscreen'   => "0"
//		];
		/** @var QueryBuilder $contentQb */
		$contentQb = $this->container->get('doctrine')->getManager()->createQueryBuilder();
		$expr      = $contentQb->expr();
		$contentQb->select(array(
			'content.id',
			'content.title',
			'content.parameters as params',
			'content.filtered',
			'content.slug',
			'owner.id as user_id',
			'content.embedType',
			'content.disable',
			'library.id as libraryId',
			'library.machineName as libraryName',
//			'library.title',
			'library.majorVersion as libraryMajorVersion',
			'library.minorVersion as libraryMinorVersion',
			'library.patchVersion',
			'library.embedTypes as libraryEmbedTypes',
			'library.fullscreen as libraryFullscreen'
		))->from(Content::class, 'content')
		          ->join('content.library', 'library')
		          ->leftJoin('content.owner', 'owner')
		          ->where(
			          $expr->like('content.id', ':contentId')
		          )
		          ->setParameter('contentId', $id);
		
		$content = $contentQb->getQuery()->setMaxResults(1)->getOneOrNullResult();

//				$sql = $contentQb->getQuery()->getSQL();
		
		if( ! empty($content)) {
			$fileServerUrl = $this->container->get('app.site')->getFileServerURLWithScheme();
			$filePathStart = '<filePath=';
			$filePathEnd   = '>';
			while(($filePathStartPos = strpos($content['params'], $filePathStart)) > - 1) {
				$filePathEndPos      = strpos($content['params'], $filePathEnd);
				$mediaIdExt          = substr($content['params'], $filePathStartPos += 10, $filePathEndPos - $filePathStartPos);
				$filePathShortCode   = $filePathStart . $mediaIdExt . $filePathEnd;
				$mediaUrl            = $fileServerUrl . '/file.php?f=' . $mediaIdExt;
				$content['params']   = str_replace($filePathShortCode, $mediaUrl, $content['params']);
				$content['filtered'] = str_replace($filePathShortCode, substr(json_encode($mediaUrl), 1, - 1), $content['filtered']);
			}
//			$medium = $this->container->get('doctrine.orm.default_entity_manager')->getRepository(Media::class)->find($mediaId);
		
		}
		
		return $content;
	}
	
	/**
	 * Load dependencies for the given content of the given type.
	 *
	 * @param int $id
	 *   Content identifier
	 * @param int $type
	 *   Dependency types. Allowed values:
	 *   - editor
	 *   - preloaded
	 *   - dynamic
	 *
	 * @return array
	 *   List of associative arrays containing:
	 *   - libraryId: The id of the library if it is an existing library.
	 *   - machineName: The library machineName
	 *   - majorVersion: The library's majorVersion
	 *   - minorVersion: The library's minorVersion
	 *   - patchVersion: The library's patchVersion
	 *   - preloadedJs(optional): comma separated string with js file paths
	 *   - preloadedCss(optional): comma separated sting with css file paths
	 *   - dropCss(optional): csv of machine names
	 */
	public function loadContentDependencies($id, $type = null) {
		/** @var QueryBuilder $libraryQb */
		$libraryQb = $this->container->get('doctrine')->getManager()->createQueryBuilder();
		$expr      = $libraryQb->expr();
		$libraryQb->select(array(
			'contentLibrary.dropCSS as dropCss',
			'contentLibrary.dependencyType',
			'library.id as libraryId',
			'library.machineName',
			'library.title',
			'library.majorVersion',
			'library.minorVersion',
			'library.patchVersion',
			'library.embedTypes',
			'library.preloadedJs',
			'library.preloadedCss'
		))->from(ContentLibrary::class, 'contentLibrary')
		          ->join('contentLibrary.content', 'content')
		          ->join('contentLibrary.library', 'library')
		          ->where(
			          $expr->eq('content.id', ':contentId')
		          )
		          ->setParameter('contentId', $id)
		          ->orderBy('contentLibrary.position', 'ASC');
		
		return $libraryQb->getQuery()->getResult();
	}
	
	/**
	 * Get stored setting.
	 *
	 * @param string $name
	 *   Identifier for the setting
	 * @param string $default
	 *   Optional default value if settings is not set
	 *
	 * @return mixed
	 *   Whatever has been stored as the setting
	 */
	public function getOption($name, $default = null) {
		// TODO: Implement getOption() method.
	}
	
	/**
	 * Stores the given setting.
	 * For example when did we last check h5p.org for updates to our libraries.
	 *
	 * @param string $name
	 *   Identifier for the setting
	 * @param mixed  $value Data
	 *   Whatever we want to store as the setting
	 */
	public function setOption($name, $value) {
		// TODO: Implement setOption() method.
	}
	
	/**
	 * This will update selected fields on the given content.
	 *
	 * @param int   $id Content identifier
	 * @param array $fields Content fields, e.g. filtered or slug.
	 */
	public function updateContentFields($id, $fields) {
		// TODO: Implement updateContentFields() method.
	}
	
	/**
	 * Will clear filtered params for all the content that uses the specified
	 * library. This means that the content dependencies will have to be rebuilt,
	 * and the parameters re-filtered.
	 *
	 * @param int $library_id
	 */
	public function clearFilteredParameters($library_id) {
		// TODO: Implement clearFilteredParameters() method.
	}
	
	/**
	 * Get number of contents that has to get their content dependencies rebuilt
	 * and parameters re-filtered.
	 *
	 * @return int
	 */
	public function getNumNotFiltered() {
		// TODO: Implement getNumNotFiltered() method.
	}
	
	/**
	 * Get number of contents using library as main library.
	 *
	 * @param int $libraryId
	 *
	 * @return int
	 */
	public function getNumContent($libraryId) {
		// TODO: Implement getNumContent() method.
	}
	
	/**
	 * Determines if content slug is used.
	 *
	 * @param string $slug
	 *
	 * @return boolean
	 */
	public function isContentSlugAvailable($slug) {
		// TODO: Implement isContentSlugAvailable() method.
	}
	
	/**
	 * Generates statistics from the event log per library
	 *
	 * @param string $type Type of event to generate stats for
	 *
	 * @return array Number values indexed by library name and version
	 */
	public function getLibraryStats($type) {
		// TODO: Implement getLibraryStats() method.
	}
	
	/**
	 * Aggregate the current number of H5P authors
	 * @return int
	 */
	public function getNumAuthors() {
		// TODO: Implement getNumAuthors() method.
	}
	
	/**
	 * Stores hash keys for cached assets, aggregated JavaScripts and
	 * stylesheets, and connects it to libraries so that we know which cache file
	 * to delete when a library is updated.
	 *
	 * @param string $key
	 *  Hash key for the given libraries
	 * @param array  $libraries
	 *  List of dependencies(libraries) used to create the key
	 */
	public function saveCachedAssets($key, $libraries) {
		// TODO: Implement saveCachedAssets() method.
	}
	
	/**
	 * Locate hash keys for given library and delete them.
	 * Used when cache file are deleted.
	 *
	 * @param int $library_id
	 *  Library identifier
	 *
	 * @return array
	 *  List of hash keys removed
	 */
	public function deleteCachedAssets($library_id) {
		// TODO: Implement deleteCachedAssets() method.
	}
	
	/**
	 * Get the amount of content items associated to a library
	 * return int
	 */
	public function getLibraryContentCount() {
		// TODO: Implement getLibraryContentCount() method.
	}
	
	/**
	 * Will trigger after the export file is created.
	 */
	public function afterExportCreated($content, $filename) {
		// TODO: Implement afterExportCreated() method.
	}
	
	/**
	 * Check if user has permissions to an action
	 *
	 * @method hasPermission
	 * @param  [H5PPermission] $permission Permission type, ref H5PPermission
	 * @param  [int]           $id         Id need by platform to determine permission
	 *
	 * @return boolean
	 */
	public function hasPermission($permission, $id = null) {
		// TODO: Implement hasPermission() method.
	}
	
	/**
	 * Replaces existing content type cache with the one passed in
	 *
	 * @param object $contentTypeCache Json with an array called 'libraries'
	 *  containing the new content type cache that should replace the old one.
	 */
	public function replaceContentTypeCache($contentTypeCache) {
		// TODO: Implement replaceContentTypeCache() method.
	}
}