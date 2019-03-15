<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Department extends Model
{
    protected $fillable = [
        'name', 'logo', 'description',
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'department_user');
    }

    public static function validate(Request $request, self $user = null) {
        $validations = [
            'name' => 'required|max:255',
            'description' => 'required',
        ];

        if ($user) {
            if ($request->input('name') !== $user->name) {
                $validations['name'] = 'required|unique:departments|max:255';
            }
        } else {
            $validations['name'] = 'required|unique:departments|max:255';
        }

        $request->validate($validations);
    }
}
