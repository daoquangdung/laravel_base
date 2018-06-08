<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class TbUsers extends Authenticatable
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','permission','deleted'
    ];

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'tb_users';

    public function userInfo()
    {
        return $this->hasOne('App\Model\TbUserInfo','user_id','id');
    }

    public function hashPassword($password){
        return Hash::make($password);
    }

    public function getUserInfo(){

        $userInfo = TbUserInfo::where('user_id',$this->id)->first();
        if(!$userInfo){
            $userInfo = new TbUserInfo();
            $userInfo->user_id = $this->id;
            $userInfo->phone = null;
            $userInfo->firstname = null;
            $userInfo->lastname = null;
            $userInfo->birthday = null;
            $userInfo->avatar = $this->createAvatar();
            $userInfo->facebook = null;
            $userInfo->about = null;
            try{
                $userInfo->save();
            }catch (Exception $e){
                echo 'Message: ' .$e->getMessage();
            }
        }
        return $userInfo;
    }

    private function createAvatar(){
        $colors = [
            "1abc9c", "2ecc71", "3498db",
            "9b59b6", "34495e", "16a085",
            "27ae60", "2980b9", "8e44ad",
            "2c3e50", "f1c40f", "e67e22",
            "e74c3c", "95a5a6", "f39c12",
            "d35400", "c0392b", "bdc3c7",
            "7f8c8d"];

        $count = count($colors);

        $randColor = rand(0,$count);
        $url = "https://ui-avatars.com/api/?color=fff&background=".$colors[$randColor]."&size=100&name=".$this->username;
        $file = file_get_contents($url);

        return $this->autuAvatar($file);
    }

    private function autuAvatar($file){
        $filename = md5($this->username).'_'.time().'_'.$this->id.'.png';
        $path = 'avatar/'.$this->id.'/'. $filename;
        Storage::put($path, $file);
        if (!File::exists($path)) {
            $url = url("/storage/avatar/".$this->id."/".$filename);
        }else{
            $url = "";
        }
        return $url;
    }

}
