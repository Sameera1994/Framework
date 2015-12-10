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

/**
 * RequestEventInterface is the interface implemented by all {@link UCSDMath\Framework\RequestEvent} classes.
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
interface RequestEventInterface
{
    /**
     * Constants.
     */
    const REQUIRED_PHP_VERSION = '5.6.10';
    const DEFAULT_CHARSET = 'UTF-8';
}
