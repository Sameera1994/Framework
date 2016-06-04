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

namespace UCSDMath\Framework\Listener;

/**
 * ControllerListenerInterface is the interface implemented by all Framework classes.
 *
 * Method list: (+) @api.
 *
 * (+) void onCoreController(FilterControllerEvent $event);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
interface ControllerListenerInterface
{
    /**
     * Constants.
     */

    //--------------------------------------------------------------------------

    /**
     * Check event status.
     *
     *   - HttpKernelInterface::MASTER_REQUEST === 1
     *   - HttpKernelInterface::SUB_REQUEST === 2
     *
     * @param KernelEvent $event A KernelEvent
     *
     * @return void
     *
     * @api
     */
    public function onCoreController(Symfony\Component\HttpKernel\Event\KernelEvent $event);

    //--------------------------------------------------------------------------
}
