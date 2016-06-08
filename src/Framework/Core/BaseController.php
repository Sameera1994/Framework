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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

/**
 * BaseController is the default implementation of {@link Controller} which
 * provides routine controller methods that are commonly used in the framework.
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

    /**
     * Destructor.
     *
     * @api
     */
    public function reRoute(string $routeName, array $params, int $status = 301)
    {
        $this->redirectToRoute($newRoute, $params, $status);

    }

    //--------------------------------------------------------------------------
}
