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

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * MathlinkControllerListener is the default implementation of {@link FrameworkInterface} which
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
class MathlinkControllerListener implements FrameworkInterface
{
    /**
     * Constants.
     *
     * @var string VERSION A version number
     *
     * @api
     */
    const VERSION = '1.7.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     *
     * @var    FilterControllerEvent $controller      A event controller
     * @static FrameworkInterface    $instance        A static instance FilterControllerEvent
     * @static int                   $objectCount     A static count of FilterControllerEvent
     * @var    array                 $storageRegister A stored set of data structures used by this class
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
     *   - HttpKernelInterface::MASTER_REQUEST === 1
     *   - HttpKernelInterface::SUB_REQUEST === 2
     *
     * @param KernelEvent $event A KernelEvent
     *
     * @api
     */
    public function onCoreController(Symfony\Component\HttpKernel\Event\KernelEvent $event)
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
