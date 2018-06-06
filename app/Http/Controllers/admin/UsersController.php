<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TbUsers;
use Illuminate\Support\Facades\Redirect;
use Validator;
class UsersController extends Controller
{
    //
    public function index(){
        $users = TbUsers::where('status',1)->orderBy('id', 'desc')->paginate(10);
        return view('admin.users.users')->with('users', $users);
    }

    public function delete(Request $request){
        $response = [];
        $id = $request->input('id');
        $user = TbUsers::find($id);
        $user->status = 0;
        try{
            $user->save(); // returns false
            if($user->save()){
                $response['status'] = 1;
                $response['message'] = 'Xóa thành công '.$user->name;
            }
        }
        catch(\Exception $e){
            $response['status'] = 0;
            $response['message'] = 'Lỗi ! Không thể xóa '.$user->name;
        }
        return response()->json($response);
    }

    public function getUser($id){
        $user = TbUsers::find($id);

        return view('admin.users.edit')->with('user', $user);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:255',
            'email' => 'required|email',
        ],[
            'name.required' => 'Chưa nhập Username. ',
            'name.min' => 'Username phải có ít nhất 6 ký tự. ',
            'name.max' => 'Username tối đa có 255 ký tự. ',
            'email.required' => 'Không được để trống.',
            'email.email' => 'Không đúng định dạng email.',
        ]);

        $error = [];

        if ($validator->fails()) {
            $error = $validator->errors()->all();
        }

        $user = TbUsers::find($id);
        if(empty($error)){
            if($user){
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                try{
                    $user->save(); // returns false
                }
                catch(\Exception $e){
                    $error[] = 'Lỗi ! Không thể xóa '.$user->name;
                }
            }else{
                $error[] = 'không tìm thấy user này';
            }
        }




        if(!empty($error)){
            return redirect()->back()->with('errors',$error);
        }
        return redirect()->back()->with('success', 'success');

    }
}
