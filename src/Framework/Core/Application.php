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

namespace UCSDMath\Framework\Core;

use UCSDMath\Framework\Framework;
use Symfony\Component\Routing\Route;
use UCSDMath\Framework\Event\RequestEvent;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use UCSDMath\Framework\Core\ApplicationInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventDispatcher;
use UCSDMath\DependencyInjection\ServiceRequestContainer;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Application is the default implementation of {@link HttpKernelInterface} which
 * provides a structured process for converting a (HTTP) Request into a Response.
 *
 * Routing is set in the Front Controller through a defined closure. There is
 * an option to set url parameters from a controller if it makes sense
 * to use them in each of the applications (e.g., App.php).
 * {@link http://en.wikipedia.org/wiki/Front_Controller_pattern}.
 *
 * This class makes use of the Observer Pattern to trigger defined events within
 * our controller (@link http://en.wikipedia.org/wiki/Observer_pattern).
 *
 * This includes Symfony EventDispatcher and RouteCollection for services and
 * registers event listeners (hooks) into the UCSDMath Framework.
 * {@link http://symfony.com/doc/current/components/event_dispatcher/}
 *
 * In each application, a default route can be specified through {@link setDefaultRoute()}.
 * If a default route is proved, any URL not specified in the controller will dispatch
 * the user to the default location and override any error message.
 *
 * Method list: (+) @api, (-) protected or private visibility.
 *
 * (+) HttpKernelInterface __construct(RouteCollection $routes, EventDispatcher $dispatcher);
 * (+) void                __destruct();
 * (+) handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true);
 * (+) setDefaultRoute($defaultRoute);
 * (+) map($path, $controller);
 * (+) on($event, $callback);
 * (+) fire($event);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 *
 * @api
 */
class Application implements HttpKernelInterface, ApplicationInterface
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
     */
    protected $routes;
    protected $service;
    protected $dispatcher;
    protected $resolver;
    protected $matcher;
    protected $defaultRoute = null;
    protected $config;

    // --------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param RouteCollection  $routes      A RouteCollection Interface
     * @param EventDispatcher  $dispatcher  A EventDispatcher Interface
     *
     * @api
     */
    public function __construct(
        RouteCollection $routes,
        EventDispatcher $dispatcher
    ) {
        $this->routes = $routes;
        $this->dispatcher = $dispatcher;
        $this->service = ServiceRequestContainer::init();
    }

    // --------------------------------------------------------------------------

    /**
     * This method defines the workflow from the HTTP Request and ends with a Response.
     * HttpKernel allows us to use event listeners and does the work by dispatching those events.
     * Basically we are creating an EventDispatcher and a controller resolver in this handle method.
     *
     * {@link http://symfony.com/doc/current/components/event_dispatcher/introduction.html#usage}
     *
     * @param Request $request  A Request Interface
     * @param int     $type     A default type request [MASTER_REQUEST = 1, SUB_REQUEST = 2]
     * @param bool    $catch    A option to catch exceptions or not
     *
     * @throws \Exception  when an Exception occurs during processing
     * @throws \ResourceNotFoundException  when a specified route is not registered or found
     *
     * @return \Symfony\Component\HttpFoundation\Response Sending the response back
     *
     * @api
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $event = new RequestEvent();
        $event->setRequest($request);
        $this->dispatcher->dispatch('request', $event);

        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $attributes = $matcher->match($request->getPathInfo());
            $controller = $attributes['controller'];
            unset($attributes['controller']);
            $response = call_user_func_array($controller, $attributes);
        } catch (ResourceNotFoundException $e) {
            $response = $this->errorResponse('Router could not resolve specified route. Route was not defined.' . $e, Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    // --------------------------------------------------------------------------

    /**
     * Send new response if Route is null.
     *
     * @param string  $message  A message to send on error
     * @param int     $error    A http error number
     *
     * @return \Symfony\Component\HttpFoundation\Response Send the response
     * @api
     */
    public function errorResponse(string $message, $error): \Symfony\Component\HttpFoundation\Response
    {
        $response = null;

        if (! is_null($this->defaultRoute)) {
            $this->redirectRoute($this->defaultRoute);
        } else {
            $response = new Response($message, $error);
        }

        return $response;
    }

    // --------------------------------------------------------------------------

    /**
     * Sends the redirect (RedirectResponse extends Response).
     *
     * @param string  $path  A defined URI path
     *
     * @return \Symfony\Component\HttpFoundation\Response Send the response
     * @api
     */
    public function redirectRoute(string $path)
    {
        $response = new RedirectResponse($path);
        $response->send();
    }

    // --------------------------------------------------------------------------

    /**
     * Creating a map method that binds a URI to a PHP callback that will be executed
     * if the right URI is matched. This way all routing can be defined in the top
     * controller of the application.
     *
     * Associates an URI or URL with a callback function.
     *
     * @param string  $path        A defined URI path
     * @param Object  $controller  A callback function (reference a defined closure)
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     *
     * @api
     */
    public function map(string $path, $controller): HttpKernelInterface
    {
        $this->routes->add($path, new Route($path, array('controller' => $controller)));

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the application default route or location URI (e.g., /sso/1/news-manager/).
     * If any problem with mapping URL Routing, we default to this location.
     *
     * @param string  $defaultRoute  A defined URI path
     *
     * @return \UCSDMath\Framework\Core\ApplicationInterface
     *
     * @api
     */
    public function setDefaultRoute(string $defaultRoute = null): ApplicationInterface
    {
        $this->defaultRoute = rtrim($defaultRoute, '/\\') . '/';

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Add event listener to the dispatcher.
     *
     * The EventDispatcher class allows us to register listeners to particular events
     * that can be triggered through a callable function or method.
     *
     * Here we can bind an event to a PHP callback function.  The components of this
     * application allows it to communicate by implementing an Observer pattern.
     *
     * @see http://en.wikipedia.org/wiki/Observer_pattern
     *
     * @param string  $event     A defined URI path
     * @param Object  $callback  A callback function (reference a defined closure)
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     *
     * @api
     */
    public function on($event, $callback): HttpKernelInterface
    {
        $this->dispatcher->addListener($event, $callback);

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Tell dispatcher to notify all the listeners he knows when some event occurs.
     *
     * @param string  $event   A EventDispatcher Interface
     *
     * @return \Symfony\Component\EventDispatcher\Event A dispached event
     *
     * @api
     */
    public function fire($event): \Symfony\Component\EventDispatcher\Event
    {
        return $this->dispatcher->dispatch($event);
    }

    // --------------------------------------------------------------------------

    /**
     * Bootstrap any needed resources for the core application.
     *
     * @return \UCSDMath\Framework\Core\ApplicationInterface
     *
     * @api
     */
    public function startupApplication(): \UCSDMath\Framework\Core\ApplicationInterface
    {
        $this->config = $this->service->get('Config');

        return $this;
    }

    // --------------------------------------------------------------------------
}
