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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * RequestEvent is the default implementation of {@link RequestEventInterface} which
 * provides routine Framework methods that are commonly used in the framework.
 *
 * Each time the framework handles a Request, a ResponseEvent event is now dispatched.
 *
 * {@link Event} is basically a adapter for the Symfony EventDispatcher Component
 * which this class extends.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) RequestEventInterface __construct();
 * (+) void __destruct();
 * (+) RequestEvent setRequest(Request $request);
 * (+) Request getRequest();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class RequestEvent extends Event implements RequestEventInterface
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    public const VERSION = '1.16.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $request;

    //--------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct()
    {
    }

    //--------------------------------------------------------------------------

    /**
     * Destructor.
     *
     * @api
     */
    public function __destruct()
    {
    }

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
    public function setRequest(Request $request): RequestEvent
    {
        $this->request = $request;

        return $this;
    }

    //--------------------------------------------------------------------------

    /**
     * Get a stored event.
     *
     * @return Request The current Request instance
     *
     * @api
     */
    public function getRequest()
    {
        return $this->request;
    }

    //--------------------------------------------------------------------------
}
