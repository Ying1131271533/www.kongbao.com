<?php
namespace app\admin\controller;

use think\facade\Db;
use app\common\model\Admin as A;
use app\common\model\AdminRole as AR;

class Admin extends Base
{
	protected $adminRoleModel;
	protected $roleModel;
	protected $roleNodeModel;
	protected $nodeModel;
	public function __construct(\think\App $app)
	{
		parent::__construct($app);
		$this -> adminRoleModel = new \app\common\model\AdminRole;
		$this -> roleModel = new \app\common\model\Role;
		$this -> roleNodeModel = new \app\common\model\RoleNode;
		$this -> nodeModel = new \app\common\model\Node;
	}
	
	// 管理员列表
	public function index()
    {
		$adminList = A::field('id, name, real_name, qq, status')
            ->with(['roles' => function ($query) {
                $query->field('name');
            }])
            ->select();
		// dump($adminList -> toArray());return;
		$this -> assign('adminList', $adminList);
		return $this -> fetch();
    }
	
	// 管理员添加
	public function admin_add()
	{
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name/s'),
				'password' => input('password/s'),
				'password2' => input('password/s'),
				'real_name' => input('real_name/s'),
				'qq' => input('qq/d'),
				'status' => input('status/d'),
				'create_time' => time(),
			];
			// dump($data);return;
			$valiResult = $this -> validate($data, 'Admin');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			try {
				$valiResult = $this -> validate($data, 'Admin');
			} catch (\Exception $e) {
				return $this -> error($e->getError());
			}
			
			// 开启事务
			A:: startTrans();
			$result = A:: save($data);
			if($result === false)
			{
				// 回滚事务
				A:: rollback();
				return $this -> error(A:: getError());
			}
			
			$role = input('role');
			if(! empty($role))
			{
				$role = array_filter(array_unique($role));
				$roleResult = A:: roles() -> saveAll($role);
				if($roleResult === false)
				{
					// 回滚事务
					A:: rollback();
					return $this -> error('管理员添加失败');
				}
			}
			
