<?php

/* @particles/logo.html.twig */
class __TwigTemplate_89acb54e81727006e421cb7de3e6fe3e2307720b4c6e767208402159d21ea105 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/logo.html.twig", 1);
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
        $context["url"] = _twig_default_filter($this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "url", array())), $this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "siteUrl", array(), "method"));
        // line 5
        echo "    ";
        if (((isset($context["url"]) ? $context["url"] : null) == $this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "siteUrl", array(), "method"))) {
            $context["rel"] = "rel=\"home\"";
        }
        // line 6
        echo "    ";
        $context["class"] = (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "class", array())) ? ((("class=\"" . $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "class", array())) . "\"")) : (""));
        // line 7
        echo "
<a href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo "\" title=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "text", array()), "html", null, true);
        echo "\" ";
        echo ((array_key_exists("rel", $context)) ? (_twig_default_filter((isset($context["rel"]) ? $context["rel"] : null), "")) : (""));
        echo " ";
        echo ((array_key_exists("class", $context)) ? (_twig_default_filter((isset($context["class"]) ? $context["class"] : null), "")) : (""));
        echo ">
    ";
        // line 9
        $context["image"] = $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "image", array()));
        // line 10
        echo "    ";
        if ((isset($context["image"]) ? $context["image"] : null)) {
            // line 11
            echo "    <img src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "image", array())), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "text", array()), "html", null, true);
            echo "\" />
    ";
        } else {
            // line 13
            echo "    ";
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "text", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "text", array()), "Logo")) : ("Logo")), "html", null, true);
            echo "
    ";
        }
        // line 15
        echo "</a>
";
    }

    public function getTemplateName()
    {
        return "@particles/logo.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 15,  68 => 13,  60 => 11,  57 => 10,  55 => 9,  45 => 8,  42 => 7,  39 => 6,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block particle %}*/
/*     {% set url = url(particle.url)|default(gantry.siteUrl()) %}*/
/*     {% if (url == gantry.siteUrl()) %}{% set rel='rel="home"' %}{% endif %}*/
/*     {% set class=(particle.class ? 'class="'~ particle.class ~'"') %}*/
/* */
/* <a href="{{ url }}" title="{{ particle.text }}" {{ rel|default('')|raw }} {{ class|default('')|raw }}>*/
/*     {% set image = url(particle.image) %}*/
/*     {% if image %}*/
/*     <img src="{{ url(particle.image) }}" alt="{{ particle.text }}" />*/
/*     {% else %}*/
/*     {{ particle.text|default('Logo') }}*/
/*     {% endif %}*/
/* </a>*/
/* {% endblock %}*/
/* */
