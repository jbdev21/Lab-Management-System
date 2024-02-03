<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function updatePermission(Request $request){
        $this->validate($request, [
            'role_id' => 'required',
            'permission' => 'required',
        ]);

        try{
            $role = Role::find($request->role_id);
        
            $permission = Permission::whereName($request->permission)->first();
    
            if(!$permission){
                $permission = Permission::create(['name' => $request->permission]);
            }
            
            if($role->hasPermissionTo($permission)){
                $role->revokePermissionTo($permission);
            }else{
                $role->givePermissionTo($permission);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Permission Updated!'
            ]);
        }catch(\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
       
    }
}
