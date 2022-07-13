<?php

namespace app\controller\apidoc;

use think\facade\Request;

class Doc2
{
	protected $assets_path = "";
	protected $root = "";
	/**
	 * @var \think\Request Request实例
	 */
	protected $request;
	/**
	 * @var Doc 
	 */
	protected $doc;
	/**
	 * @var array 资源类型
	 */
	protected $mimeType = [
		'xml' => 'application/xml,text/xml,application/x-xml',
		'json' => 'application/json,text/x-json,application/jsonrequest,text/json',
		'js' => 'text/javascript,application/javascript,application/x-javascript',
		'css' => 'text/css',
		'rss' => 'application/rss+xml',
		'yaml' => 'application/x-yaml,text/yaml',
		'atom' => 'application/atom+xml',
		'pdf' => 'application/pdf',
		'text' => 'text/plain',
		'png' => 'image/png',
		'jpg' => 'image/jpg,image/jpeg,image/pjpeg',
		'gif' => 'image/gif',
		'csv' => 'text/csv',
		'html' => 'text/html,application/xhtml+xml,*/*'
	];
	public function initialize()
	{
		parent::initialize();
		// 有些程序配置了默认json问题
		// config ( 'default_return_type', 'html' );
		if (is_null(request())) {
			$request = Request::instance();
		}
		$this->doc = new Doc();
		// View::config ( [
		// 'view_path' => $this->view_path,
		// 'default_filter' => ''
		// ] );
		$this->assign('title', $this->doc->__get("title"));
		$this->assign('version', $this->doc->__get("version"));
		$this->assign('copyright', $this->doc->__get("copyright"));
		// $this->assets_path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		$this->assets_path = $this->doc->__get("static_path") ?: '/apidoc.doc2/assets';
		$this->assign('static', $this->assets_path);
		$this->root = request()->root();
		$this->assign('root', $this->root);
	}

	/**
	 * 验证密码
	 * @return bool
	 */
	protected function checkLogin()
	{
		$pass = $this->doc->__get("password");
		if ($pass) {
			if (session('pass') === md5($pass)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	/**
	 * 解析资源
	 * @return $this
	 */
	public function assets()
	{
		$assets_path = _DOMAIN_PATH_INDEX_ . 'themes/open1.0/apidoc' . DIRECTORY_SEPARATOR;
		$path = str_replace("apidoc.doc2/assets", "", request()->pathinfo());
		$ext = request()->ext();
		if ($ext) {
			$type = "text/html";
			$content = file_get_contents($assets_path . $path);
			if (array_key_exists($ext, $this->mimeType)) {
				$type = $this->mimeType[$ext];
			}
			return response($content, 200, [
				'Content-Length' => strlen($content)
			])->contentType($type);
		}
	}

	/**
	 * 输入密码
	 * @return string
	 */
	public function pass()
	{
		return $this->fetch('pass');
	}

	/**
	 * 登录
	 * @return string
	 */
	public function login()
	{
		$pass = $this->doc->__get("password");
		if ($pass && request()->param('pass') === $pass) {
			session('pass', md5($pass));
			$data = [
				'status' => '200',
				'message' => '登录成功'
			];
		} else if (!$pass) {
			$data = [
				'status' => '200',
				'message' => '登录成功'
			];
		} else {
			$data = [
				'status' => '300',
				'message' => '密码错误'
			];
		}
		return response($data, 200, [], 'json');
	}

	/**
	 * 文档首页
	 * @return mixed
	 */
	public function index()
	{
		if ($this->checkLogin()) {
			$this->assign('doc', request()->param('doc'));
			return $this->fetch('index');
		} else {
			return redirect('doc/pass');
		}
	}

	/**
	 * 文档搜素
	 * @return mixed|\think\Response
	 */
	public function search()
	{
		if (request()->isAjax()) {
			$data = $this->doc->searchList(request()->param('query'));
			return response($data, 200, [], 'json');
		} else {
			$module = $this->doc->getModuleList();
			$this->assign('module', $module);
			return $this->fetch('apidoc/doc2/search');
		}
	}

	/**
	 * 设置目录树及图标
	 * @param $actions
	 * @return mixed
	 */
	protected function setIcon($actions, $num = 1)
	{
		foreach ($actions as $key => $moudel) {
			if (isset($moudel['actions'])) {
				$actions[$key]['iconClose'] = $this->assets_path . "/js/zTree_v3/img/zt-folder.png";
				$actions[$key]['iconOpen'] = $this->assets_path . "/js/zTree_v3/img/zt-folder-o.png";
				$actions[$key]['open'] = true;
				$actions[$key]['isParent'] = true;
				$actions[$key]['actions'] = $this->setIcon($moudel['actions'], $num = 1);
			} else {
				$actions[$key]['icon'] = $this->assets_path . "/js/zTree_v3/img/zt-file.png";
				$actions[$key]['isParent'] = false;
				$actions[$key]['isText'] = true;
			}
		}
		return $actions;
	}

	/**
	 * 接口列表
	 * @return \think\Response
	 */
	public function getList()
	{
		$list = $this->doc->getList();
		$list = $this->setIcon($list);
		return response([
			'firstId' => '',
			'list' => $list
		], 200, [], 'json');
	}

	/**
	 * 接口详情
	 * @param string $name
	 * @return mixed
	 */
	public function getInfo($name = "")
	{
		list($class, $action) = explode("::", $name);
		$action_doc = $this->doc->getInfo($class, $action);
		if ($action_doc) {
			$return = $this->doc->formatReturn($action_doc);
			$action_doc['header'] = isset($action_doc['header']) ? array_merge($this->doc->__get('public_header'), $action_doc['header']) : [];
			$action_doc['param'] = isset($action_doc['param']) ? array_merge($this->doc->__get('public_param'), $action_doc['param']) : [];

			$action_doc['remark'] = !empty($action_doc['remark']) ? $action_doc['remark'] : '无';
			$this->assign('doc', $action_doc);
			$this->assign('return', $return);
			return $this->fetch('apidoc/doc2/info');
		}
	}

	/**
	 * 接口访问测试
	 * @return \think\Response
	 */
	public function debug()
	{
		$data = request()->param();
		$api_url =  request()->param('url');
		$res['status'] = '404';
		$res['meaasge'] = '接口地址无法访问！';
		$res['result'] = '';
		$method = request()->param('method_type', 'GET');
		$cookie = request()->param('cookie');
		$headers = request()->param('header/a', array());
		unset($data['method_type']);
		unset($data['url']);
		unset($data['cookie']);
		unset($data['header']);
		include __DIR__ . '/helper.php';
		$res['result'] = http_request($api_url, $cookie, $data, $method, $headers);
		if ($res['result']) {
			$res['status'] = '200';
			$res['meaasge'] = 'success';
		}
		return response($res, 200, [], 'json');
	}
}
