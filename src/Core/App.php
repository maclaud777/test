<?php
declare(strict_types=1);


namespace Core;


use mysqli;
use ReflectionException;
use Core\Http\Request;
use Core\Http\ResponseSender;
use Psr\Log\LoggerInterface;

/**
 * Class App
 * @package Core
 */
class App
{
    /**
     * @var App|null
     */
    private static ?App $instance = null;

    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var LoggerInterface
     */
    public static LoggerInterface $logger;

    /**
     * @var mysqli
     */
    public static mysqli $dbConnection;

    /**
     * @var Session
     */
    public static Session $session;

    /**
     * @var Auth
     */
    protected Auth $auth;

    /**
     * App constructor.
     */
    protected function __construct() { }

    protected function __clone() { }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function run()
    {
        $this->init();

        $response = $this->handleRequest();

        $responseSender = new ResponseSender();
        $responseSender->send($response);
    }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    protected function init()
    {
        self::$logger = new Logger($this->config['logger']);

        (new ErrorHandler())->init();

        self::$dbConnection = (new Database())->connect($this->config['db']);

        self::$session = new Session();
        self::$session->start();

        $this->auth = new Auth();
        $this->auth->init();
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function handleRequest()
    {
        $handler = Router::match($this->request);

        $controllerClass = $handler['controller'];
        $action = $handler['action'];

        return (new $controllerClass($this->request))->$action();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}