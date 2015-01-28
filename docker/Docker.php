<?php
namespace app\docker;
use yii\base\InvalidConfigException;
/**
 * 
 */
class Docker{

	private static $_config;
	
	/**
	 * [getConfig description]
	 * @param  [type] $language [description]
	 * @return [type]           [description]
	 */
	public static function verifyConfig($language, $force = false){
		if(isset(self::$_config[$language]) && !$force){
			return self::$_config[$language];
		}
		$errorMessage = false;
		if(!isset(\Yii::$app->params['docker']['httpService'])){
			$errorMessage = "Required config option docker[httpService] is missisng.";
		}
		else if (!isset(\Yii::$app->params['docker']['codeFile'])){
			$errorMessage = "Required config option docker[codeFile] is missisng.";
		}
		else if(!$file = fopen(\Yii::$app->params['docker']['codeFile'], "a")){
			$errorMessage = "Code file " . \Yii::$app->params['docker']['codeFile'] . " is not writable";
		}
		else if(!isset(\Yii::$app->params['docker']['languages'][$language])){
			$errorMessage = "Language $language not set in configuration";
		}
		else if(($langConfig = \Yii::$app->params['docker']['languages'][$language]) && !isset($langConfig['aceModeScript'])){
				$errorMessage = "Required config option docker[languages][$language][aceModeScript] is missisng.";
		}
		else if(!isset($langConfig['command'])){
			$errorMessage = "Required config option docker[languages][$language][command] is missing.";
		}
		else {
			self::$_config[$language] = true;
		}
		fclose($file);

		if(isset(self::$_config[$language]) && self::$_config[$language] === true){
			return self::$_config[$language];
		}
		else{
			self::$_config[$language] = false;
			throw new InvalidConfigException($errorMessage);
			return false;
		}
	}
}