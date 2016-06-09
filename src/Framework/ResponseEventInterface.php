<?php

/*
 * This file is part of the UCSDMath package.
 *
 * Copyright 2016 UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace UCSDMath\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ResponseEventInterface is the interface implemented by all Framework\Event classes.
 *
 * Method list: (+) @api.
 *
 * (+) Response getResponse();
 * (+) Request getRequest();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
interface ResponseEventInterface
{
    /**
     * Constants.
     */
    const REQUIRED_PHP_VERSION = '7.0.0';
    const DEFAULT_CHARSET = 'UTF-8';

    //--------------------------------------------------------------------------

    /**
     * Get the current response.
     *
     * @return Response The current interface
     *
     * @api
     */
    public function getResponse();

    //--------------------------------------------------------------------------

    /**
     * Get the current request.
     *
     * @return Request The current interface
     *
     * @api
     */
    public function getRequest();

    //--------------------------------------------------------------------------
}
