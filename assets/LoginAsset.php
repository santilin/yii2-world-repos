<?php
/*<<<<<MAIN*/
/**
 * Bootstrap3 assets for login form which uses yii2-usuario
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
/*>>>>>MAIN*/
        // Add your custom css here
/*<<<<<JS*/
	];
    public $js = [
/*>>>>>JS*/
        // Add your custom js here

/*<<<<<DEPENDS*/
    ];
    public $depends = [
        'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset', // 2amigos/yii-user uses bs3
/*>>>>>DEPENDS*/
        // Add your custom depends here

/*<<<<<DEPENDS_END*/
	];
/*>>>>>DEPENDS_END*/
/*<<<<<MAIN_END*/
} // class LoginAsset
/*>>>>>MAIN_END*/

