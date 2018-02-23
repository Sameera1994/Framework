<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) 2015-2018 UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace UCSDMath\Framework\Core;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * BaseController is the default implementation of {@link Controller} which
 * provides routine controller methods that are commonly used in the framework.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) Controller __construct();
 * (+) void __destruct();
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
    public const VERSION = '2.5.0';

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
     * Route to new location with name.
     *
     * @param string $routeName The route
     * @param array  $params    The parameters
     * @param int    $status    The status number
     *
     * @return void
     *
     * @api
     */
    public function reRoute(string $routeName, array $params, int $status = 301): void
    {
        $this->redirectToRoute($routeName, $params, $status);
    }

    //--------------------------------------------------------------------------
}
