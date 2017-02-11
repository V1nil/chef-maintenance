<?php

/* @particles/position.html.twig */
class __TwigTemplate_81d41eb6899784160b580791da943edb8b427121c4eff9b9d9b38548025930c7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/position.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        echo $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "displayWidgets", array(0 => $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "key", array()), 1 => array("chrome" => (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "chrome", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "chrome", array()), "gantry")) : ("gantry")), "prepare_layout" => (isset($context["prepare_layout"]) ? $context["prepare_layout"] : null))), "method");
        echo "
";
    }

    public function getTemplateName()
    {
        return "@particles/position.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block particle %}*/
/*     {{ gantry.platform.displayWidgets(particle.key, {'chrome': particle.chrome|default('gantry'), 'prepare_layout': prepare_layout})|raw }}*/
/* {% endblock %}*/
/* */
