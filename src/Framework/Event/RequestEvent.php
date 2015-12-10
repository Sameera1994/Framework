<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UCSDMath\Framework\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * RequestEvent is the default implementation of {@link Symfony\Component\EventDispatcher\Event}
 * which provides the base class for classes containing event data. It is used by events
 * that do not pass state information to an event handler when an event is raised.
 *
 * {@link UCSDMath\Framework\Core\Application} uses hooks to register events that get
 * triggered through the dispacher. This is used as an extension to the Symfony
 * {@link Symfony\Component\EventDispatcher\Event}.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) RequestEventInterface __construct();
 * (+) void __destruct();
 * (+) RequestEventInterface getRequest();
 * (+) RequestEventInterface setRequest(Request $request);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
class RequestEvent extends Event implements RequestEventInterface
{
    /**
     * Constants.
     *
     * @var string VERSION  A version number
     *
     * @api
     */
    const VERSION = '1.5.0';

    // --------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $request;

    // --------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct()
    {

    }

    // --------------------------------------------------------------------------

    /**
     * Set by {@link UCSDMath\Framework\Core\Application} which will triggger when
     * a request is handled by the framework.  The dispatch method takes a second argument,
     * which is the dispatched event object. Every event inherits from the generic Event class,
     * and is used to hold any information related to it.
     *
     * This event must have access to the current request, using an attribute
     * holding a Request instance.
     *
     * @param Request $request  A Request instance
     *
     * @return RequestEvent Instance
     *
     * @api
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Get a stored event
     *
     * @return Request Instance
     *
     * @api
     */
    public function getRequest()
    {
        return $this->request;
    }
}
