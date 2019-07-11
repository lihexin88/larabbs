<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;


use App\Http\Requests\UserRequest;

class UsersController extends Controller {
    //


    /**
     * 用户个人中心页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user) {
        return view('users.show', compact('user'));
    }


    /**
     * 显示用户编辑页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }


    /**
     *
     * @param UserRequest $request
     * @param ImageUploadHandler $uploader
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user) {
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}