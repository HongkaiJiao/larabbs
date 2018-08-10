<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // 显示用户个人信息页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    // 个人资料编辑页面
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    // 个人资料更新--使用自定义的表单请求验证
    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user)
    {
        //dd($request->avatar);
        // 获取表单信息
        $data = $request->all();

        // 若有选头像则上传头像文件
        if ($request->avatar) {
            $result = $uploader->save($request->avatar,'avatars',$user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        // 执行更新
        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功 ! ');
    }
}
