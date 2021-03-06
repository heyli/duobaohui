<?php
/*
 * 开发助手
 * 生成Modules
 */
namespace Gate\Modules\Demo;
use Gate\Package\Demo\Demo;

class Modules extends \Gate\Libs\Controller {
	private $name;
	private $modulesName;

	public function run() {
		if (!$this->_init()) {
			return FALSE;
		}
		if( !empty($this->name) && !empty($this->modulesName)){
			$this->createModules();
			if(isset($_REQUEST['create_view'])&& $_REQUEST['create_view']){
				$this->createView();
			}
		}
	}

	private function _init() {
		if($_SERVER['SERVER_ADDR']!='192.168.11.10'){
			return FALSE;
		}

		if(!empty($_REQUEST['name'])){
			$this->name = trim($_REQUEST['name']);
			$this->modulesName = trim($_REQUEST['modules']);
		}

		return TRUE;
			
	}

	/*
	 * create Modules
	 */
	private function createModules(){
		$modulesName= ucfirst($this->modulesName); // 首字母大写
		$dir	= ROOT_PATH . '/modules/' . $this->modulesName;
		$name	= ucfirst($this->name); //首字母大写
		$file	= $dir . '/' . $name . '.class.php';
		if(isset($_REQUEST['create_view']) && $_REQUEST['create_view']){
			$view_switch = 'true';
		}else{
			$view_switch = 'false';
		}

		$code	= <<<CODE
<?php
/*
 * 
 * @author
 */
namespace Gate\Modules\\{$modulesName};
#use Gate\Package\

class {$name} extends \Gate\Libs\AdmController {
    // TRUE: 输出view 页面; FALSE: 输出json格式数据
    protected \$view_switch = {$view_switch};

	public function run() {
		if (!\$this->_init()) {return FALSE;}

	}

	private function _init() {

		return \$this->_check();
	}


	private function _check(){

		return TRUE;
	}
}

CODE;

/*
	private function getRequest(\$param, \$isInt=null){
		return isset(\$this->request->REQUEST[\$param]) ? \$this->request->REQUEST[\$param] : (\$isInt===null ? null : (\$isInt ? 0 : ''));
	}
 */
		@mkdir($dir);
		if(file_exists($file)){
			echo '<br/>modules: ' . $name . '已存在';
			return FALSE;
		}
		//$isC = file_put_contents($file, $code, FILE_APPEND);
		$isC = file_put_contents($file, $code);
		@chmod($file, 0777);

		if($isC){
			echo $name . '<br/> 添加成功';
		}
	}

	/*
	 * create view
	 */
	private function createView(){
		$modulesName= ucfirst($this->modulesName); // 首字母大写
		/* view
		$dir	= ROOT_PATH . '/views/' . $this->modulesName;
		$name	= ucfirst($this->name); //首字母大写
		$file	= $dir . '/' . $name . '.view.php';
		 */
		// tpl
		$dir	= ROOT_PATH . '/tpls/' . $this->modulesName;
		$name = $this->name;
		$file	= $dir . '/' . $name . '.html';

		$code	= <<<CODE
{view 'header'}


{view 'footer'}	
<script>
</script>
CODE;

		@mkdir($dir);
		//$isC = file_put_contents($file, $code, FILE_APPEND);
		if(file_exists($file)){
			echo '<br/>tpl: '. $name . '已存在';die;
		}

		$isC = file_put_contents($file, $code);
		@chmod($file, 0777);

		if($isC){
			echo '<br/>'.$name . ' 添加成功';die;
		}
	}
}