			// 提交事务
			A:: commit();
			return $this -> success('管理员添加成功', url('index'));
		}
		
		$role = $this -> roleModel -> select();
		$this -> assign('role', $role);
		
		return $this -> fetch();
    }
	
	// 管理员修改
	public function admin_edit()
    {
		$id = input('id');
		if(empty($id))
		{
			return $this -> error('缺少参数');
		}
		
		if(request() -> isPost())
		{
			$id = input('id/d');
			$admin = A:: find($id);
			
			if(empty($admin))
			{
				return $this -> error('找不到该管理员');
			}
			
			$data = [
				'id' => $id,
				'name' => input('name/s'),
				'real_name' => input('real_name/s'),
				'qq' => input('qq/d'),
				'status' => input('status/d'),
				'create_time' => time(),
			];
			
			if(! empty(input('password/s')) || ! empty(input('password2/s')))
			{
				$data['password'] = input('password/s');
				$data['password2'] = input('password2/s');
			}
			
			$valiResult = $this -> validate($data, 'AdminEdit');
			// dump($valiResult);return;
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			// 开启事务
			$admin -> startTrans();
			$result = $admin -> save($data);
			if($result === false)
			{
				// 回滚事务
				$admin -> rollback();
				return $this -> error($admin -> getError());
			}
			
			$adminRole = $admin -> roles -> toArray();
			if(! empty($adminRole))
			{
				$delRole = [];
				foreach($adminRole as $value)
				{
					$delRole[] = $value['id'];
				}
				
				$delRoleResult = $admin -> roles() -> detach($delRole);
				if($delRoleResult === false)
				{
					// 回滚事务
					$admin -> rollback();
					return $this -> error($admin -> getError());
				}
			}
			
			
			$role = input('role/a', []);
			if(! empty($role[0]))
			{
				$role = array_filter(array_unique($role));
				$roleResult = $admin -> roles() -> saveAll($role);
				if($roleResult === false)
				{
					// 回滚事务
					$admin -> rollback();
					return $this -> error($admin -> getError());
				}
			}
			
			// 提交事务
			$admin -> commit();
			return $this -> success('管理员修改成功', url('index'));
		}
		
		$admin = A:: find($id);
		$this -> assign('admin', $admin);
		
		// 拥有的角色
		$adminRole = [];
		foreach($admin -> roles -> toArray() as $value)
		{
			$adminRole[] = $value['id'];
		}
		$this -> assign('adminRole', $adminRole);
		// dump($adminRole);
		
		// 所有角色
		$role = $this -> roleModel -> select();
		$this -> assign('role', $role);
		
		return $this -> fetch();
    }
	
	
	
	// 管理员删除
	public function admin_del()
    {
	 	if(request() -> isGet())
		{
			$id = input('id/d');
			$admin = A:: find($id);
			if (empty($admin)) {
				return $this -> error('找不到该管理员');
			}
			
			// 开启事务
			$admin -> startTrans();
			$adminRole = $admin -> roles -> column('id');
			if(! empty($adminRole))
			{
				$delRoleResult = $admin -> roles() -> detach($adminRole);
				if($delRoleResult === false)
				{
					// 回滚事务
					$admin -> rollback();
					return $this -> error($admin -> getError());
				}
			}
			
			$result = $admin -> delete();
			if($result === false)
			{
				// 回滚事务
				$admin -> rollback();
				return $this -> error($admin -> getError());
			}
			
			
			// 提交事务
			$admin -> commit();
			return $this -> success('管理员删除成功', url('index'));
		}
     
	}
	
	// 角色列表
	public function role()
    {
		$roleId = $this -> roleModel -> column('id');
		
		$roleList = [];
		foreach($roleId as $key => $value)
		{
			$role = $this -> roleModel -> find($value);
			$roleList[$key] = $role -> toArray();
			$admin = $role -> admins -> toArray();
			if(! empty($admin))
			{
				foreach($admin as $val)
				{
					$roleList[$key]['admin'][] = $val['name'];
				}
			}
		}
		
		$this -> assign('roleList', $roleList);
		// var_dump($roleList);return;
		return $this -> fetch();
    }
	
	// 角色添加
	public function role_add()
    {
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name/s'),
				'explain' => input('explain/s'),
			];
			
			$valiResult = $this -> validate($data, 'Role');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$result = $this -> roleModel -> save($data);
			if($result === false)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功', url('role'));
		}
		
		return $this -> fetch();
    }
	
	// 角色修改
	public function role_edit()
    {
		$id = input('id/d');
		if(empty($id))
		{
			return $this -> error('缺少参数');
		}
		
		if(request() -> isPost())
		{
			$data = [
				'id' => input('id/d'),
				'name' => input('name/s'),
				'explain' => input('explain/s'),
			];
			
			$valiResult = $this -> validate($data, 'Role');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$role = $this -> roleModel -> find($id);
			if(empty($role))
			{
				return $this -> error('找不到该角色', url('role'));
			}
			
			
			$result = $role -> save($data);
			if($result === false)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功');
		}
		
		$role = $this -> roleModel -> find($id);
		$this -> assign('role', $role);
		return $this -> fetch();
    }
	
	// 角色分配权限
	public function role_auth()
    {
		$id = input('id/d');
		if(empty($id))
		{
			return $this -> error('缺少参数');
		}
		
		if(request() -> isPost())
		{
			$id = input('id/d');
			$node = input('node');
			
			// dump(input());dump($data);return;
			
			$role = $this -> roleModel -> find($id);
			
			// 查看是否拥有节点 进行删除
			$roleNode = $role -> nodes;
			if(! empty($roleNode))
			{
				$delNode = [];
				foreach($roleNode as $value)
				{
					$delNode[] = $value['id'];
				}
				
				$delResult = $role -> nodes() -> detach($delNode);
				if($delResult === false)
				{
					return $this -> error('分配失败');
				}
			}
			
			if(! empty($node))
			{
				$result = $role -> nodes() -> saveAll($node);
				if($result === false)
				{
					return $this -> error($this -> roleModel -> getError());
				}
			}
			
			return $this -> success('保存成功');
		}
		
		// 所有节点
		$node = $this -> nodeModel -> order('sort') -> select();
		$node = get_child($node -> toArray());
		
		// 角色拥有的节点
		$roleNode = $this -> roleNodeModel -> where('role_id', $id) -> column('node_id');
		$this -> assign('roleNode', $roleNode);
		
		// dump($node);
		$this -> assign('node', $node);
		return $this -> fetch();
    }
	
	// 角色删除
	public function role_del()
    {
		$id = input('id/d');
		$role = $this -> roleModel -> find($id);
		if(empty($role))
		{
			return $this -> error('找不到该角色');
		}
		
		$role->startTrans();
		try {
			$delNode = $role -> nodes -> column('id');
			// 删除节点关联数据
			$role -> nodes() -> detach($delNode);
			// 删除管理员关联数据
			$role->admins()->detach();
			// 删除角色
			$role->delete();
			// 提交事务
			$role->commit();
			return $this -> success('删除成功');
		} catch (\Exception $e) {
			// 回滚事务
			$role->rollback();
			return $this -> error('删除失败');
		}
    }
	
	// 节点列表
	public function node()
    {
		$node = $this -> nodeModel -> order('sort') -> select();
		$node = get_child($node -> toArray());
		// dump($node);
		$this -> assign('node', $node);
		
		return $this -> fetch();
    }
	
	// 节点列表 - 树状图
	public function node_tree()
    {
		// 找出所有节点数据
		$node = $this -> nodeModel -> order('sort') -> select()->toArray();

		// 将节点转换layui树形图字符串
		$node_tree = get_child_tree_data($node);

		// 获取所有节点的id
        $ids = array_column($node, 'id');
		
		$this -> assign([
			'node_tree' => $node_tree,
			'ids' => $ids,
		]);
		return $this -> fetch();
    }
	
	// 节点添加
	public function node_add()
    {
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name/s'),
				'title' => input('title/s'),
				'sort' => input('sort/d'),
				'icon' => input('icon') ? input('icon') : '',
				'show' => input('show/d'),
				'pid' => input('pid/d'),
				'level' => input('level/d'),
			];
			
			$valiResult = $this -> validate($data, 'Node');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			
			$result = $this -> nodeModel -> save($data);
			if($result !== true)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功', url('node_edit', ['id' => $this -> nodeModel -> id]));
		}
		
		
		return $this -> fetch();
    }
	
	// 节点修改
	public function node_edit()
    {
		$id = input('id/d');
		// dump(input());return;
		if(empty($id))
		{
			return $this -> error('缺少参数');
		}
		
		if(request() -> isPost())
		{
			$data = [
				'id' => $id,
				'name' => input('name/s'),
				'title' => input('title/s'),
				'sort' => input('sort/d'),
				'icon' => input('icon') ? input('icon') : '',
				'show' => input('show'),
			];
			
			$node = $this -> nodeModel -> find($id);
			if(empty($node))
			{
				return $this -> error('节点不存在');
			}
			
			$valiResult = $this -> validate($data, 'Node');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$result = $node -> save($data);
			if($result === false)
			{
				return $this -> error('无修改');
			}
			
			return $this -> success('保存成功');
		}
		
		$node = $this -> nodeModel -> find($id);
		$this -> assign('node', $node);
		// dump($node);
		
		$title = input('title/s');
		$title = substr($title, 3);
		$this -> assign('title', $title);
		
		return $this -> fetch();
    }
	
	// 节点删除
	public function node_del()
    {
		$id = input('id/d');
		$pid = input('pid/d');
		if ($pid == 0) {
			$nodeChild = $this -> nodeModel -> where('pid', $id) -> find();
			if(! empty($nodeChild)) {
				return $this -> error('请删除该节点下面的子节点');
			}
		}
		
		$node = $this -> nodeModel -> find($id);
		$node->startTrans();
		
		try {
			// 删除关联数据
			$node->roles()->detach();
			// 删除关键词
			$node->delete();
			// 提交事务
			$node->commit();
			return $this -> success('删除成功');
		} catch (\Exception $e) {
			// 回滚事务
			$node->rollback();
			return $this -> error('删除失败');
		}
		
    }
	
	// 节点删除ajax
	public function node_del_ajax()
    {
		$id = input('id/d');
		$pid = input('pid/d');
		if ($pid == 0) {
			$nodeChild = $this -> nodeModel -> where('pid', $id) -> find();
			if(! empty($nodeChild)) {
				return $this -> error('请删除该节点下面的子节点');
			}
		}
		
		$node = $this -> nodeModel -> find($id);
		$node->startTrans();
		
		try {
			// 删除关联数据
			$node->roles()->detach();
			// 删除关键词
			$node->delete();
			// 提交事务
			$node->commit();
			return success('删除成功');
		} catch (\Exception $e) {
			// 回滚事务
			$node->rollback();
			return fail('删除失败');
		}
		
    }
	
}
















