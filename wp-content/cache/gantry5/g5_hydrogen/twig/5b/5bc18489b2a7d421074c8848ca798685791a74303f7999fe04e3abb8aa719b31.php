<?php

/* @particles/custom.html.twig */
class __TwigTemplate_34946c587fc04fa6730e48b12cb88e474ccf1d28154dfd0345e56d2adc75cb15 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/custom.html.twig", 1);
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
        $context["html"] = (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "twig", array())) ? ($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "compile", array(0 => $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "html", array())), "method")) : ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "html", array())));
        // line 5
        echo "    ";
        echo $this->env->getExtension('GantryTwig')->htmlFilter((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "filter", array())) ? ($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "filter", array(0 => (isset($context["html"]) ? $context["html"] : null)), "method")) : ((isset($context["html"]) ? $context["html"] : null))));
        echo "
";
    }

    public function getTemplateName()
    {
        return "@particles/custom.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block particle %}*/
/*     {% set html = particle.twig ? gantry.theme.compile(particle.html) : particle.html %}*/
/*     {{ (particle.filter ? gantry.platform.filter(html) : html)|html|raw }}*/
/* {% endblock %}*/
/* */
