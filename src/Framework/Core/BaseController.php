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

namespace UCSDMath\Framework\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Framework is the default implementation of {@link HttpKernelInterface} which
 * provides routine Framework methods that are commonly used in the framework.
 *
 * {@link AbstractFramework} is basically a adapter class for Symfony
 * HttpKernel Component which this class extends.
 *
 * Framework provides a event dispatch structured process for listening
 * to (HTTP) Request. Much like the standard like WSGI in Python or Rack in Ruby.
 *
 * If your code dispatches an event to the dispatcher, the dispatcher notifies all
 * registered listeners for the event, and each listener do whatever it wants
 * with the event.
 *
 * A well-known design pattern, the Observer pattern, allows any kind of behaviors
 * to be attached to our framework; the Symfony2 EventDispatcher Component
 * implements this pattern.
 *
 * Being extensible means that the developer should be able to easily hook into
 * the framework life cycle to modify the way the request is handled.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) HttpKernelInterface __construct();
 * (+) void __destruct();
 * (+) Response handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true);
 * (-) \Exception throwControllerResolverExceptionError();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class BaseController extends Controller
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    const VERSION = '1.7.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     */

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
}
