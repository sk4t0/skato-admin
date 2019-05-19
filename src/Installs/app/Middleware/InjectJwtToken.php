<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Http\InternalRequest;
use Dingo\Api\Provider\DingoServiceProvider;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;

class InjectJwtToken
{
    use Helpers;

    protected $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        if ($request instanceof InternalRequest) {
            if ($this->session->has('jwt_token')) {
                $request->headers->set('Authorization', 'Bearer '. $this->session->get('jwt_token'));
            }
        }

        return $next($request);
    }
}