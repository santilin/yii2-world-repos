<?php
/*<<<<<USES*/
/*Template:Yii2App/helpers/UserHelper.php*/
namespace app\helpers;

use Yii;

class UserHelper
{
	public function checkAccessByRole(mixed $model, string $fldname): bool
	{
		if (trim($model->getAttribute($fldname) ?? '') === '' || self::userIsAdmin()) {
			return true;
		}
		$perms = explode(',:;|', $model->getAttribute($fldname));
		foreach ($perms as $perm) {
			if (Yii::$app->user->can($perm)) {
				return true;
			}
		}
		return false;
	}
/*>>>>>USES*/
/*<<<<<REDIRECT_AFTER_LOGIN*/
	public static function setReturnUrl($user_component, $user)
	{
		$r = $user_component->getReturnUrl();
		$h = \Yii::$app->getHomeUrl();
		$b = \yii\helpers\Url::base(true);
		if ($r === $h || $r === $b || $r === "$b/") {
			$modules = \app\components\Capel::getModules();
/*>>>>>REDIRECT_AFTER_LOGIN*/
/*<<<<<REDIRECT_AFTER_LOGIN.MODULES*/
			// admin access
			foreach ($modules as $module => $module_info) {
				if (in_array('admin', $module_info['access'] ?? [], true)) {
					if (self::userIsAdmin()) {
						$user_component->setReturnUrl(["/" . $module_info['prefix'] ?? '']);
						return;
					}
				}
			}
			// module access
			foreach ($modules as $module => $module_info) {
				if (in_array('module', $module_info['access'] ?? [], true)) {
					if ($user->username === $module || $user_component?->can($module)) {
						$user_component->setReturnUrl(["/" . $module_info['prefix'] ?? '']);
						return;
					}
				}
			}
			// rbac access
			foreach ($modules as $module => $module_info) {
				if (in_array('rbac', $module_info['access'] ?? [], true)) {
					if ($user_component?->can("{$module}.admin")
					|| $user_component?->can($module)) {
						$user_component->setReturnUrl(["/" . $module_info['prefix'] ?? '']);
						return;
					}
				}
			}
			// logged access
			foreach ($modules as $module => $module_info) {
				if (in_array('logged', $module_info['access'] ?? [], true)) {
					$user_component->setReturnUrl(["/" . $module_info['prefix'] ?? '']);
					return;
				}
			}
		}
	}
/*>>>>>REDIRECT_AFTER_LOGIN.MODULES*/
/*<<<<<APPHELPER_END*/
} // class AppHelper
/*>>>>>APPHELPER_END*/
