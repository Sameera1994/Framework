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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

/**
 * Framework is the default implementation of {@link HttpKernelInterface} which
 * provides routine Framework methods that are commonly used in the framework.
 *
 * {@link AbstractFramework} is basically a adapter class for Symfony
 * HttpKernel Component which this class extends.
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
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) HttpKernelInterface __construct();
 * (+) void __destruct();
 * (+) Response handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true);
 * (-) \Exception throwControllerResolverExceptionError();
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class Framework extends AbstractFramework implements HttpKernelInterface, FrameworkInterface
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
     * @var EventDispatcher  $dispatcher The EventDispatcher
     * @var UrlMatcher       $matcher    The UrlMatcher
     * @var ArgumentResolver $resolver   The ArgumentResolver
     */
    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    //--------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param EventDispatcher  $dispatcher The EventDispatcher
     * @param UrlMatcher       $matcher    The UrlMatcherInterface
     * @param ArgumentResolver $resolver   The ArgumentResolverInterface
     *
     * @api
     */
    public function __construct(
        EventDispatcher $dispatcher,
        UrlMatcher $matcher,
        ArgumentResolver $resolver
    ) {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;
        parent::__construct();
    }

    //--------------------------------------------------------------------------

    /**
     * Destructor.
     *
     * @api
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    //--------------------------------------------------------------------------

    /**
     * This method defines the workflow from the HTTP Request and ends with a Response.
     * HttpKernel allows us to use event listeners and does the work by dispatching those events.
     * Basically we are creating an EventDispatcher and a controller resolver in this handle method.
     *
     * @param Request $request The Request instance
     * @param int     $type    The default type request [MASTER_REQUEST = 1, SUB_REQUEST = 2]
     * @param bool    $catch   The option to catch exceptions or not
     *
     * @throws \ResourceNotFoundException When a controller not found occurs during processing
     * @throws \Exception When an Exception occurs during processing
     *
     * @return Response The current Response interface
     *
     * @api
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true): Response
    {
        $this->matcher->getContext()->fromRequest($request);
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->resolver->getController($request);
            $arguments = 'boolean' === gettype($controller)
                ? $this->throwControllerResolverExceptionError()
                : $this->resolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (\Exception $e) {
            $response = new Response('An error occurred', 500);
        }
        /* Dispatch a response event */
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }

    //--------------------------------------------------------------------------

    /**
     * Notify that the controller specified does not exist.
     *
     * @return \Exception The current warning
     */
    protected function throwControllerResolverExceptionError(): \Exception
    {
        throw new \Exception("The controller can not be resolved for the application. Please check that it exists.");
    }

    //--------------------------------------------------------------------------
}
