<?php

/* @nucleus/layout/section.html.twig */
class __TwigTemplate_f6095413fb135db679829123fbf224accacbd9da04f174a13e5729f1ddbf02d1 extends Twig_Template
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
        $context["tag_type"] = (($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "subtype", array()), "section")) : ("section"));
        // line 2
        $context["attr_id"] = (($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "id", array())) ? ($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "id", array())) : (("g-" . $this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "id", array()))));
        // line 3
        $context["attr_class"] = $this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "class", array());
        // line 4
        $context["attr_extra"] = "";
        // line 5
        $context["boxed"] = $this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "boxed", array());
        // line 6
        if ( !(null === (isset($context["boxed"]) ? $context["boxed"] : null))) {
            // line 7
            echo "    ";
            $context["boxed"] = (((trim((isset($context["boxed"]) ? $context["boxed"] : null)) == "")) ? ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "body", array()), "layout", array()), "sections", array())) : ((isset($context["boxed"]) ? $context["boxed"] : null)));
        }
        // line 9
        echo "
";
        // line 10
        if ($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "extra", array())) {
            // line 11
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "extra", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["attributes"]) {
                // line 12
                echo "        ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["attributes"]);
                foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                    // line 13
                    echo "        ";
                    $context["attr_extra"] = ((((((isset($context["attr_extra"]) ? $context["attr_extra"] : null) . " ") . twig_escape_filter($this->env, $context["key"])) . "=\"") . twig_escape_filter($this->env, $context["value"], "html_attr")) . "\"");
                    // line 14
                    echo "        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 15
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attributes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 17
        echo "
";
        // line 18
        ob_start();
        // line 19
        echo "    ";
        if ($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "children", array())) {
            // line 20
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["segments"]) ? $context["segments"] : null));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
                // line 21
                echo "            ";
                $this->loadTemplate((("@nucleus/layout/" . $this->getAttribute($context["segment"], "type", array())) . ".html.twig"), "@nucleus/layout/section.html.twig", 21)->display(array_merge($context, array("segments" => $this->getAttribute($context["segment"], "children", array()))));
                // line 22
                echo "        ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            echo "    ";
        }
        $context["html"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 25
        echo "
";
        // line 26
        if (($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "sticky", array()) || trim((isset($context["html"]) ? $context["html"] : null)))) {
            // line 27
            echo "    ";
            if (( !(null === (isset($context["boxed"]) ? $context["boxed"] : null)) && (((isset($context["boxed"]) ? $context["boxed"] : null) == 0) || ((isset($context["boxed"]) ? $context["boxed"] : null) == 2)))) {
                // line 28
                echo "        ";
                ob_start();
                // line 29
                echo "        <div class=\"g-container\">";
                echo (isset($context["html"]) ? $context["html"] : null);
                echo "</div>
        ";
                $context["html"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 31
                echo "    ";
            }
            // line 32
            echo "
    ";
            // line 33
            ob_start();
            // line 34
            echo "    ";
            if (((isset($context["boxed"]) ? $context["boxed"] : null) == 2)) {
                $context["attr_class"] = ((isset($context["attr_class"]) ? $context["attr_class"] : null) . " g-flushed");
            }
            // line 35
            echo "    ";
            $context["attr_class"] = (((isset($context["attr_class"]) ? $context["attr_class"] : null)) ? (((" class=\"" . trim((isset($context["attr_class"]) ? $context["attr_class"] : null))) . "\"")) : (""));
            // line 36
            echo "    <";
            echo (isset($context["tag_type"]) ? $context["tag_type"] : null);
            echo " id=\"";
            echo (isset($context["attr_id"]) ? $context["attr_id"] : null);
            echo "\"";
            echo (isset($context["attr_class"]) ? $context["attr_class"] : null);
            echo (isset($context["attr_extra"]) ? $context["attr_extra"] : null);
            echo ">
        ";
            // line 37
            echo (isset($context["html"]) ? $context["html"] : null);
            echo "
    </";
            // line 38
            echo (isset($context["tag_type"]) ? $context["tag_type"] : null);
            echo ">
    ";
            $context["html"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 40
            echo "
    ";
            // line 41
            if (((isset($context["boxed"]) ? $context["boxed"] : null) == 1)) {
                // line 42
                echo "    <div class=\"g-container\">";
                echo (isset($context["html"]) ? $context["html"] : null);
                echo "</div>
    ";
            } else {
                // line 44
                echo "    ";
                echo (isset($context["html"]) ? $context["html"] : null);
                echo "
    ";
            }
        }
    }

    public function getTemplateName()
    {
        return "@nucleus/layout/section.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 44,  170 => 42,  168 => 41,  165 => 40,  160 => 38,  156 => 37,  146 => 36,  143 => 35,  138 => 34,  136 => 33,  133 => 32,  130 => 31,  124 => 29,  121 => 28,  118 => 27,  116 => 26,  113 => 25,  109 => 23,  95 => 22,  92 => 21,  74 => 20,  71 => 19,  69 => 18,  66 => 17,  59 => 15,  53 => 14,  50 => 13,  45 => 12,  40 => 11,  38 => 10,  35 => 9,  31 => 7,  29 => 6,  27 => 5,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
/* {% set tag_type = segment.subtype|default('section') %}*/
/* {% set attr_id = segment.attributes.id ?: 'g-' ~ segment.id %}*/
/* {% set attr_class = segment.attributes.class %}*/
/* {% set attr_extra = '' %}*/
/* {% set boxed = segment.attributes.boxed %}*/
/* {% if boxed is not null %}*/
/*     {% set boxed = boxed|trim == '' ? gantry.config.page.body.layout.sections : boxed %}*/
/* {% endif %}*/
/* */
/* {% if segment.attributes.extra %}*/
/*     {% for attributes in segment.attributes.extra %}*/
/*         {% for key, value in attributes %}*/
/*         {% set attr_extra = attr_extra ~ ' ' ~ key|e ~ '="' ~ value|e('html_attr') ~ '"' %}*/
/*         {% endfor %}*/
/*     {% endfor %}*/
/* {% endif %}*/
/* */
/* {% set html %}*/
/*     {% if segment.children %}*/
/*         {% for segment in segments %}*/
/*             {% include '@nucleus/layout/' ~ segment.type ~ '.html.twig' with { 'segments':segment.children } %}*/
/*         {% endfor %}*/
/*     {% endif %}*/
/* {% endset %}*/
/* */
/* {% if segment.attributes.sticky or html|trim %}*/
/*     {% if boxed is not null and (boxed == 0 or boxed == 2) %}*/
/*         {% set html %}*/
/*         <div class="g-container">{{ html|raw }}</div>*/
/*         {% endset %}*/
/*     {% endif %}*/
/* */
/*     {% set html %}*/
/*     {% if boxed == 2 %}{% set attr_class = attr_class ~ ' g-flushed' %}{% endif %}*/
/*     {% set attr_class = attr_class ? ' class="' ~ attr_class|trim ~ '"' %}*/
/*     <{{ tag_type }} id="{{ attr_id }}"{{ attr_class|raw }}{{ attr_extra|raw }}>*/
/*         {{ html|raw }}*/
/*     </{{ tag_type }}>*/
/*     {% endset %}*/
/* */
/*     {% if boxed == 1 %}*/
/*     <div class="g-container">{{ html|raw }}</div>*/
/*     {% else %}*/
/*     {{ html|raw }}*/
/*     {% endif %}*/
/* {% endif %}*/
/* */
