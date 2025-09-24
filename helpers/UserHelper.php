<?php
/*<<<<<USES*/
/*Template:Yii2App/helpers/UserHelper.php*/
namespace app\helpers;

use Yii;

class UserHelper
{
	// No se usa
	public function IAmOwner()
	{
		$blameable = $this->getBehavior('blameable');
		if ($blameable) {
			$created_by = $blameable->createdByAttribute;
			$author = $this->$created_by;
			return $author == Yii::$app->user->getIdentity()->id;
		} else {
			return false;
		}
	}
	public function checkAccessByRole(string $fldname): bool
	{
		if (trim($this->$fldname?:'') == '' || AppHelper::userIsAdmin()) {
			return true;
		}
		$perms = explode(',:;|',$this->$fldname);
		foreach ($perms as $perm) {
			if (Yii::$app->user->can($perm)) {
				return true;
			}
		}
		return false;
	}
/*>>>>>USES*/
/*<<<<<APPHELPER_END*/
} // class AppHelper
/*>>>>>APPHELPER_END*/
