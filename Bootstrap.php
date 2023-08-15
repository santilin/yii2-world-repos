<?php
namespace santilin\wrepos;

use yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

/**
 * Bootstrap class of the yii2-sqlite3-full-support extension.
 */
class Bootstrap implements BootstrapInterface
{
	/**
	 * Registers module translation messages.
	 *
	 * @param Application $app
	 *
	 * @throws InvalidConfigException
	 */
	public function bootstrap($app)
	{
		if (!isset($app->get('i18n')->translations['wrepos*'])) {
			$app->get('i18n')->translations['wrepos*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/messages',
				'sourceLanguage' => 'en-US',
			];
		}
		Yii::setAlias('@wrepos', __DIR__);
	}

} // class Bootstrap
