<?php
/*<<<<<MAIN*/
/**
 * Generic Asset for the application
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
/*>>>>>MAIN*/
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
