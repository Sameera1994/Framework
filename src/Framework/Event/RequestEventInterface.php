<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) 2015-2017 UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace UCSDMath\Framework\Event;

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
     *
     * @var string FRAMEWORK_MINIMUM_PHP The framework's minimum supported PHP version
     * @var string DEFAULT_CHARSET       The character encoding for the system
     * @var string CRLF                  The carriage return line feed
     * @var bool   REQUIRE_HTTPS         The secure setting TLS/SSL site requirement
     * @var string DEFAULT_TIMEZONE      The local timezone for the server (or set in ini.php)
     */
    const FRAMEWORK_MINIMUM_PHP = '7.1.0';
    const DEFAULT_CHARSET       = 'UTF-8';
    const CRLF                  = "\r\n";
    const REQUIRE_HTTPS         = true;
    const DEFAULT_TIMEZONE      = 'America/Los_Angeles';

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
