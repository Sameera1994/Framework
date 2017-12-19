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

namespace UCSDMath\Framework\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * MathlinkControllerListener is the default implementation of {@link ControllerListenerInterface} which
 * provides routine Listener methods that are commonly used in the framework.
 *
 * {@link FilterControllerEvent} is basically a wrapper for Symfony's HttpKernel Event which
 * this class extends.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) OmnilockInterface __construct();
 * (+) void __destruct();
 * (+) void onCoreController(FilterControllerEvent $event);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class MathlinkControllerListener implements ControllerListenerInterface
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    public const VERSION = '2.2.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     *
     * @var    FilterControllerEvent $controller      The event controller
     * @static FrameworkInterface    $instance        The static instance FilterControllerEvent
     * @static int                   $objectCount     The static count of FilterControllerEvent
     * @var    array                 $storageRegister The stored set of data structures used by this class
     */
    protected $controller;
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
    public function onCoreController(KernelEvent $event): void
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $this->controller = $event->getController();

            if (isset($this->controller[0])) {
                $this->controller = $this->controller[0];

                if (method_exists($this->controller, 'preExecute')) {
                    $this->controller->preExecute();
                }
            }
        }
    }

    //--------------------------------------------------------------------------
}
