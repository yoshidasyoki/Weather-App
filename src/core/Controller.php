<?php

class Controller
{
    protected string $actionName;
    protected DatabaseManager $databaseManager;
    protected Request $request;
    protected View $view;
    protected DatabaseModel $weatherModel;
    protected Service $service;

    public function __construct(Application $application)
    {
        $this->databaseManager = $application->getDatabaseManager();
        $this->request = $application->getRequest();
        $this->view = $application->getView();
        $this->weatherModel = $this->databaseManager->getModel('Weather');
        $this->service = new Service($this->weatherModel);
    }

    public function run(string $actionName): array
    {
        if (!method_exists($this, $actionName)) {
            throw new HttpNotFoundException();
        }

        $this->actionName = $actionName;
        return $this->$actionName();
    }

    protected function getRequestData(): array
    {
        return $this->request->getRequestData();
    }

    protected function render($template = null): string
    {
        $actionName = $this->actionName;
        $template = (!$template) ? $actionName : $template;
        return $this->view->render($template);
    }
}
