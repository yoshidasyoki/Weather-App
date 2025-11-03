<?php

class Application
{
    private Router $router;
    private EnvImporter $envImporter;
    private DatabaseManager $databaseManager;
    private Request $request;
    private View $view;
    private Response $response;

    public function __construct()
    {
        $this->router = new Router($this->registerRouting());
        $this->envImporter = new EnvImporter();
        $this->databaseManager = new DatabaseManager();
        $this->request = new Request();
        $this->view = new View(__DIR__ . '/views');
        $this->response = new Response();
    }

    public function run(): void
    {
        try {
            $this->connectDatabase();

            $accessPath = $this->request->getAccessPath();
            $routingPath = $this->router->routing($accessPath);
            $controllerName = ucfirst($routingPath['controller']) . 'Controller';
            $actionName = $routingPath['action'];

            $httpResponseBody = $this->runAction($controllerName, $actionName);
            $this->response->send(200, $httpResponseBody);
        } catch (HttpNotFoundException) {
            $httpResponseBody['content'] = $this->view->render(
                'errorPage',
                [
                    'title' => 'Page Not Found',
                    'message' => 'お探しのページは見つかりませんでした。'
                ]
            );
            $this->response->send(404, $httpResponseBody);
        } catch (PDOException) {
            $httpResponseBody['content'] = $this->view->render(
                'errorPage',
                [
                    'title' => 'Internal Server Error',
                    'message' => 'データベース接続に失敗しました。時間をおいて再度アクセスしてください。'
                ]
            );
            $this->response->send(500, $httpResponseBody);
        } catch (EnvImportException) {
            $httpResponseBody['content'] = $this->view->render(
                'errorPage',
                [
                    'title' => 'Internal Server Error',
                    'message' => '環境変数の読み込みに失敗しました。時間をおいて再度アクセスしてください。'
                ]
            );
            $this->response->send(500);
        } catch (InvalidArgumentException) {
            $this->response->send(400);
        } catch (AttackDetectException) {
            $this->response->send(403);
        }
    }

    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getView(): View
    {
        return $this->view;
    }

    private function registerRouting(): array
    {
        return [
            '/' => ['controller' => 'graph', 'action' => 'index'],
            '/init' => ['controller' => 'graph', 'action' => 'init'],
            '/search' => ['controller' => 'graph', 'action' => 'search'],
        ];
    }

    private function runAction(string $controllerName, string $actionName): array
    {
        if (!class_exists($controllerName)) {
            throw new HttpNotFoundException();
        }

        $controller = new $controllerName($this);
        return $controller->run($actionName);
    }

    private function connectDatabase(): void
    {
        $env = $this->envImporter->run();
        $this->databaseManager->connectDatabase([
            'hostname' => $env['hostname'],
            'database' => $env['database'],
            'username' => $env['username'],
            'password' => $env['password'],
        ]);
    }
}
