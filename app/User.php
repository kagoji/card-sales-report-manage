<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use DateTime;
use Image;


class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email ',
        'email_verified_at',
        'user_mobile',
        'user_profile_image',
        'login_status',
        'status',
        'last_login',
    ];

    public static function LogInStatusUpdate($status)
    {
        if(\Auth::check()){
            if($status=='login') {
                $change_status=1;
            } else {
                $change_status=0;
            }
            $loginstatuschange = \App\User::where('email',\Auth::user()->email)->update(array('login_status'=>$change_status));
            return $loginstatuschange;
        }
    }

    public static function TiemElapasedString($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    public static function UserImageUpload($img_location, $email, $img_ext)
    {

        if (!file_exists('images/user-profile/')) {
            mkdir('images/user-profile/', 0777, true);
        }
        $filename  = $email.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;
        $path = 'images/user-profile/' . $filename;
        Image::make($img_location)->resize(150, 150)->save($path);
        return $path;
    }

}