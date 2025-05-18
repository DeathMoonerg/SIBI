<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    
    /**
     * Set a longer token lifetime to prevent frequent expirations
     * Default is 120 minutes
     *
     * @var int
     */
    protected $expires = 240; // 4 hours
} 