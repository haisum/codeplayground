<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * AceAsset describes asset for ace plugin https://github.com/ajaxorg/ace-builds
 * @author Haisum   <haisumbhatti@gmail.com>
 */
class AceAsset extends AssetBundle
{
    public $sourcePath = '@bower/ace-builds/src-min-noconflict';
    public $js = [
        'ace.js',
    ];

    public function init(){
        $config = \Yii::$app->params['docker']['jsConfig'];
        foreach ($config['aceModes'] as $language => $langConfig) {
            $this->js[] = "mode-" . $langConfig['mode'] . ".js";
        }
        $this->js[] = "theme-" . $config['aceTheme'] . ".js";
        parent::init();
    }
}
