<?php

namespace raplet\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use raplet\Rank;

class BeforeModeratorCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            $moderator_role = Rank::where('slug', 'moderator')->first();
            $admin_role = Rank::where('slug', 'admin')->first();

            if (Auth::user()->userprofile->role_id === $moderator_role->id || Auth::user()->userprofile->role_id === $admin_role->id)
            {
                return $next($request);
            }
            else
            {
                $success = '0';
                $message = trans('home.youshouldntdothat');
                return response()->json(['message' => $message, 'success' => $success]);
            }
        }
        else
        {
            $success = '0';
            $message = trans('home.youshouldntdothat');
            return response()->json(['message' => $message, 'success' => $success]);
        }
    }
}
