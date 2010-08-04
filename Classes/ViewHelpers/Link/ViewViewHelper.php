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
 * A view helper for creating links to extbase actions.
 *
 * = Examples =
 *
 * <code title="link to the show-action of the current controller">
 * <f:link.action action="show">action link</f:link.action>
 * </code>
 *
 * Output:
 * <a href="index.php?id=123&tx_myextension_plugin[action]=show&tx_myextension_plugin[controller]=Standard&cHash=xyz">action link</f:link.action>
 * (depending on the current page and your TS configuration)
 *
 * @package Fluid
 * @subpackage ViewHelpers
 * @version $Id: ActionViewHelper.php 1492 2009-10-21 16:02:16Z bwaidelich $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @scope prototype
 */
class Tx_CzSimpleCal_ViewHelpers_Link_ViewViewHelper extends Tx_Fluid_ViewHelpers_Link_PageViewHelper {

	/**
	 * Arguments initialization
	 *
	 * @return void
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('view', 'string', 'the view to call', false);
		$this->registerArgument('arguments', 'array', 'arguments to pass as GET params', false, array());
	}

	/**
	 * @param integer $page target page. See TypoLink destination
	 * @param array $additionalParams query parameters to be attached to the resulting URI
	 * @param integer $pageType type of the target page. See typolink.parameter
	 * @param boolean $noCache set this to disable caching for the target page. You should not need this.
	 * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
	 * @param string $section the anchor to be added to the URI
	 * @param boolean $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
	 * @param boolean $absolute If set, the URI of the rendered link is absolute
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @return string Rendered page URI
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	public function render($pageUid = NULL, array $additionalParams = array(), $pageType = 0, $noCache = FALSE, $noCacheHash = FALSE, $section = '', $linkAccessRestrictedPages = FALSE, $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array()) {
		
		$view = strtolower($this->arguments['view']);
		$arguments = $this->arguments['arguments'];
		
		if(is_null($pageUid)) {
			$pageUid = $this->getPageIdByViewName($view);
			if(empty($pageUid)) {
				// if pageUid is empty, no additionalParms are used
				$pageUid = $GLOBALS['TSFE']->id;
			}
		}
		
		$arguments['view'] = $view;
		
		$extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();
		$pluginName = $this->controllerContext->getRequest()->getPluginName();
		$argumentPrefix = strtolower('tx_' . $extensionName . '_' . $pluginName);
		
		$additionalParams[$argumentPrefix] = $arguments;
		
		return parent::render(
			$pageUid,
			$additionalParams,
			$pageType,
			$noCache,
			$noCacheHash,
			$section,
			$linkAccessRestrictedPages,
			$absolute,
			$addQueryString,
			$argumentsToBeExcludedFromQueryString
		);
	}
	
	/**
	 * get the default pageIds for the different views
	 * 
	 * @param $name string
	 * @return integer
	 */
	public function getPageIdByViewName($name) {
		
		if(!isset($this->templateVariableContainer['settings'])) {
			throw new InvalidArgumentException('There were no "settings" set in this template. If you are in a partial, don\'t forget to give the settings from his parents.');
		}
		$settings = &$this->templateVariableContainer['settings'];
		if(!isset($settings['views']) || !array_key_exists($name, $settings['views'])) {
			throw new InvalidArgumentException(sprintf('The view "%s" was not configured.', $name));
		}
		return array_key_exists('defaultPid', $settings['views'][$name]) ?
			$settings['views'][$name]['defaultPid'] : 
			null
		;
	}
}
?>