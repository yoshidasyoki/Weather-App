<?php

class View
{
    public function __construct(private string $baseDirPath)
    {
    }

    public function render(string $template, array $variables = []): string
    {
        extract($variables);

        ob_start();
        $contentPath = $this->baseDirPath . '/' . $template . '.php';
        include $contentPath;
        $content = ob_get_clean();

        return $content;
    }
}
