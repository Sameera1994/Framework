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

namespace UCSDMath\Framework;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ResponseEvent is the default implementation of {@link ResponseEventInterface} which
 * provides routine Framework methods that are commonly used in the framework.
 *
 * Each time the framework handles a Request, a ResponseEvent event is now dispatched.
 *
 * {@link Event} is basically a adapter for the Symfony EventDispatcher Component
 * which this class extends.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) PdfInterface __construct();
 * (+) void __destruct();
 * (+) Response getResponse();
 * (+) Request getRequest();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class ResponseEvent extends Event implements ResponseEventInterface
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    public const VERSION = '1.15.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $response;
    protected $request;

    //--------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param Response $response The Response instance
     * @param Request  $request  The Request instance
     *
     * @api
     */
    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
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
     * Get the current response.
     *
     * @return Response The current interface
     *
     * @api
     */
    public function getResponse()
    {
        return $this->response;
    }

    //--------------------------------------------------------------------------

    /**
     * Get the current request.
     *
     * @return Request The current interface
     *
     * @api
     */
    public function getRequest()
    {
        return $this->request;
    }

    //--------------------------------------------------------------------------
}
