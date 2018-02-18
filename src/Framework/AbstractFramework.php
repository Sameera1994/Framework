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

namespace UCSDMath\Framework;

/**
 * AbstractFramework provides an abstract base class implementation of {@link FrameworkInterface}.
 * This service groups a common code base implementation that Framework extends.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) FrameworkInterface __construct();
 * (+) void __destruct();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
abstract class AbstractFramework implements FrameworkInterface
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    public const VERSION = '2.4.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     *
     * @static FrameworkInterface $instance        The static instance FrameworkInterface
     * @static int                $objectCount     The static count of FrameworkInterface
     * @var    array              $storageRegister The stored set of data structures used by this class
     */
    protected static $instance;
    protected static $objectCount = 0;
    protected $storageRegister    = [];

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
        static::$objectCount--;
    }

    //--------------------------------------------------------------------------
}
