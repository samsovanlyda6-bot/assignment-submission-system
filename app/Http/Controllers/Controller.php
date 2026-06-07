<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    // Add this method for middleware
    public function middleware($middleware, $options = [])
    {
        // This is a simplified version - in a real controller this would be handled by the router
        return $this;
    }
}