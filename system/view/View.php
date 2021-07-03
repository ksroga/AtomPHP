<?php

namespace System\View;

/**
 * Class View
 * @package System\View
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.1 (03.07.2021)
 */
class View
{

    /**
     * @var string Templates path.
     */
    private $templatePath = 'application/views/';

    /**
     * @var string[] Allowed template extensions.
     */
    private $templateExtensions = [
        'php', 'html',
    ];

    /**
     * Show template.
     * @param string $template Template name.
     * @param array $passedVariables Variable to pass to view.
     * @throws \Exception View does not exist exception.
     */
    public function showTemplate(string $template, array $passedVariables = []): void
    {
        $fullTemplatePath = $this->getTemplatePathByName($template);

        if (count($passedVariables)) {
            extract($passedVariables);
        }

        require_once $fullTemplatePath;
    }

    /**
     * Search template path by available extensions.
     * @param string $template Template name.
     * @return string Template path.
     * @throws \Exception Template not found.
     */
    private function getTemplatePathByName(string $template)
    {
        $templatePath = null;
        foreach ($this->templateExtensions as $extension) {
            if (!$templatePath && file_exists($this->templatePath . $template . '.' . $extension)) {
                $templatePath = $this->templatePath . $template . '.' . $extension;
            }
        }

        if (!$templatePath) {
            throw new \Exception("View file $template not found in {$this->templatePath} directory!");
        }

        return $templatePath;
    }
}