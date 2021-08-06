<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    //
	public function index()
    {

        # code...
        $data['activePage'] = 'users';
        $data['title'] = __('file.users');
        $data['users'] = User::where('role','=',2)->get();
        return view('admin.users.index', $data);
    }
    public function userDelete(Request $request){
        $user_id=$request->user_id;
        $user=User::find($user_id);
        if($user){  
            $user->delete();
            $message=array('status'=>200,'message'=>'user deleted successfully');
            echo json_encode($message);die;
        }
     
    }
}
