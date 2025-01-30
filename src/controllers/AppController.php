<?php

/**
 * Class AppController
 *
 * A base controller class for handling requests in the application.
 * Provides utility methods to determine the request type and render templates with variables.
 */
class AppController {
    /** @var string $request The HTTP request method (e.g., GET or POST). */
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Determines if the current request is a GET request.
     *
     * @return bool True if the request method is GET, otherwise false.
     */
    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    /**
     * Determines if the current request is a POST request.
     *
     * @return bool True if the request method is POST, otherwise false.
     */
    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    /**
     * Renders a specific template (view) and makes the passed variables
     * available within the template's scope.
     *
     * @param string|null $template The name of the template file (without the `.php` extension).
     * @param array $variables An associative array of variables to pass to the template.
     *
     * Functionality:
     * - Constructs the path to the template file located in the `public/views/` directory.
     * - If the file exists, extracts the variables and includes the template.
     * - Starts output buffering (`ob_start()`) to capture the included template's content.
     * - If the file doesn't exist in the default location, attempts an alternative path using to enable ERROR views.
     */
    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $template.'.php';

        if (file_exists($templatePath)) {
            // Extract variables to make them accessible in the template
            extract($variables);

            // Start output buffering to capture the template's output
            ob_start();
            include $templatePath;
        } else {
            // Include the template from the alternative path
            $templatePath = __DIR__ . '/../../public/views/'. $template.'.php';

            include $templatePath;
        }
    }
}