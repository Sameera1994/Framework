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

namespace UCSDMath\Framework\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * RequestEventInterface is the interface implemented by all Framework\Event classes.
 *
 * Method list: (+) @api.
 *
 * (+) Request getRequest();
 * (+) RequestEvent setRequest(Request $request);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
interface RequestEventInterface
{
    /**
     * Constants.
     */
    const REQUIRED_PHP_VERSION = '7.0.0';
    const DEFAULT_CHARSET = 'UTF-8';

    //--------------------------------------------------------------------------

    /**
     * Set by {@link UCSDMath\Framework\Core\Application} which will triggger when
     * a request is handled by the framework.  The dispatch method takes a second argument,
     * which is the dispatched event object. Every event inherits from the generic Event class,
     * and is used to hold any information related to it.
     *
     * This event must have access to the current request, using an attribute
     * holding a Request.
     *
     * @param Request $request The Request instance
     *
     * @return RequestEvent The current interface
     *
     * @api
     */
    public function setRequest(Request $request): RequestEvent;

    //--------------------------------------------------------------------------

    /**
     * Get a stored event.
     *
     * @return Request The current Request instance
     *
     * @api
     */
    public function getRequest();

    //--------------------------------------------------------------------------
}
