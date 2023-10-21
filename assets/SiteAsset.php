<?php
/*<<<<<USES*/
/*Template:Yii2App/assets/SiteAsset.php*/
/**
 * BS4 Asset for the 'site' layout
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
		'css/site.css',
		'css/themes/light.css',
/*>>>>>USES*/
/*<<<<<JS*/
        // Add your custom css here
	];
    public $js = [
		'js/site.js',
/*>>>>>JS*/
/*<<<<<DEPENDS*/
        // Add your custom js here
    ];
    public $depends = [
        'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
		'yii\bootstrap4\BootstrapPluginAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
/*>>>>>DEPENDS*/
/*<<<<<DEPENDS_END*/
        // Add your custom depends here
	];
/*>>>>>DEPENDS_END*/
/*<<<<<MAIN_END*/
} // class Asset
/*>>>>>MAIN_END*/
