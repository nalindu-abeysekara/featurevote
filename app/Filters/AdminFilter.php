<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Check if user is authenticated and has admin role.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth');

        // Check if logged in
        if (!$auth->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to access admin area.');
        }

        // Check if user has admin group
        if (!$auth->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Access denied. Admin privileges required.');
        }
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
