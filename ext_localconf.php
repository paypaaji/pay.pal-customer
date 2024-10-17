<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	"@import 'EXT:call_to_actions/Configuration/TsConfig/Page/Mod/Wizards/CallToActions.tsconfig'"
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
	'call_to_actions',
	'setup',
	"@import 'EXT:call_to_actions/Configuration/TypoScript/setup.typoscript'"
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['liquidlight_call_to_actions'] =
	\LiquidLight\CallToActions\Hooks\PageLayoutView\CallToActionsElementPreviewRenderer::class;


/**
 * Icon
 */
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
	->registerIcon(
		'liquidlight_call_to_actions',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:call_to_actions/Resources/Public/Icons/Extension.svg']
	)
;
