<?php
/**
 * Created by PhpStorm.
 * User: lxb
 * Date: 2017/12/13
 * Time: 10:07
 */

namespace app\modules\backend\components;

use Yii;
use OSS\OssClient;
use OSS\Core\OssException;
use app\models\ImgUseHistory;

class AliyunOss 
{
	private $_oss;
    private $_bucket;
	/**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OssClient 一个OssClient实例
     */
    public function getOssClient()
    {
        
        try {
        	$this->_bucket =\Yii::$app->params['aliyun']['oss']['bucket']['name'];
            $this->_oss = new OssClient(
            	\Yii::$app->params['aliyun']['accessKeyId'],
            	\Yii::$app->params['aliyun']['accessKeySecret'],
            	\Yii::$app->params['aliyun']['oss']['endpoint'],
            	false
            );
        } catch (OssException $e) {
            \Yii::error(___METHOD__, "creating OssClient instance: FAILED");
            \Yii::error(__METHOD__,$e->getMessage());
            $this->_oss = null;
        }
    }

    /**
	 * 上传指定的本地文件内容
	 *
	 * @param string $object 存储目标
	 * @param string $filePath 本地文件
	 * @return null
	 */
	function  uploadFile($object, $filePath)
	{
	    //文件夹则$object直接用/ 如：abc/a.jpg
	    $this->getOssClient();
	    $options = array();
	    if (is_null($this->_oss)) {
	    	\Yii::error(__METHOD__,'ossClient is null!');
	    	return false;
	    };
	    try {
	        $this->_oss->uploadFile($this->_bucket, $object, $filePath, $options);
	    } catch (OssException $e) {
	        \Yii::error(__METHOD__,'uploadFile is FAILED!');
	        \Yii::error(__METHOD__,$e->getMessage());
	        return false;
	    }
	    return true;
	}

	public function saveImg($name='',$status)
	{
		return ImgUseHistory::newData($name,$status);
	}

	
	/*删除oss文件,支持批量删除*/
	public function delFile($dir,$fileName)
	{
		if (is_null($this->_oss)) {
	    	$this->getOssClient();
	    }
	    if (is_null($this->_oss)) {
	    	\Yii::error(__METHOD__,'ossClient is null!');
	    	return false;
	    }
	    $fileArray=[];
	    if (is_array($fileName)) {
	    	if (empty($fileName)) {
		    	return false;
		    }
	    	foreach ($fileName as $key => $value) {
	    		if (trim($value,' ')!="") {
	    			array_push($fileArray, $dir.'/'.$value);
	    		}	    		
	    	}
	    }else{
	    	if (trim($fileName,' ')=="") {
		    	return false;
		    }
	    	array_push($fileArray, $dir.'/'.$fileName);
	    }
		$this->_oss->deleteObjects($this->_bucket, $fileArray);
		
		return true;		
	}

	/*读取上传文件到oss*/
	public function saveUploadFile($dir,$file,$status=0)
	{
		if(is_array($file)) //上传文件
        {
            if (!is_uploaded_file($file['tmp_name']))
            {
                return '';
            }
            
            $file_path = $file['tmp_name'];
            $ext = $this ->get_extension($file['name']);
            return $this->saveFile($dir,$file_path,$ext,$status);
           
        }
	}

	/*上传文件到oss*/
	public function saveFile($dir,$filePath,$ext,$status)
	{
		$fileinfo = pathinfo($filePath);
		// pathinfo(/testweb/test.txt)
		// [dirname] => /testweb
		// [basename] => test.txt
		// [extension] => txt
		$fileNewName='';
		for ($i=0; $i <10 ; $i++) { 
			$fileNewName=$this->getNewName(4);
			if (!$this->doesObjectExist($dir.'/'.$fileNewName)) {
				break;
			}
		}
		// rename($filePath, $fileinfo['dirname'].'/'.$fileNewName.'.'.$fileinfo['extension']);
		$flag = $this->uploadFile($dir.'/'.$fileNewName.'.'.$ext,$filePath);	
		if ($flag) {
			$name = $dir.'/'.$fileNewName .'.'. $ext;			
			$this->saveImg($name,$status);
			return	$name;
		}
		return	'';
	}

	/*判断文件是否存在*/
	public function doesObjectExist($object)
	{
		if (is_null($this->_oss)) {
	    	$this->getOssClient();
	    }
	    if (is_null($this->_oss)) {
	    	\Yii::error(__METHOD__,'ossClient is null!');
	    	return false;
	    }
		return $this->_oss->doesObjectExist($this->_bucket, $object);
	}

	function getNewName($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
        }
        return $string;
    }

    function get_extension($file)
	{
		$info = pathinfo($file);
		return $info['extension'];
	}
}

?>