<?php

namespace System\View;

/**
 * Class View
 * @package System\View
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class View
{

    /**
     * @var string Templates path.
     */
    private $templatePath = 'application/views/';

    /**
     * Show template.
     * @param string $template Template name.
     * @param array $passedVariables Variable to pass to view.
     * @throws \Exception View does not exist exception.
     */
    public function showTemplate(string $template, array $passedVariables = []): void
    {
        $fullTemplatePath = $this->templatePath . $template . '.html';
        if (!file_exists($fullTemplatePath)) {
            throw new \Exception("View file $template not found in {$this->templatePath} directory!");
        }

        if (count($passedVariables)) {
            extract($passedVariables);
        }

        require_once $fullTemplatePath;
    }
}