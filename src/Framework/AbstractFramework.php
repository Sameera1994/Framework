<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace UCSDMath\Framework;

/**
 * AbstractFramework provides an abstract base class implementation of {@link FrameworkInterface}.
 * Primarily, this services the fundamental implementations for all Framework classes.
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
     * @var string VERSION  A version number
     *
     * @api
     */
    const VERSION = '1.7.0';

    // --------------------------------------------------------------------------

    /**
     * Properties.
     *
     * @var    array              $storageRegister  A set of validation stored data elements
     * @static FrameworkInterface $instance         A FrameworkInterface
     * @static int                $objectCount      A FrameworkInterface count
     */
    protected $storageRegister = array();
    protected static $instance = null;
    protected static $objectCount = 0;

    // --------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct()
    {
        static::$objectCount++;
    }

    // --------------------------------------------------------------------------

    /**
     * Destructor.
     *
     * @api
     */
    public function __destruct()
    {
        static::$objectCount--;
    }

    // --------------------------------------------------------------------------
}
