<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthAccess implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (auth()->loggedIn()) {
            currentPage();
            $method        = strtolower(service('router')->methodName());
            $access        = auth_access();
            $method_create = ['getcreate', 'postcreate'];
            $method_read   = ['getindex', 'postindex'];
            $method_update = ['getedit', 'postedit'];
            $method_delete = ['getdelete', 'postdelete'];

            if (count($access) > 0) {
                foreach ($access as $key => $value) {
                    if ($value['can_create'] == 0 && in_array($method, $method_create) || $value['can_read'] == 0 && in_array($method, $method_read) || $value['can_update'] == 0 && in_array($method, $method_update) || $value['can_delete'] == 0 && in_array($method, $method_delete)) {
                        session()->remove('active_menu_id');
                        return redirect()->to("/");
                    }
                }
            } else {
                session()->remove('active_menu_id');
                // if ($controller !== '\App\Controllers\Home') { // exclude home controller
                return redirect()->to("/");
                // }
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
