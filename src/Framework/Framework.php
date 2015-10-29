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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use UCSDMath\DependencyInjection\ServiceRequestContainer;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * Framework is the default implementation of {@link FrameworkInterface} which
 * provides routine framework methods that are commonly used throughout the framework.
 *
 * Framework provides a event dispatch structured process for listening
 * to (HTTP) Request. Much like the standard like WSGI in Python or Rack in Ruby.
 *
 * If your code dispatches an event to the dispatcher, the dispatcher notifies all
 * registered listeners for the event, and each listener do whatever it wants
 * with the event.
 *
 * A well-known design pattern, the Observer pattern, allows any kind of behaviors
 * to be attached to our framework; the Symfony2 EventDispatcher Component
 * implements this pattern.
 *
 * Being extensible means that the developer should be able to easily hook into
 * the framework life cycle to modify the way the request is handled.
 *
 * Method list:
 *
 * @method __construct();
 * @method handle();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
class Framework extends AbstractFramework implements HttpKernelInterface, FrameworkInterface
{
    /**
     * Constants.
     *
     * @var string VERSION  A version number
     *
     * @api
     */
    const VERSION = '1.4.0';

    // --------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    // --------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param EventDispatcher             $dispatcher A EventDispatcher instance
     * @param UrlMatcherInterface         $matcher    A UrlMatcherInterface instance
     * @param ControllerResolverInterface $resolver   A ControllerResolverInterface instance
     *
     * @api
     */
    public function __construct(
        EventDispatcher $dispatcher,
        UrlMatcherInterface $matcher,
        ControllerResolverInterface $resolver
    ) {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;

        parent::__construct();
    }

    // --------------------------------------------------------------------------

    /**
     * This method defines the workflow from the HTTP Request and ends with a Response.
     * HttpKernel allows us to use event listeners and does the work by dispatching those events.
     * Basically we are creating an EventDispatcher and a controller resolver in this handle method.
     *
     * @param Request $request  A Request instance
     * @param integer $type     A default type request [MASTER_REQUEST = 1, SUB_REQUEST = 2]
     * @param Boolean $catch    A option to catch exceptions or not
     *
     * @throws \ResourceNotFoundException When a controller not found occurs during processing
     * @throws \Exception When an Exception occurs during processing
     *
     * @return Response Interface instance
     *
     * @api
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);

        } catch (\Exception $e) {
            $response = new Response('An error occurred', 500);

        }

        /** Dispatch a response event */
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}
