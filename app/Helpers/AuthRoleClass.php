<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;


class AuthRoleClass {

    public static function getAuthRole()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $role = Str::slug('Admin', '-');
        }
        elseif ($user->hasRole(Str::slug('Candidate', '-'))) {
            $role = Str::slug('candidate', '-');
        }
        
        return $role;

    }

}

?>
