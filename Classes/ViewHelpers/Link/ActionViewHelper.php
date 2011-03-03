<?php

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * an enhanced Link_ActionViewHelper that sets the pageUid to link to 
 * automatically by a setting in the settings array
 */
class Tx_CzSimpleCal_ViewHelpers_Link_ActionViewHelper extends Tx_Fluid_ViewHelpers_Link_ActionViewHelper {

	/**
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $controller Target controller. If NULL current controllerName is used
	 * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
	 * @param string $pluginName Target plugin. If empty, the current plugin name is used
	 * @param integer $pageUid target page. See TypoLink destination
	 * @param integer $pageType type of the target page. See typolink.parameter
	 * @param boolean $noCache set this to disable caching for the target page. You should not need this.
	 * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
	 * @param string $section the anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html"
	 * @param boolean $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param boolean $absolute If set, the URI of the rendered link is absolute
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @return string Rendered link
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function render($action = NULL, array $arguments = array(), $controller = NULL, $extensionName = NULL, $pluginName = NULL, $pageUid = NULL, $pageType = 0, $noCache = FALSE, $noCacheHash = FALSE, $section = '', $format = '', $linkAccessRestrictedPages = FALSE, array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array()) {
		if(is_null($pageUid)) {
			$pageUid = $this->getPageUid($controller, $action);
		}
		
		// this is the way it should work
//		return parent::render($action,$arguments, $controller, $extensionName, $pluginName, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format, $linkAccessRestrictedPages,$additionalParams, $absolute, $addQueryString,$argumentsToBeExcludedFromQueryString);
		//@ugly
		/* but as all link viewHelpers return an empty href when linking to a hidden
		 * (or non-existant) page, we'll have to fix this
		 */ 
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder
			->reset()
			->setTargetPageUid($pageUid)
			->setTargetPageType($pageType)
			->setNoCache($noCache)
			->setUseCacheHash(!$noCacheHash)
			->setSection($section)
			->setFormat($format)
			->setLinkAccessRestrictedPages($linkAccessRestrictedPages)
			->setArguments($additionalParams)
			->setCreateAbsoluteUri($absolute)
			->setAddQueryString($addQueryString)
			->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)
			->uriFor($action, $arguments, $controller, $extensionName, $pluginName);

		if(empty($uri)) {
			return $this->renderChildren();
		}
		
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());

		return $this->tag->render();
	}
	
	/**
	 * get the predefined page url
	 * 
	 * @param string $controller
	 * @param string $action
	 */
	protected function getPageUid($controller = NULL, $action = NULL) {
		
		if(!$this->templateVariableContainer->exists('settings')) {
			return null;
		}
		
		if(is_null($controller)) {
			$controller = $this->controllerContext->getRequest()->getControllerName();
		}
		if(is_null($action)) {
			$action = $this->controllerContext->getRequest()->getControllerActionName();
		}
		
		$settings = $this->templateVariableContainer->get('settings');
		if(isset($settings[$controller]['actions'][$action]['defaultPid'])) {
			return empty($settings[$controller]['actions'][$action]['defaultPid']) ? 
				null:
				intval($settings[$controller]['actions'][$action]['defaultPid'])
			;
		}
	}
}
?>