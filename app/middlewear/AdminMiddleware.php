<?php
namespace App\Http\Middleware;
use Closure;

class AdminMiddleware {
    public function handle($request, Closure $next) {
        $user = $request->session()->get('user');
        if (($user['role'] ?? '') !== 'admin') {
            return redirect()->route('dashboard')->with('error','Anda tidak memiliki akses');
        }
        return $next($request);
    }
}
