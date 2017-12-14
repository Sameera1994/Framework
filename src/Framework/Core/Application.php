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

namespace UCSDMath\Framework\Core;

use Symfony\Component\Routing\Route;
use UCSDMath\Framework\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use UCSDMath\Framework\Core\ApplicationInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UCSDMath\DependencyInjection\ServiceRequestContainer;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Application is the default implementation of {@link ApplicationInterface} which
 * provides routine Yaml methods that are commonly used in the framework.
 *
 * {@link HttpKernelInterface} is basically a adapter class for Symfony
 * HttpKernel Component which this class extends.
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
 * (+) Symfony\Component\HttpKernel\HttpKernelInterface __construct($routes, $dispatcher);
 * (+) void __destruct();
 * (+) Symfony\Component\EventDispatcher\Event fire($event);
 * (+) UCSDMath\Framework\Core\ApplicationInterface startupApplication();
 * (+) Symfony\Component\HttpKernel\HttpKernelInterface on($event, $callback);
 * (+) Symfony\Component\HttpKernel\HttpKernelInterface map(string $path, $controller);
 * (+) Symfony\Component\HttpFoundation\Response errorResponse(string $message, int $error);
 * (+) void requestRoute(string $destination, int $statusCode = 302, bool $trailFix = false);
 * (+) UCSDMath\Framework\Core\ApplicationInterface setDefaultRoute(string $defaultRoute = null);
 * (+) Symfony\Component\HttpFoundation\Response handle(\Symfony\Component\HttpFoundation\Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true);
 *
 * @author Daryl Eisner <deisner@ucsd.edu>
 */
class Application implements HttpKernelInterface, ApplicationInterface
{
    /**
     * Constants.
     *
     * @var string VERSION The version number
     *
     * @api
     */
    public const VERSION = '2.1.0';

    //--------------------------------------------------------------------------

    /**
     * Properties.
     */
    protected $config       = null;
    protected $defaultRoute = null;
    protected $dispatcher   = null;
    protected $matcher      = null;
    protected $resolver     = null;
    protected $routes       = null;
    protected $service      = null;
    protected $controller   = null;

    //--------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param RouteCollection $routes     The RouteCollection Interface
     * @param EventDispatcher $dispatcher The EventDispatcher Interface
     *
     * @api
     */
    public function __construct(RouteCollection $routes, EventDispatcher $dispatcher)
    {
        $this->routes = $routes;
        $this->dispatcher = $dispatcher;
        $this->controller = new BaseController();
        $this->service = ServiceRequestContainer::serviceConnect();
    }

    //--------------------------------------------------------------------------

    /**
     * Destructor.
     *
     * @api
     */
    public function __destruct()
    {
    }

    //--------------------------------------------------------------------------

    /**
     * This method defines the workflow from the HTTP Request and ends with a Response.
     * HttpKernel allows us to use event listeners and does the work by dispatching those events.
     * Basically we are creating an EventDispatcher and a controller resolver in this handle method.
     *
     * {@link http://symfony.com/doc/current/components/event_dispatcher/introduction.html#usage}
     *
     * @param Request $request The Request instance
     * @param int     $type    The default type request [MASTER_REQUEST = 1, SUB_REQUEST = 2]
     * @param bool    $catch   The option to catch exceptions or not
     *
     * @throws \Exception when an Exception occurs during processing
     * @throws \ResourceNotFoundException when a specified route is not registered or found
     *
     * @return Response The current Response
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

    //--------------------------------------------------------------------------

    /**
     * Send new response if Route is null.
     *
     * @param string $message The message to send on error
     * @param int    $error   The http error number
     *
     * @return Response The current Response
     * @api
     */
    public function errorResponse(string $message, int $error): Response
    {
        return is_null($this->defaultRoute) ? new Response($message, $error) : $this->requestRoute($this->defaultRoute);
    }

    //--------------------------------------------------------------------------

    /**
     * Redirect to a new location (RedirectResponse extends Response).
     *
     * @param string $destination The URL or local location
     * @param int    $statusCode  The HTTP Status Code
     * @param bool   $trailFix    The option fix for the trailing slash
     *
     * @return void
     *
     * @api
     */
    public function requestRoute(string $destination, int $statusCode = 302, bool $trailFix = false): void
    {
        $response = true === $trailFix
            ? new RedirectResponse(rtrim($destination, '/\\').'/', $statusCode)
            : new RedirectResponse($destination, $statusCode);
        $response->send();
    }

    //--------------------------------------------------------------------------

    /**
     * Creating a map method that binds a URI to a PHP callback that will be executed
     * if the right URI is matched. This way all routing can be defined in the top
     * controller of the application.
     *
     * Associates an URI or URL with a callback function.
     *
     * @param string $path       The defined URI path
     * @param Object $controller The callback function (reference a defined closure)
     *
     * @return HttpKernelInterface The current instance
     *
     * @api
     */
    public function map(string $path, $controller): HttpKernelInterface
    {
        $this->routes->add($path, new Route($path, array('controller' => $controller)));

        return $this;
    }

    //--------------------------------------------------------------------------

    /**
     * Set the application default route or location URI (e.g., /sso/1/news-manager/).
     * If any problem with mapping URL Routing, we default to this location.
     *
     * @param string $defaultRoute The defined URI path
     *
     * @return ApplicationInterface The current instance
     *
     * @api
     */
    public function setDefaultRoute(string $defaultRoute = null): ApplicationInterface
    {
        $this->defaultRoute = rtrim($defaultRoute, '/\\') . '/';

        return $this;
    }

    //--------------------------------------------------------------------------

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
     * @param string $event    The defined URI path
     * @param Object $callback The callback function (reference a defined closure)
     *
     * @return HttpKernelInterface The current instance
     *
     * @api
     */
    public function on($event, $callback): HttpKernelInterface
    {
        $this->dispatcher->addListener($event, $callback);

        return $this;
    }

    //--------------------------------------------------------------------------

    /**
     * Tell dispatcher to notify all the listeners he knows when some event occurs.
     *
     * @param string $event The EventDispatcher Interface
     *
     * @return \Symfony\Component\EventDispatcher\Event The dispached event
     *
     * @api
     */
    public function fire($event): \Symfony\Component\EventDispatcher\Event
    {
        return $this->dispatcher->dispatch($event);
    }

    //--------------------------------------------------------------------------

    /**
     * Add an extended controller class for the application.
     *
     * @param string $controller The controller and method option
     *
     * @return \UCSDMath\Application\Controller
     *
     * @api
     */
    public function addController(string $controller)
    {
        [$class, $method] = strpos($controller, '::') ? explode('::', $controller) : [$controller, null];
        [$appController, $class] = [
            sprintf('Controllers/%s%s', str_replace('Controller', '', $class), 'Controller'),
            sprintf('\UCSDMath\Application\Controller\%s%s', str_replace('Controller', '', $class), 'Controller')
        ];
        $this->config->setRequiredClass($appController);
        $instance = new $class();

        return null === $method ? $instance : $instance->$method();
    }

    //--------------------------------------------------------------------------

    /**
     * Bootstrap any needed resources for the core application.
     *
     * @return ApplicationInterface The current instance
     *
     * @api
     */
    public function startupApplication(): ApplicationInterface
    {
        $this->config = $this->service->Config;

        return $this;
    }

    //--------------------------------------------------------------------------
}
