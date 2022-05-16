<?php

namespace Base\Middleware;

interface MiddlewareInterface
{
    /**
     * Implement always method
     * 
     * Used for implementing methods or functionalities
     * that always needs to be run
     *
     * @return void
     */
    public function always();
}
