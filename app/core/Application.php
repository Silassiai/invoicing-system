<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:54
 *
 * Application
 * This is the main class that manages the entire application
 * All config details are used in here
 * @see app/config/config.php
 * @see app/config/databse.php
 * @see app/config/hooks.php
 * @see app/config/routes.php
 */

namespace core;

class Application
{
    private $routes = [];
    private $config = [];
    private $controller = '';
    private $method = '';
    private $params = [];
    private $hooks = [];
    static public $sess_ref = [];
    static public $request = [];

    /**
     * Application constructor.
     */
    public function __construct()
    {
        // all the magic starts here
        $this->init();

        Application::createSessionReference();

        Application::initRequest();

        $this->triggerPreControllerHooks();

        $this->execute();
    }

    /**
     * init
     * set up core constants
     * load core functions
     * check what hooks are configured
     * load routes and check what controller and method is called
     */
    public function init()
    {
        $this->loadConfig();

        $this->setPathConstants();

        $this->loadFunctions();

        $this->setHooks();

        $this->setRoutes();

        $this->getUrl();
    }

    /**
     * getUrl
     * Check what controller and method is called
     * If there is no controleller called, the default will be triggered (default is set in the config file)
     * If the method is empty, the index is called by default.
     * If the method is not set in the routes, the notFound page will be triggered
     */
    public function getUrl()
    {
        // TODO: get invoice-system with some PHP magic
        $request = rtrim(str_replace('/invoicing-system/', '', $_SERVER['REQUEST_URI']), '/');
        $request_parsed = explode('/', $request);
        $class_name = isset($request_parsed[0]) ? $request_parsed[0] : '';
        $method_name = isset($request_parsed[1]) ? $request_parsed[1] : '';

        unset($request_parsed[0], $request_parsed[1]);
        $this->params = count($request_parsed) > 0 ? $request_parsed : [];

        if (isset($this->routes[$class_name . '/' . $method_name]) || isset($this->routes[$class_name])) {
            if ($method_name === '') { // call the default method
                $this->controller = 'controllers\\' . ucfirst($this->routes[$class_name][0]);
                $this->method = 'index';
            } else {
                if (isset($this->routes[$class_name . '/' . $method_name])) {
                    $this->controller = 'controllers\\' . ucfirst($this->routes[$class_name . '/' . $method_name][0]);
                } else {
                    $this->controller = 'controllers\\' . 'Invoice';
                }
                $this->method = (isset($this->routes[$class_name . '/' . $method_name][1]) ?
                    $this->routes[$class_name . '/' . $method_name][1] : 'notFound');

            }
        } else {
            $this->controller = 'controllers\\' . 'Invoice';
            if ($class_name === '' && $method_name === '') {
                $this->method = 'index';
            } else {
                $this->method = 'notFound';
            }
        }
    }

    /**
     * execute
     * Call the controller and its method
     */
    public function execute()
    {
        $controller = new $this->controller();
        call_user_func_array([$controller, $this->method], $this->params);
    }

    /**
     * createSessionReference
     * refer sessionref to PHP $_SESSION global
     */
    final private static function createSessionReference()
    {
        @session_start();
        // Create session reference
        if (isset($_SESSION)) {
            Application::$sess_ref = &$_SESSION;
        }
    }

    /**
     * initRequest
     * asign the $_POST variable to our request var
     */
    final private static function initRequest()
    {
        if (isset($_POST) && count($_POST) > 0) {
            Application::$request = &$_POST;
        }
    }

    /**
     * sessionGet
     * @param string $key
     * @param null $default
     *
     * @return bool|null
     */
    final public static function sessionGet($key = '', $default = null)
    {
        if ($key === '') {
            return Application::$sess_ref;
        }
        if (!isset(Application::$sess_ref[$key])) {
            return $default;
        }

        return Application::$sess_ref[$key];
    }

    /**
     * sessionSet
     * @param $key
     * @param $value
     */
    final public static function sessionSet($key, $value)
    {
        Application::$sess_ref[$key] = $value;
    }

    /**
     * sessionDestroy
     * @param bool $redirect
     */
    final public static function sessionDestroy($redirect = false)
    {
        Application::$sess_ref = [];

        if (session_id()) {
            @session_destroy();
        }

        if ($redirect) {
            header('Location: ' . str_replace('index.php', '', $_SERVER['PHP_SELF']));
            exit;
        }
    }

    /**
     * loadConfig
     */
    public function loadConfig()
    {
        if (!defined('SDR_BASE_PATH')) {
            define('SDR_BASE_PATH', dirname(dirname(dirname(__FILE__))));
            $config_path = SDR_BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
            if (file_exists($config_path . 'config.php')) {
                require $config_path . 'config.php';
                if (isset($config) && is_array($config)) {
                    $this->config = $config;

                    if (isset($this->config['debug']) && $this->config['debug'] === true) {
                        ini_set('display_errors', 1);
                    }
                }
            }
        }
    }

    /**
     * setPathConstants
     */
    public function setPathConstants()
    {
        if (!defined('BASE_URL')) {
            define('BASE_URL', $this->config['base_url']);
            define('SDR_PATH_APP', SDR_BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
            define('SDR_PATH_CONTROLLERS', SDR_PATH_APP . 'controller' . DIRECTORY_SEPARATOR);
            define('SDR_PATH_MODELS', SDR_PATH_APP . 'models' . DIRECTORY_SEPARATOR);
            define('SDR_PATH_CONFIG', SDR_PATH_APP . 'config' . DIRECTORY_SEPARATOR);
            define('SDR_PATH_CORE', SDR_PATH_APP . 'core' . DIRECTORY_SEPARATOR);
            define('SDR_PATH_VIEW', SDR_PATH_APP . 'views' . DIRECTORY_SEPARATOR);
        }
    }

    /**
     * loadFunctions
     */
    public function loadFunctions()
    {
        if (!function_exists('dd')) {
            require_once SDR_PATH_CORE . 'functions.php';
        }
    }

    /**
     * setHooks
     */
    public function setHooks()
    {
        if (file_exists(SDR_PATH_CONFIG . 'hooks.php')) {
            require SDR_PATH_CONFIG . 'hooks.php';
            if (isset($hook) && is_array($hook)) {
                $this->hooks = $hook;
            }
        }
    }

    /**
     * setRoutes
     */
    public function setRoutes()
    {
        if (file_exists(SDR_PATH_CONFIG . 'routes.php')) {
            require SDR_PATH_CONFIG . 'routes.php';
            if (isset($route) && is_array($route)) {
                $this->routes = $route;
            }
        }
    }

    /**
     * triggerPreControllerHooks
     */
    public function triggerPreControllerHooks()
    {
        if (isset($this->hooks['pre_controller'])) {
            foreach ($this->hooks['pre_controller'] as $hook) {
                $class_name = 'hooks\\' . $hook['class'];
                $instance = new  $class_name();
                $method = $hook['method'];
                $instance->$method();
            }
        }
    }
}