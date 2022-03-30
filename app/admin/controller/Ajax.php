<?php
namespace app\admin\controller;

use think\facade\Db;

class Ajax extends Base
{
	/**
     * 改变状态
     *
     * @param input()
     * @return Array
     */
	public function status()
    {
		if (request() -> isAjax()) {
			$data = [
				'id' => input('id/d'),
				'value' => input('value/d') ? 0 : 1,
				'field' => input('field/s'),
				'db' => input('db/s', request()->controller()),
				'url' => input('url/s'),
			];
			
			$result = Db::name($data['db'])->where('id', $data['id'])->update([$data['field'] => $data['value']]);
			if (empty($result)) {
				return ['code' => 1, 'msg' => '修改失败'];
			}
			$url = str_replace('value=' . input('value/d'), 'value=' . $data['value'], $data['url']);
			return ['code' => 0, 'msg' => '修改成功', 'value' => $data['value'], 'url' => $url];
		}
    }
	
}
















