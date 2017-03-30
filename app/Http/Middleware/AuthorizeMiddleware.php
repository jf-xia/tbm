<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthorizeMiddleware {

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->check()){
			$user = $this->auth->user();

			if ($user->roles()->count()==0){
				$user->roles()->sync([5]);
			}

			$uri = explode('/',$request->path())[0];
//dd($uri);
//dd($user->can($uri.'.*'));
			if(!$user->can($uri.'.*'))
			{
				if ($request->ajax())
				{
					return response('Unauthorized.', 403);
				}
				else
				{
					abort(403);
				}
			}
		}else{
			return redirect('login');
		}

		return $next($request);
	}

}
