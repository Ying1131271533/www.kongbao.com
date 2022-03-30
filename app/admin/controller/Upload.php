<?php
namespace app\admin\controller;

class Upload
{
	// 单张图片
	public function upload_img()
	{
		// 获取表单上传文件 例如上传了001.jpg
		$file = request() -> file('file');
		$files = request() -> file();
		try {
			validate(['image'=>'filesize:5242880|fileExt:jpg,png,gif']) -> check($files);
			$savename = \think\facade\Filesystem::disk('public') -> putFile( 'image', $file);
			$data = ['code' => 0, 'msg' => '上传成功', 'image' => '/static/upload/' . $savename];
		} catch (think\exception\ValidateException $e) {
			$data = ['code' => 1, 'msg' => $e -> getMessage()];
		}
		
		return $data;
	}
	
	// 多张图片
	function upload_imgs()
	{
		// $files = request() -> file('imgs');
		$files = request() -> file();
		try {
			validate(['image'=>'filesize:5242880|fileExt:jpg,png,gif']) -> check($files);
			$savename = [];
			foreach($files as $file) {
				$savename[] = '/static/upload/' . \think\facade\Filesystem::putFile( 'image', $file);
			}
			return ['code' => 0, 'msg' => '上传成功', 'image' => $savename];
		} catch (think\exception\ValidateException $e) {
			echo $e -> getMessage();
		}
	}
	
	// layui富文本上传图片
	function upload_layui()
	{
		if(request() -> isPost())
		{
			// 获取表单上传文件 例如上传了001.jpg
			$file = request() -> file('file');
			$files = request() -> file();
			
			try {
				validate(['image'=>'filesize:5242880|fileExt:jpg,png,gif']) -> check($files);
				$savename = \think\facade\Filesystem::disk('public') -> putFile( 'image', $file);
				$data = [
					'code' 	=> 0,
					'msg' 	=> '上传成功',
					'data' 	=> [
						'src' => '/static/upload/' . $savename,
						'title' => $_FILES['file']['name'],
					],
				];
			} catch (think\exception\ValidateException $e) {
				$data = ['code' => 1, 'msg' => $e -> getMessage()];
			}
			
			return $data;
		}
	}
	
	
}
