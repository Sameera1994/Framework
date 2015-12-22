<?php

/*
 * This file is part of the UCSDMath package.
 *
 * (c) UCSD Mathematics | Math Computing Support <mathhelp@math.ucsd.edu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UCSDMath\Framework;

/**
 * FrameworkInterface is the interface implemented by all Framework classes.
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
interface FrameworkInterface
{
    /**
     * Constants.
     */
    const REQUIRED_PHP_VERSION = '7.0.0';
    const DEFAULT_CHARSET = 'UTF-8';
}
