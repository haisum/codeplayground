<?php
/* @var $this yii\web\View */
use app\assets\AceAsset;
use yii\helpers\Html;
$this->title = 'Code Playground';

$frontendConfig = \Yii::$app->params['docker']['jsConfig'];
$frontendConfig['requestUrl'] = \Yii::$app->request->baseUrl . '/execute';
$this->registerJs('
		var App = {};
		App.config = ' . json_encode($frontendConfig)
		, $this::POS_HEAD);

AceAsset::register($this);
?>
<div class="row">
	<div class="col-xs-12">
		<h2>Code Playground Demo</h2>
	</div>
    <div class="col-sm-7">
    	<div class="row">
    		<div class="col-xs-12">
    			<div class="panel panel-primary">
		    		<div class="panel-heading">
		    			<h2 class="panel-title">Code</h2>
		    		</div>
		    		<div class="panel-body">
		    			<div class="form-inline text-right">
			    			<?php
			    				echo Html::label("Language:", 'language');
			    			?>
			    			&nbsp;
			    			<?php
			    				$languages = [];
			    				foreach ($frontendConfig['aceModes'] as $language => $config) {
			    					$languages[$language] = $language;
			    				}
			    				echo Html::dropDownList("language", 
			    					null, 
			    					$languages, 
			    					[
			    						'class' => 'form-control',
			    						'id' => 'language',
			    					]
			    				);
			    			?>
		    			</div>
		    			<br/>
						<pre id="editor"></pre>
		    		</div>
		    		<div class="panel-footer text-right">
		    			<button id="btn-run" class="btn-lg btn-primary btn">Run Code</button>
		    		</div>
		    	</div>
			</div>
		</div>
    </div>
    <div class="col-sm-5">
    	<div class="panel panel-info" id="output">
    		<div class="panel-heading">
    			<h2 class="panel-title">Output</h2>
    		</div>
    		<div class="panel-body">
    			Submit code to see output.
    		</div>
    		<div class="panel-footer hide">
    			
    		</div>
    	</div>
    </div>
</div>