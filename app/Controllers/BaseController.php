<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation.
     *
     * @var list<string>
     */
    protected $helpers = ['auth', 'setting', 'url', 'form', 'html', 'vite'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = service('session');
    }

    /**
     * Check if request is HTMX request.
     *
     * @return bool
     */
    protected function isHtmxRequest(): bool
    {
        return $this->request->hasHeader('HX-Request');
    }

    /**
     * Return JSON response.
     *
     * @param mixed $data
     * @param int $status
     * @return ResponseInterface
     */
    protected function json($data, int $status = 200): ResponseInterface
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON($data);
    }

    /**
     * Return success JSON response.
     *
     * @param string $message
     * @param mixed $data
     * @return ResponseInterface
     */
    protected function success(string $message = 'Success', $data = null): ResponseInterface
    {
        return $this->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Return error JSON response.
     *
     * @param string $message
     * @param int $status
     * @return ResponseInterface
     */
    protected function error(string $message = 'Error', int $status = 400): ResponseInterface
    {
        return $this->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
