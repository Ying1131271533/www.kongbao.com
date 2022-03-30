<?php
namespace app\web\controller;

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
	
	
	
}
