<?php

/* @nucleus/layout/block.html.twig */
class __TwigTemplate_2e57f384203778375361921da4fbf04b9e332ce18c666c2767c1a3f84a29240e extends Twig_Template
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
        $context["attr_extra"] = "";
        // line 2
        if ($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "extra", array())) {
            // line 3
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "extra", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["attributes"]) {
                // line 4
                echo "        ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["attributes"]);
                foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                    // line 5
                    echo "            ";
                    $context["attr_extra"] = ((((((isset($context["attr_extra"]) ? $context["attr_extra"] : null) . " ") . twig_escape_filter($this->env, $context["key"])) . "=\"") . twig_escape_filter($this->env, $context["value"], "html_attr")) . "\"");
                    // line 6
                    echo "        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 7
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attributes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 9
        echo "
";
        // line 10
        ob_start();
        // line 11
        echo "    ";
        if ($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "children", array())) {
            // line 12
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
                // line 13
                echo "            ";
                if ($this->getAttribute($context["segment"], "content", array())) {
                    // line 14
                    echo "                ";
                    echo $this->getAttribute($context["segment"], "content", array());
                    echo "
            ";
                } else {
                    // line 16
                    echo "                ";
                    $this->loadTemplate(array(0 => (("@nucleus/content/" . $this->getAttribute($context["segment"], "type", array())) . ".html.twig"), 1 => (("@nucleus/layout/" . $this->getAttribute($context["segment"], "type", array())) . ".html.twig")), "@nucleus/layout/block.html.twig", 16)->display(array_merge($context, array("segments" => $this->getAttribute($context["segment"], "children", array()))));
                    // line 17
                    echo "            ";
                }
                // line 18
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
            // line 19
            echo "    ";
        }
        $context["html"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 21
        echo "
";
        // line 22
        if (trim((isset($context["html"]) ? $context["html"] : null))) {
            // line 23
            echo "    <div ";
            if ($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "id", array())) {
                echo "id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "id", array()));
                echo "\"";
            }
            // line 24
            echo "        ";
            echo (isset($context["attr_extra"]) ? $context["attr_extra"] : null);
            echo "
         class=\"g-block";
            // line 25
            echo (($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "variations", array())) ? ((" " . twig_escape_filter($this->env, twig_join_filter($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "variations", array()), " ")))) : (""));
            echo (($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "class", array())) ? ((" " . twig_escape_filter($this->env, twig_join_filter($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "class", array()), " ")))) : (""));
            echo " ";
            echo call_user_func_array($this->env->getFilter('toGrid')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["segment"]) ? $context["segment"] : null), "attributes", array()), "size", array())));
            echo "\">
        ";
            // line 26
            echo (isset($context["html"]) ? $context["html"] : null);
            echo "
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "@nucleus/layout/block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 26,  125 => 25,  120 => 24,  113 => 23,  111 => 22,  108 => 21,  104 => 19,  90 => 18,  87 => 17,  84 => 16,  78 => 14,  75 => 13,  57 => 12,  54 => 11,  52 => 10,  49 => 9,  42 => 7,  36 => 6,  33 => 5,  28 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
/* {% set attr_extra = '' %}*/
/* {% if segment.attributes.extra %}*/
/*     {% for attributes in segment.attributes.extra %}*/
/*         {% for key, value in attributes %}*/
/*             {% set attr_extra = attr_extra ~ ' ' ~ key|e ~ '="' ~ value|e('html_attr') ~ '"' %}*/
/*         {% endfor %}*/
/*     {% endfor %}*/
/* {% endif %}*/
/* */
/* {% set html %}*/
/*     {% if segment.children %}*/
/*         {% for segment in segments %}*/
/*             {% if segment.content %}*/
/*                 {{ segment.content|raw }}*/
/*             {% else %}*/
/*                 {% include ['@nucleus/content/' ~ segment.type ~ '.html.twig', '@nucleus/layout/' ~ segment.type ~ '.html.twig'] with { 'segments': segment.children } %}*/
/*             {% endif %}*/
/*         {% endfor %}*/
/*     {% endif %}*/
/* {% endset %}*/
/* */
/* {% if html|trim %}*/
/*     <div {% if segment.attributes.id %}id="{{ segment.attributes.id|e }}"{% endif %}*/
/*         {{ attr_extra|raw }}*/
/*          class="g-block{{ segment.attributes.variations ? ' ' ~ segment.attributes.variations|join(' ')|e }}{{ segment.attributes.class ? ' ' ~ segment.attributes.class|join(' ')|e }} {{ segment.attributes.size|toGrid }}">*/
/*         {{ html|raw }}*/
/*     </div>*/
/* {% endif %}*/
/* */
