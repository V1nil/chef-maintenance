<?php

/* @nucleus/content/position.html.twig */
class __TwigTemplate_ed5255bc585f171ac542aa38c03ad6f6ad3b0cc525bf967d9a8001a1b028ef5e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        try {            // line 2
            echo "    ";
            $context["enabled"] = $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("particles." . $this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "type", array())) . ".enabled"), 1 => 1), "method");
            // line 3
            echo "    ";
            $context["particle"] = $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "getJoined", array(0 => ("particles." . $this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "type", array())), 1 => $this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array())), "method");
            // line 4
            echo "
    ";
            // line 5
            ob_start();
            // line 6
            echo "        ";
            if (((isset($context["enabled"]) ? $context["enabled"] : null) && ((null === $this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "enabled", array())) || $this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "enabled", array())))) {
                // line 7
                echo "            ";
                $this->loadTemplate(array(0 => (("particles/" . (($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array()), "position")) : ("position"))) . ".html.twig"), 1 => (("@particles/" . (($this->getAttribute(                // line 8
(isset($context["segment"]) ? $context["segment"] : null), "subtype", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array()), "position")) : ("position"))) . ".html.twig")), "@nucleus/content/position.html.twig", 7)->display($context);
                // line 9
                echo "        ";
            }
            // line 10
            echo "    ";
            $context["html"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 11
            echo "
    ";
            // line 12
            if (trim((isset($context["html"]) ? $context["html"] : null))) {
                // line 13
                echo "        <div class=\"g-content";
                echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "classes", array())) ? ((" " . twig_escape_filter($this->env, twig_join_filter($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "classes", array()), " ")))) : ("")), "html", null, true);
                echo "\">
            ";
                // line 14
                echo (isset($context["html"]) ? $context["html"] : null);
                echo "
        </div>
    ";
            }
            // line 17
            echo "
";
        } catch (\Exception $e) {
            if ($context['gantry']->debug()) throw $e;
            $context['e'] = $e;
            // line 19
            echo "    <div class=\"alert alert-error\"><strong>Error</strong> while rendering ";
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array()), "position")) : ("position")), "html", null, true);
            echo ".</div>
";
        }
    }

    public function getTemplateName()
    {
        return "@nucleus/content/position.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 19,  60 => 17,  54 => 14,  49 => 13,  47 => 12,  44 => 11,  41 => 10,  38 => 9,  36 => 8,  34 => 7,  31 => 6,  29 => 5,  26 => 4,  23 => 3,  20 => 2,  19 => 1,);
    }
}
/* {% try %}*/
/*     {% set enabled = gantry.config.get('particles.' ~ segment.type ~ '.enabled', 1) %}*/
/*     {% set particle = gantry.config.getJoined('particles.' ~ segment.type, segment.attributes) %}*/
/* */
/*     {% set html %}*/
/*         {% if enabled and (segment.attributes.enabled is null or segment.attributes.enabled) %}*/
/*             {% include ['particles/' ~ segment.subtype|default('position') ~ '.html.twig',*/
/*             '@particles/' ~ segment.subtype|default('position') ~ '.html.twig'] %}*/
/*         {% endif %}*/
/*     {% endset %}*/
/* */
/*     {% if html|trim %}*/
/*         <div class="g-content{{ segment.classes ? ' ' ~ segment.classes|join(' ')|e }}">*/
/*             {{ html|raw }}*/
/*         </div>*/
/*     {% endif %}*/
/* */
/* {% catch %}*/
/*     <div class="alert alert-error"><strong>Error</strong> while rendering {{ segment.subtype|default('position') }}.</div>*/
/* {% endtry %}*/
/* */
