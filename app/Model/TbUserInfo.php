<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TbUserInfo extends Model
{
    //
    protected $fillable = [
        'user_id',
        'phone',
        'firstname',
        'lastname',
        'address',
        'birthday',
        'avatar',
        'facebook',
        'about',
    ];

    protected $guarded = [
        'id'
    ];

    protected $table = 'tb_user_info';

    public function users()
    {
        return $this->belongsTo('App\Model\TbUsers');
    }
}
