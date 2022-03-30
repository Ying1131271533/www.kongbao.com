<?php
namespace app\admin\controller;

use think\facade\Db;

class Auth 
{
	private $_config = [
		// 权限管理开关
		'on' => true,
		// 权限管理控制类型 1：即时控制 2：登录控制
		'type' => 1,
		// 数据表名字
		'table' => [
			'admin' => 'admin',
			'admin_role' => 'admin_role',
			'role' => 'role',
			'role_node' => 'role_node',
			'node' => 'node',
		],
		// 例外 不需要权限 控制器 => [方法, 方法]
		'exception' => [],
		// 超级管理员
		'super' => ['神织知更',],
		// 是否只显示有权限的导航栏
		'show' => false,
	];
	
	// 配置初始化
	public function __construct()
	{
		$config = config('app.auth');
		if(! empty($config))
		{
			$this -> _config = array_merge($this -> _config, $config);
		}
	}
	
	// 检查用户是否有访问该节点的权限
	function check($id = '', $controller = '', $action = '')
	{
		
		// 是否开启权限控制
		if($this -> _config['on'] === false)
		{
			return true;
		}
		
		
		$controller = ! empty($controller) ? $controller : request() -> controller();
		$action = ! empty($action) ? $action : request() -> action();
		
		
		
		// 控制器的名字 转换小写 以免出错 Goods = goods
		$controller = strtolower($controller);
		$action = strtolower($action);
		
		
		// 找出session管理员id
		if(empty($id))
		{
			$id = session('admin.id');
		}
		
		
		// 是否超级管理员
		if(in_array(session('admin.name'), $this -> _config['super']))
		{
			return true;
		}
		
		// 例外节点
		if(isset($this -> _config['exception'][$controller]))
		{
			if(is_string($this -> _config['exception'][$controller]) && $this -> _config['exception'][$controller] === 'all')
			{
				return true;
			}else if(in_array($controller . '/' . $action, $this -> _config['exception'][$controller]))
			{
				return true;
			}
			
		}
		
		// 通过id找出管理员信息
		$admin = $this -> getAdmin($id);
		if(empty($admin))
		{
			return false;
		}
		
		// 是否被停用
		if($admin['status'] == 2)
		{
			return 2;
		}
		
		// 获取权限数组
		if($this -> _config['type'] === 1)
		{
			$access = $this -> getAccess($id);
		}else
		{
			$access = session('admin.access');
		}
		
		
		// 判断拥有节点的权限
		if(empty($access))
		{
			return false;
		}
		
		// dump($controller ."/" .$action);die;
		// 判断是否拥有访问该节点的权限
		if(! in_array($controller . '/' .$action, $access))
		{
			return false;
		}
		
		return true;
	}
	
	// 找出所有导航栏显示的节点
	function getShowNode($admin)
	{
		if($this -> _config['on'] === false || in_array($admin['name'], $this -> _config['super']) || $this -> _config['show'] === false)
		{
			$nodeId = Db::table($this -> _config['table']['node']) -> where('show', 1) -> order('sort', 'asc') -> column('id');
			
		}else
		{
			// 通过管理员 找到 管理员-角色id
			$roleId = $this -> getAdminRole($admin['id']);
			
			// 通过角色id 找到 节点id
			$nodeId = $this -> getRoleNode($roleId);
			
			// 找出例外节点id
			$excepNodeId = $this -> exception();
			if(! empty($excepNodeId))
			{
				$nodeId = array_unique(array_merge($nodeId, $excepNodeId));
			}
		}
		
		$nodeData = $this -> getNode($nodeId, 2);
		return $nodeData;
	}
	
	// 找出例外节点id
	protected function exception()
	{
		$node = [];
		if(! empty($this -> _config['exception']))
		{
			foreach($this -> _config['exception'] as $key => $value)
			{
				if($value === 'all')
				{
					$id = Db::table($this -> _config['table']['node']) -> where('name', $key) -> value('id');
					$data = Db::table($this -> _config['table']['node']) -> where('pid', $id) -> order('sort', 'asc') -> column('id');
					$node[] = $id;
					$node = array_merge($node, $data);
					
				}else if(is_array($value) && ! empty($value))
				{
					$id = Db::table($this -> _config['table']['node']) -> where('name', $key) -> value('id');
					$data = Db::table($this -> _config['table']['node']) -> where('name', 'in', $value) -> order('sort', 'asc') -> column('id');
					$node[] = $id;
					$node = array_merge($node, $data);
				}
			}
			
			return array_filter($node);
		}
		
		return $node;
	}
	
	// 找出所拥有的节点信息
	public function getAccess($id)
	{
		// 通过管理员 找到 管理员-角色id
		$roleId = $this -> getAdminRole($id);
		if(empty($roleId))
		{
			return false;
		}
		
		// 通过角色id 找到 节点id
		$nodeId = $this -> getRoleNode($roleId);
		if(empty($nodeId))
		{
			return false;
		}
		
		// 找出管理员所拥有的节点信息
		$node = $this -> getNode($nodeId);
		return $node;
	}
	
	// 找出管理员所拥有的节点name
	protected function getNode($node_id, $type = 1) // type 1:返回name 2:返回所有数据
	{
		if($type == 1)
		{
			$data = Db::table($this -> _config['table']['node']) -> where('id', 'in', $node_id) -> order('sort') -> column('name');
			
		}else if($type == 2)
		{
			$data = Db::table($this -> _config['table']['node']) -> where('id', 'in', $node_id) -> order('sort') -> select();
			
		}
		
		
		return $data;
	}
	
	// 找出管理员所拥有的节点信息
	protected function getRoleNode($role_id)
	{
		$data = Db::table($this -> _config['table']['role_node']) -> where('role_id', 'in', $role_id) -> column('node_id');
		return $data;
	}
	
	
	// 通过管理员id 找到 角色id
	protected function getAdminRole($amdin_id)
	{
		$data = Db::table($this -> _config['table']['admin_role']) -> where('admin_id', $amdin_id) -> column('role_id');
		return $data;
	}
	
	// 找出管理员信息
	protected function getAdmin($amdin_id)
	{
		$data = Db::table($this -> _config['table']['admin']) -> field('id, name, status') -> find($amdin_id);
		return $data;
	}
}
















