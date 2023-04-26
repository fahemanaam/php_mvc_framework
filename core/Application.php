<?php
namespace  app\core;
use app\models\User;

class Application
{
    public static string $DIR_ROOT;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $user;
    public Controller $controller;
    public View $view;
    public static Application $app;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$DIR_ROOT= $rootPath;
        self::$app= $this;
        $this->controller = new Controller();
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue){
            $primaryKey = (new User())->primaryKey();
            $this->user = (new User())->findOne([$primaryKey => $primaryValue]);
        }
        else{
            $this->user = null;
        }

        $this->router = new Router($this->request, $this->response, $this->view);
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        }
        catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error',['exception'=> $e]);
        }
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }


}