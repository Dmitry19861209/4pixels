<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departments() {
        return $this->belongsToMany('App\Department', 'department_user');
    }

    public static function validate(Request $request, self $user = null) {
        $validations = [
            'name' => 'required|max:255',
            'password' => 'required',
        ];

        if ($user) {
            if ($request->input('email') !== $user->email) {
                $validations['email'] = 'required|unique:users|max:255';
            }
        } else {
            $validations['email'] = 'required|unique:users|max:255';
        }

        $request->validate($validations);
    }
}

