<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UCSDMath\Framework;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ResponseEvent is the default implementation of {@link ResponseEventInterface} which
 * provides routine framework methods that are commonly used throughout the framework.
 *
 * Each time the framework handles a Request, a ResponseEvent event is now dispatched
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) __construct();
 * (+) getResponse();
 * (+) getRequest();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
class ResponseEvent extends Event implements ResponseEventInterface
{
    /**
     * Constants.
     *
     * @var string VERSION  A version number
     *
     * @api
     */
    const VERSION = '1.7.0';

    // --------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $response;
    protected $request;

    // --------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param Response  $response  A Response
     * @param Request   $request   A Request
     *
     * @api
     */
    public function __construct(
        Response $response,
        Request $request
    ) {
        $this->response = $response;
        $this->request = $request;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the current response.
     *
     * @return Response Interface
     *
     * @api
     */
    public function getResponse()
    {
        return $this->response;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the current request.
     *
     * @return Request Interface
     *
     * @api
     */
    public function getRequest()
    {
        return $this->request;
    }

    // --------------------------------------------------------------------------
}
