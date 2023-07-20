<?php

namespace SmallRuralDog\Admin\Middleware;

use Closure;
use SmallRuralDog\Admin\Facades\Admin;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;
    protected $guard;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
        $this->guard = config('admin.auth.guard') ?: 'admin';
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
        if (!$request->hasSession() || !$request->user($this->guard)) {
            return $next($request);
        }

        if ($this->guard()->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->auth->getRecallerName()))[2] ?? null;

            if (!$passwordHash || $passwordHash != $request->user($this->guard)->getAuthPassword()) {
                $this->logout($request);
            }
        }

        if (!$request->session()->has('password_hash_' . $this->auth->getDefaultDriver())) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get('password_hash_' . $this->auth->getDefaultDriver()) !== $request->user($this->guard)->getAuthPassword()) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            if (!is_null($this->guard()->user())) {
                $this->storePasswordHashInSession($request);
            }
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (!$request->user($this->guard)) {
            return;
        }

        $request->session()->put([
            'password_hash_' . $this->auth->getDefaultDriver() => $request->user($this->guard)->getAuthPassword(),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->guard()->logoutCurrentDevice();

        $request->session()->flush();

        return Admin::responseRedirect(admin_url('auth/login'), false);
    }

    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return $this->auth->guard($this->guard);
    }
}
