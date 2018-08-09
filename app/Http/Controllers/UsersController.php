<?php

namespace App\Http\Controllers;

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
    public function update(UserRequest $request,User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功 ! ');
    }
}
