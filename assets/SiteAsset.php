<?php
/*<<<<<USES*/
/*Template:Yii2App/assets/SiteAsset.php*/
/**
 * bs5 Asset for the 'site' layout
 */
namespace santilin\wrepos\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/themes/light.css',
		'css/site_site.css',
		'css/site_site_print.css',
/*>>>>>USES*/
/*<<<<<JS*/
        // Add your custom css here
	];
    public $js = [
		'js/site_site.js',
/*>>>>>JS*/
/*<<<<<DEPENDS*/
        // Add your custom js here
    ];
    public $depends = [
        'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
		'yii\bootstrap5\BootstrapPluginAsset',
		'yii\bootstrap5\BootstrapIconAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
/*>>>>>DEPENDS*/
/*<<<<<DEPENDS_END*/
        // Add your custom depends here
	];
/*>>>>>DEPENDS_END*/
/*<<<<<MAIN_END*/
} // class Asset
/*>>>>>MAIN_END*/
