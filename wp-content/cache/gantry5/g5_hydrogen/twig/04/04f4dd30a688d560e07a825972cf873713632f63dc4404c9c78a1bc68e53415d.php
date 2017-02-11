<?php

/* 404.html.twig */
class __TwigTemplate_704554b6d04f77687b2871c011d538966a1b0c5a244a04e21091d2af56403689 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/page.html.twig", "404.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "partials/page.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["twigTemplate"] = "404.html.twig";
        // line 3
        $context["scope"] = "404";
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <h1>";
        // line 7
        echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("404 Not Found", "g5_hydrogen"));
        echo "</h1>
    <p>";
        // line 8
        echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Sorry, we couldn't find what you're looking for.", "g5_hydrogen"));
        echo "</p>

";
    }

    public function getTemplateName()
    {
        return "404.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 8,  39 => 7,  36 => 6,  33 => 5,  29 => 1,  27 => 3,  25 => 2,  11 => 1,);
    }
}
/* {% extends "partials/page.html.twig" %}*/
/* {% set twigTemplate = '404.html.twig' %}*/
/* {% set scope = '404' %}*/
/* */
/* {% block content %}*/
/* */
/*     <h1>{{ __('404 Not Found', 'g5_hydrogen') }}</h1>*/
/*     <p>{{ __('Sorry, we couldn\'t find what you\'re looking for.', 'g5_hydrogen') }}</p>*/
/* */
/* {% endblock %}*/
/* */
