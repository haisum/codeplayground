<?php
namespace app\docker;
use app\docker\Docker;
/**
 * Shell class defines methods for executing code 
 * and returning response from shell
 */
class Shell{
	/**
	 * [execute description]
	 * @param  [type] $language [description]
	 * @param  [type] $code     [description]
	 * @throws InvalidConfigurationException If [this condition is met]
	 * @return [type]           [description]
	 */
	public function execute($language, $code){
		Docker::verifyConfig($language);
		$config = \Yii::$app->params['docker'];
		$this->writeCodeFile($config['codeFile'], $code);
		$url = $config['httpService'];
		$command = sprintf($config['languages'][$language]['command'], $config['codeFile']);
		$response = $this->HTTPRequest($url, $command);
		$errorResponse = ['Stdout' => "Server error occured. Contact site admin.", 'Stderr' => "exit status 1"];
		if($response){
			$response = json_decode($response, true);
			if(isset($response['Stderr']) || isset($response['Stdout'])){
				return $response;
			}
			else{
				return $errorResponse;
			}
		}
		else{
			return $errorResponse;
		}
	}

	protected function writeCodeFile($file, $code){
		$fp = fopen($file, "r+");
		if (flock($fp, LOCK_EX)) {  // acquire an exclusive lock
		    ftruncate($fp, 0);      // truncate file
		    fwrite($fp, $code);
		    fflush($fp);            // flush output before releasing the lock
		    flock($fp, LOCK_UN);    // release the lock
		} else {
		    throw new \yii\base\Exception("Couldn't get the file lock for $file!");
		}
		fclose($fp);
	}

	protected function HTTPRequest($url, $command){
		//open connection
		$ch = curl_init();
		$fields['command'] = $command;
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);

		return $result;
	}
}