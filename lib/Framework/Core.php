<?PHP

namespace Lib\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Lib\Framework\Router;
use Lib\Framework\Container;
use Phroute\Phroute\Dispatcher;

class Core implements HttpKernelInterface
{

    protected $container;
    protected $router;
    protected $request;
    protected $baseDir;

    public function __construct()
    {
        $this->container = new Container;
        $this->request = $this->container->get('Request');
        $this->baseDir = $this->container->get('BaseDir');
        // Crank up the Router
        $this->router = new Router();
        $this->readFrontendRoutes();
        $this->readBackendRoutes();
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        
    
        return $response;
    }

    // Associates an URL with a callback function
    public function map($path, $controller)
    {
           $this->routes[$path] = $controller;
    }

    // add routes to the router
    public function addRoute($method, $route, $function)
    {
        $this->router->addRoute($method, $route, $function);
    }

    // read frontend routes from array
    public function readFrontendRoutes()
    {
        $routes = include($this->baseDir. '/routes/frontend.php');
        foreach ($routes as $route) {
            $this->addRoute($route[0], $route[1], $route[2]);
        }
    }

    //read backend routes from array
    public function readBackendRoutes()
    {
        $routes = include($this->baseDir. '/routes/backend.php');
        foreach ($routes as $route) {
            $routeLocation = 'backend' . $route[1];
            $this->addRoute($route[0], $routeLocation, $route[2]);
        }
    }

    // Generate the response
    public function run()
    {
        $dispatcher = new Dispatcher($this->router->getData());
        try {
            $response = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());
        } catch (HttpRouteNotFoundException $e) {
            $response = $dispatcher->dispatch('GET', '/errors/404');
        } catch (HttpMethodNotAllowedException $e) {
            $response = '400';
        }

        return $response;
    }
}
