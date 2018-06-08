<?php

namespace App\Http\Controllers\admin;

use App\Model\TbUserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TbUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\UploadedFile;
use Image;


use League\Flysystem\Exception;
use Validator;
class UsersController extends Controller
{
    //
    public function index(){
        $users = TbUsers::where('deleted',0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.users.users')->with('users', $users);
    }

    public function delete(Request $request){
        $response = [];
        $id = $request->input('id');
        $user = TbUsers::find($id);
        $user->deleted = 1;
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
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|unique:tb_users',
        ],[
            'name.required' => 'Chưa nhập Username. ',
            'name.min' => 'Username phải có ít nhất 5 ký tự. ',
            'name.max' => 'Username tối đa có 255 ký tự. ',
            'email.required' => 'Không được để trống.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
        ]);

        $error = [];

        if ($validator->fails()) {
            $error = $validator->errors()->all();
        }

        $user = TbUsers::find($id);
        if(empty($error)){
            if($user){
                $user->username = $request->input('name');
                $user->email = $request->input('email');
                try{
                    $user->save(); // returns false
                }
                catch(\Exception $e){
                    $error[] = 'Lỗi ! Không thể Tạo '.$user->name;
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

    public function getCreate(){
        return view('admin.users.create');
    }

    public function postCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|unique:tb_users',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password'
        ],[
            'name.required' => 'Chưa nhập Username. ',
            'name.min' => 'Username phải có ít nhất 5 ký tự. ',
            'name.max' => 'Username tối đa có 255 ký tự. ',
            'email.required' => 'Email Không được để trống.',
            'email.email' => 'Không đúng định dạng email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu Phải nhiều hơn 6 ký tự.',
            'password_confirm.required' => 'Chưa nhập lại mật khẩu.',
            'password_confirm.same' => 'Nhập lại mật khẩu sai.',
        ]);

        $error = [];

        if ($validator->fails()) {
            $error = $validator->errors()->all();
        }

//        $user = TbUsers::find($id);
        if(empty($error)){
            $user = new TbUsers();

            $user->username = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $user->hashPassword($request->input('password'));
            try{
                $user->save(); // returns false
            }
            catch(\Exception $e){
                $error[] = 'Lỗi ! Không thể lưu '.$user->name;
            }
        }

        if(!empty($error)){
            return redirect()->back()->with('errors',$error);
        }

        return redirect()->route('admin/users/get', ['id' => 107])->with('success', 'create success');
    }

    public function viewUser($id){
        $user = TbUsers::find($id);
        $error = [];
        if($user){
            $userInfo = $user->getUserInfo();

            $response = array(
                'user' => $user,
                'userInfo' => $userInfo
            );
        }else{
            $error[] = "User Không tồn tại";
        }

        if(!empty($error)){
            abort(404);
        }
        return view('admin.users.view')->with($response);
    }

    public function editUser(Request $request){
        $id = $request->input('id');
        $user = TbUsers::find($id);

        $infoUser = $user->getUserInfo();
        $error = [];

        if($user){
            $validator = Validator::make($request->all(), [
                'phone' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'
            ],[
                'phone.regex' => 'Số điện thoại không đúng định dạng. ',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all();
            }

        }else{
            $error[] = "Không tìm thấy user này";
        }

        if(empty($error)){
            $infoUser->phone = $request->phone;
            $infoUser->firstname = $request->firstname;
            $infoUser->lastname = $request->lastname;
            $infoUser->address = $request->address;
            $infoUser->birthday = $request->birthday;
            $infoUser->facebook = $request->facebook;
            $infoUser->about = $request->about;
            $infoUser->save();
        }

        if(!empty($error)){
            return redirect()->back()->with('errors',$error);
        }

        return redirect()->back()->with('success', 'success');
    }


    public function editAvatar(Request $request){

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpeg,png,jpg|max:2048',
        ],[
            'avatar.required' => 'Chưa chọn ảnh',
            'avatar.mimes' => 'Không đúng định dạng ảnh',
            'avatar.max' => 'Ảnh quá lớn',
        ]);
        $error = [];
        if ($validator->fails()) {
            $error = $validator->errors()->all();
        }

        if(!empty($error)){

            return redirect()->back()->with('errors',$error);
        }

        $file = $request->file('avatar');

        $now = time();
        $filename = md5($now).'_' . $now .'_'.$request->id.'.'. $file->getClientOriginalExtension();
        $path = 'avatar/'.$request->id;

        try{
            $file->storeAs($path, $filename);
        }catch (Exception $e){
            $error[] = "Không lưu được ảnh";
        }
        $img = Image::make($file->getRealPath());
        $img->fit(100);
        $filenameResize = md5($now).'_' . $now .'_'.$request->id.'_100x100.'. $file->getClientOriginalExtension();
        $path = 'app/avatar/'.$request->id;
        try{
            $img->save(storage_path($path.'/'.$filenameResize));
        }catch (Exception $e){
            $error[] = "Không lưu được ảnh";
        }
        if(empty($error)){
            $infoUser = TbUserInfo::where('user_id',$request->id)->first();
            $infoUser->avatar = url("/storage/avatar/".$request->id."/".$filenameResize);
            try{
                $infoUser->save();
            }catch(Exception $e) {
                $error[] = "Không tìm thấy user này";
            }
        }
        if(!empty($error)){

            return redirect()->back()->with('errors',$error);
        }

        return redirect()->back()->with('success', 'success');

    }



}
