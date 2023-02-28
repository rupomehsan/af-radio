<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Auth;

class UserAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->user_role_id == User::SUPER_ADMIN) {
            return $next($request);
        } else if (auth()->user()->user_role_id == User::ADMIN) {
            $accessStatus = $this->canAccess();
            if ($accessStatus) {
                return $next($request);
            } else {
                return redirect('/admin/dashboard');
            }
        }else if(auth()->user()->user_role_id == User::USER){
            Auth::logout();
            return redirect('/login');
        } else {
            return redirect('/login');
        }
    }

    public function canAccess()
    {
        $userAccessList = json_decode(auth()->user()->access) ?? [];
        array_push($userAccessList, 'dashboard');
        if (in_array(request()->segment(2), $userAccessList)) {
            return true;
        } else {
            return false;
        }
    }
}
