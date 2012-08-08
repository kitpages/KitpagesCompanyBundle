<?php
namespace Kitpages\CompanyBundle\Twig\Extension;

use Symfony\Component\Locale\Locale;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActionExtension extends \Twig_Extension
{

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function kitParseRouteAction($route, $user)
    {
        foreach($route['parameterList'] as $parameter => $parameterValue) {
            $findMethod = preg_match(
                '/\$\$([a-zA-Z0-9_\.]+)\$\$/',
                $parameterValue,
                $matches
            );
            if ($findMethod) {
                $field = $matches[1];
                $route['parameterList'][$parameter] = $user[$field];
            }
        }
        $url = $this->router->generate(
            $route['name'],
            $route['parameterList']
        );

        return $url;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return array(
            'kit_parseRouteAction' => new \Twig_Function_Method($this, 'kitParseRouteAction'),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'kit_company_action';
    }
}
