<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\PermissionTransformer;

class PermissionsController extends Controller
{
    /**
     * 获取用户权限
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $permissions = $this->user()->getAllPermissions();
        return $this->response->collection($permissions, new PermissionTransformer());
    }
}
