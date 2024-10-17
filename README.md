# Call to Actions

_**Note**:_ This readme is **very much** in draft and needs to be written properly

The Call to Actions extension allows you to have shared Call to Action/Promo boxes which are then displayed throughout the site. It gives editors and integrators a single place to add, edit and update website Call to Actions (CTAs).

CTAs can be shared between multi-site instances and can be customised with different types and themes, along with having styled buttons and images

# To Do

- Create proper TYPO documentation
- Make the plugin appear in the wizard in version 10
- Add new icon

## Installation

Install via the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/call_to_actions) or composer:

```
composer req liquidlight/typo3-call-to-actions
```

Create a SysFolder (called "Call to Actions" or similar) and create a new "Call to Action" record inside

_**Hint**:_ If you only want Call to Actions to be made in this SysFolder, edit the page and add the following to the **Page TSconfig `[TSconfig]`** field

```
mod.web_list.allowedNewTables = tx_calltoactions_domain_model_calltoactions
```

Once the Call to Action record is made, navigate to the page you wish to add it and create a new content element

**Plugins** -> **Call to Actions**

Using the Items browser, select the Call to Action you wish to display

_**Note**:_ The whole page tree is displayed as Call to Action records can be created anywhere

## Customisation

### Templates

If you wish to override the `Templates` or `Partials`, add the following to your `constants` (replacing `site_package` with the name of your custom site package extension)

```
site.fluidtemplate.call_to_actions {
	templateRootPath = EXT:site_package/Resources/Private/Templates
	partialRootPath = EXT:site_package/Resources/Private/Partials
}
```

From create a files which are the same names as the originals

- Template: [`CallToActions.html`](./Resources/Private/Templates/CallToActions.html)
- Partials: [`CallToAction.html`](./Resources/Private/Partials/CallToAction.html)

You may also wish to overwrite the Button, Image or Details partial too - which can be found [in the Partials folder](./Resources/Private/Partials)

## Types & Themes

If you wish to change or add to the Theme and Types dropdowns, you can do this via Typoscript

Add the following to `setup`

```
tt_content.call_to_actions {
	classes {
		type {
			0 {
				title = Simple
				value = simple
			}
			1 {
				title = Featured
				value = featured
			}
		}

		theme {
			0 {
				title = Light
				value = light
			}
			1 {
				title = Dark
				value = dark
			}
		}
	}
```

The numbers are indexes - if you wish to replace one use the same index, however if you only want to add then you can include just that one with an incremental number

`title` is what is shown in the drop down, while `value` is what is output in the template.

e.g.

```
tt_content.call_to_actions {
	classes.type {
		2 {
			title = Highlight
			value = highlightCTA
		}
	}
}
```

### Relating to records

**_Note_:** Experience in overriding TCAs is required for this

If you want to add Call to Actions on a specific record, such as News or any other custom record type, you will need to override the TCA.

In the example below, a field is added after the `bodytext` on the `tt_news` table

```php
<?php

defined('TYPO3_MODE') or die();

call_user_func(function () {
	$columns = [
		'tx_sitepackage_call_to_actions' => [
			'label' => 'LLL:EXT:call_to_actions/Resources/Private/Language/locallang.xlf:call_to_actions',
			'config' => [
				'default' => '12',
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_calltoactions_domain_model_calltoactions',
				'foreign_table_where' => 'AND tx_calltoactions_domain_model_calltoactions.sys_language_uid IN (-1,0)
					ORDER BY tx_calltoactions_domain_model_calltoactions.title ASC',
				'minitems' => 0,
				'maxitems' => 100,
				'size' => 10,
			],
		],
	];
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_news', $columns);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
		'tt_news',
		'tx_sitepackage_call_to_actions',
		'',
		'after:bodytext'
	);
});
```

Next, add the field to the `ext_tables.sql` file in your `site_package`

```sql
#
# Table structure for table 'tt_news'
#
CREATE TABLE tt_news (
	tx_sitepackage_call_to_actions text,
);
```

Update the database schema to add the new field.

To render the promos in your template will depend on how your record is rendered - an example snippet of PHP to do this is:

```php
$cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);

/**
 * Promos
 */
// Get the default config
$ctas = $GLOBALS['TSFE']->tmpl->setup['tt_content.']['call_to_actions.'];
// Set the records to be our UIDs
$ctas['dataProcessing.']['100.']['uidInList'] = $record['promos'];
// Remove the field gathering
unset($ctas['dataProcessing.']['100.']['uidInList.']);
// Render the element
$record['promos'] = $cObj->cObjGetSingle('FLUIDTEMPLATE', $ctas);
```
