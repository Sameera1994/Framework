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

namespace UCSDMath\Framework\Listener;

use Symfony\Component\HttpKernel\Event\KernelEvent;

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
     * @param KernelEvent $event The KernelEvent
     *
     * @return void
     *
     * @api
     */
    public function onCoreController(KernelEvent $event);

    //--------------------------------------------------------------------------
}
