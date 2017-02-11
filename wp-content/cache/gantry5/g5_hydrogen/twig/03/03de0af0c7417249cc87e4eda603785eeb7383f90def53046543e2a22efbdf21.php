<?php

/* @particles/uikit.html.twig */
class __TwigTemplate_02c4daaa411db401280ae69cbe310c32c204244cd59c47b90e6edb6ce8861a9e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/uikit.html.twig", 1);
        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
            'javascript' => array($this, 'block_javascript'),
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
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "enabled", array())) {
            // line 5
            echo "        ";
            $this->displayParentBlock("stylesheets", $context, $blocks);
            echo "
        <link rel=\"stylesheet\" href=\"";
            // line 6
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-theme://uikit/css/uikit.min.css"), "html", null, true);
            echo "\" type=\"text/css\"/>
    ";
        }
    }

    // line 10
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 11
        echo "    ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "enabled", array())) {
            // line 12
            echo "        ";
            if (((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "jslocation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "jslocation", array()), "footer")) : ("footer")) == "footer")) {
                // line 13
                echo "            ";
                if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "getName", array(), "method") == "joomla")) {
                    // line 14
                    echo "                ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["joomla"]) ? $context["joomla"] : null), "html", array(0 => "jquery.framework"), "method"), "html", null, true);
                    echo "
            ";
                }
                // line 16
                echo "
            ";
                // line 17
                if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "getName", array(), "method") == "wordpress")) {
                    // line 18
                    echo "                ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["wordpress"]) ? $context["wordpress"] : null), "call", array(0 => "wp_enqueue_script", 1 => "jquery"), "method"), "html", null, true);
                    echo "
            ";
                }
                // line 20
                echo "            ";
                $this->displayParentBlock("javascript_footer", $context, $blocks);
                echo "
            <script src=\"";
                // line 21
                echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-theme://uikit/js/uikit.min.js"), "html", null, true);
                echo "\" type=\"text/javascript\"></script>
        ";
            }
            // line 23
            echo "    ";
        }
    }

    // line 26
    public function block_javascript($context, array $blocks = array())
    {
        // line 27
        echo "    ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "enabled", array())) {
            // line 28
            echo "        ";
            if (((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "jslocation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "jslocation", array()), "footer")) : ("footer")) == "head")) {
                // line 29
                echo "            ";
                if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "getName", array(), "method") == "joomla")) {
                    // line 30
                    echo "                ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["joomla"]) ? $context["joomla"] : null), "html", array(0 => "jquery.framework"), "method"), "html", null, true);
                    echo "
            ";
                }
                // line 32
                echo "
            ";
                // line 33
                if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "getName", array(), "method") == "wordpress")) {
                    // line 34
                    echo "                ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["wordpress"]) ? $context["wordpress"] : null), "call", array(0 => "wp_enqueue_script", 1 => "jquery"), "method"), "html", null, true);
                    echo "
            ";
                }
                // line 36
                echo "            ";
                $this->displayParentBlock("javascript", $context, $blocks);
                echo "
            <script src=\"";
                // line 37
                echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-theme://uikit/js/uikit.min.js"), "html", null, true);
                echo "\" type=\"text/javascript\"></script>
        ";
            }
            // line 39
            echo "    ";
        }
    }

    public function getTemplateName()
    {
        return "@particles/uikit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 39,  126 => 37,  121 => 36,  115 => 34,  113 => 33,  110 => 32,  104 => 30,  101 => 29,  98 => 28,  95 => 27,  92 => 26,  87 => 23,  82 => 21,  77 => 20,  71 => 18,  69 => 17,  66 => 16,  60 => 14,  57 => 13,  54 => 12,  51 => 11,  48 => 10,  41 => 6,  36 => 5,  33 => 4,  30 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block stylesheets %}*/
/*     {% if particle.enabled %}*/
/*         {{ parent() }}*/
/*         <link rel="stylesheet" href="{{ url('gantry-theme://uikit/css/uikit.min.css') }}" type="text/css"/>*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
/* {% block javascript_footer %}*/
/*     {% if particle.enabled %}*/
/*         {% if particle.jslocation|default('footer') == 'footer' %}*/
/*             {% if gantry.platform.getName() == 'joomla' %}*/
/*                 {{ joomla.html('jquery.framework') }}*/
/*             {% endif %}*/
/* */
/*             {% if gantry.platform.getName() == 'wordpress' %}*/
/*                 {{ wordpress.call('wp_enqueue_script', 'jquery') }}*/
/*             {% endif %}*/
/*             {{ parent() }}*/
/*             <script src="{{ url('gantry-theme://uikit/js/uikit.min.js') }}" type="text/javascript"></script>*/
/*         {% endif %}*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
/* {% block javascript %}*/
/*     {% if particle.enabled %}*/
/*         {% if particle.jslocation|default('footer') == 'head' %}*/
/*             {% if gantry.platform.getName() == 'joomla' %}*/
/*                 {{ joomla.html('jquery.framework') }}*/
/*             {% endif %}*/
/* */
/*             {% if gantry.platform.getName() == 'wordpress' %}*/
/*                 {{ wordpress.call('wp_enqueue_script', 'jquery') }}*/
/*             {% endif %}*/
/*             {{ parent() }}*/
/*             <script src="{{ url('gantry-theme://uikit/js/uikit.min.js') }}" type="text/javascript"></script>*/
/*         {% endif %}*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
/* */
/* */
