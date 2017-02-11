<?php

/* @nucleus/page.html.twig */
class __TwigTemplate_dec034d2f72b34ac23882b7ee4a309285b301d5b2edb4487d5b050b7325f9518 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'page_offcanvas' => array($this, 'block_page_offcanvas'),
            'page_layout' => array($this, 'block_page_layout'),
            'page_top' => array($this, 'block_page_top'),
            'page_bottom' => array($this, 'block_page_bottom'),
            'page_head' => array($this, 'block_page_head'),
            'page_footer' => array($this, 'block_page_footer'),
            'page' => array($this, 'block_page'),
            'page_body' => array($this, 'block_page_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "setLayout", array(), "method");
        // line 2
        $context["segments"] = $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "segments", array());
        // line 4
        ob_start();
        // line 5
        echo "    ";
        if ($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "hasContent", array(), "method")) {
            // line 6
            echo "        ";
            $this->displayBlock('content', $context, $blocks);
            // line 8
            echo "    ";
        }
        $context["content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 11
        $context["offcanvas"] = null;
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["segments"]) ? $context["segments"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            if (($this->getAttribute($context["segment"], "type", array()) == "offcanvas")) {
                // line 13
                $context["offcanvas"] = $context["segment"];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        ob_start();
        // line 17
        echo "    ";
        $this->displayBlock('page_offcanvas', $context, $blocks);
        $context["page_offcanvas"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 24
        $context["page_offcanvas"] = ((trim((isset($context["page_offcanvas"]) ? $context["page_offcanvas"] : null))) ? (trim((isset($context["page_offcanvas"]) ? $context["page_offcanvas"] : null))) : (""));
        // line 25
        $context["offcanvas_position"] = (((isset($context["page_offcanvas"]) ? $context["page_offcanvas"] : null)) ? ((($this->getAttribute($this->getAttribute((isset($context["offcanvas"]) ? $context["offcanvas"] : null), "attributes", array(), "any", false, true), "position", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute((isset($context["offcanvas"]) ? $context["offcanvas"] : null), "attributes", array(), "any", false, true), "position", array()), "g-offcanvas-left")) : ("g-offcanvas-left"))) : (""));
        // line 27
        ob_start();
        // line 28
        echo "    ";
        $this->displayBlock('page_layout', $context, $blocks);
        $context["page_layout"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 35
        ob_start();
        // line 36
        echo "    ";
        $this->displayBlock('page_top', $context, $blocks);
        $context["page_top"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 40
        ob_start();
        // line 41
        echo "    ";
        $this->displayBlock('page_bottom', $context, $blocks);
        $context["page_bottom"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 47
        ob_start();
        // line 48
        echo "    ";
        $this->displayBlock('page_head', $context, $blocks);
        $context["page_head"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 53
        ob_start();
        // line 54
        echo "    ";
        $this->displayBlock('page_footer', $context, $blocks);
        $context["page_footer"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 59
        $this->displayBlock('page', $context, $blocks);
        // line 83
        $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "finalize", array(), "method");
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "        ";
    }

    // line 17
    public function block_page_offcanvas($context, array $blocks = array())
    {
        // line 18
        echo "        ";
        if ((isset($context["offcanvas"]) ? $context["offcanvas"] : null)) {
            // line 19
            echo "            ";
            $this->loadTemplate((("@nucleus/layout/" . $this->getAttribute((isset($context["offcanvas"]) ? $context["offcanvas"] : null), "type", array())) . ".html.twig"), "@nucleus/page.html.twig", 19)->display(array_merge($context, array("segment" => (isset($context["offcanvas"]) ? $context["offcanvas"] : null))));
        }
        // line 21
        echo "    ";
    }

    // line 28
    public function block_page_layout($context, array $blocks = array())
    {
        // line 29
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["segments"]) ? $context["segments"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        foreach ($context['_seq'] as $context["_key"] => $context["segment"]) {
            if (($this->getAttribute($context["segment"], "type", array()) != "offcanvas")) {
                // line 30
                echo "        ";
                $this->loadTemplate((("@nucleus/layout/" . $this->getAttribute($context["segment"], "type", array())) . ".html.twig"), "@nucleus/page.html.twig", 30)->display(array_merge($context, array("segments" => $this->getAttribute($context["segment"], "children", array()))));
                // line 31
                echo "    ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['segment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "    ";
    }

    // line 36
    public function block_page_top($context, array $blocks = array())
    {
        // line 37
        echo "    ";
    }

    // line 41
    public function block_page_bottom($context, array $blocks = array())
    {
        // line 42
        echo "    ";
    }

    // line 48
    public function block_page_head($context, array $blocks = array())
    {
        // line 49
        $this->loadTemplate("partials/page_head.html.twig", "@nucleus/page.html.twig", 49)->display($context);
    }

    // line 54
    public function block_page_footer($context, array $blocks = array())
    {
        // line 55
        echo "        ";
        echo twig_join_filter($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "scripts", array(0 => "footer"), "method"), "
    ");
        echo "
    ";
    }

    // line 59
    public function block_page($context, array $blocks = array())
    {
        // line 60
        echo "<!DOCTYPE ";
        echo (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array(), "any", false, true), "page", array(), "any", false, true), "doctype", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array(), "any", false, true), "page", array(), "any", false, true), "doctype", array()), "html")) : ("html"));
        echo ">
<html";
        // line 61
        echo $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "page", array()), "htmlAttributes", array());
        echo ">
    ";
        // line 62
        echo (isset($context["page_head"]) ? $context["page_head"] : null);
        echo "
    ";
        // line 63
        $this->displayBlock('page_body', $context, $blocks);
        // line 80
        echo "
</html>
";
    }

    // line 63
    public function block_page_body($context, array $blocks = array())
    {
        // line 64
        echo "<body";
        echo $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "page", array()), "bodyAttributes", array(0 => array("class" => array(0 => (isset($context["offcanvas_position"]) ? $context["offcanvas_position"] : null), 1 => $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "page", array()), "preset", array()), 2 => ("g-style-" . $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "preset", array()))))), "method");
        echo ">
        ";
        // line 65
        echo $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "body", array()), "body_top", array());
        echo "
        ";
        // line 66
        echo (isset($context["page_offcanvas"]) ? $context["page_offcanvas"] : null);
        echo "
        <div id=\"g-page-surround\">
            ";
        // line 68
        if (trim((isset($context["page_offcanvas"]) ? $context["page_offcanvas"] : null))) {
            // line 69
            echo "            <div class=\"g-offcanvas-hide g-offcanvas-toggle\" data-offcanvas-toggle><i class=\"fa fa-fw fa-bars\"></i></div>
            ";
        }
        // line 71
        echo "            ";
        echo (isset($context["page_top"]) ? $context["page_top"] : null);
        echo "
            ";
        // line 72
        echo (isset($context["page_layout"]) ? $context["page_layout"] : null);
        echo "
            ";
        // line 73
        echo (isset($context["page_bottom"]) ? $context["page_bottom"] : null);
        echo "
        </div>
        <script type=\"text/javascript\" src=\"";
        // line 75
        echo $this->env->getExtension('GantryTwig')->urlFunc("gantry-assets://js/main.js");
        echo "\"></script>
        ";
        // line 76
        echo (isset($context["page_footer"]) ? $context["page_footer"] : null);
        echo "
        ";
        // line 77
        echo $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "body", array()), "body_bottom", array());
        echo "
    </body>";
    }

    public function getTemplateName()
    {
        return "@nucleus/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  258 => 77,  254 => 76,  250 => 75,  245 => 73,  241 => 72,  236 => 71,  232 => 69,  230 => 68,  225 => 66,  221 => 65,  216 => 64,  213 => 63,  207 => 80,  205 => 63,  201 => 62,  197 => 61,  192 => 60,  189 => 59,  181 => 55,  178 => 54,  174 => 49,  171 => 48,  167 => 42,  164 => 41,  160 => 37,  157 => 36,  153 => 32,  143 => 31,  140 => 30,  128 => 29,  125 => 28,  121 => 21,  117 => 19,  114 => 18,  111 => 17,  107 => 7,  104 => 6,  100 => 83,  98 => 59,  94 => 54,  92 => 53,  88 => 48,  86 => 47,  82 => 41,  80 => 40,  76 => 36,  74 => 35,  70 => 28,  68 => 27,  66 => 25,  64 => 24,  60 => 17,  58 => 16,  51 => 13,  46 => 12,  44 => 11,  40 => 8,  37 => 6,  34 => 5,  32 => 4,  30 => 2,  28 => 1,);
    }
}
/* {%- do gantry.theme.setLayout() -%}*/
/* {%- set segments = gantry.theme.segments -%}*/
/* */
/* {%- set content %}*/
/*     {% if gantry.theme.hasContent() %}*/
/*         {% block content %}*/
/*         {% endblock %}*/
/*     {% endif %}*/
/* {% endset -%}*/
/* */
/* {%- set offcanvas = null -%}*/
/* {%- for segment in segments if segment.type == 'offcanvas' %}*/
/*     {%- set offcanvas = segment -%}*/
/* {% endfor -%}*/
/* */
/* {%- set page_offcanvas %}*/
/*     {% block page_offcanvas %}*/
/*         {% if offcanvas %}*/
/*             {% include '@nucleus/layout/' ~ offcanvas.type ~ '.html.twig' with { 'segment': offcanvas } -%}*/
/*         {% endif %}*/
/*     {% endblock %}*/
/* {% endset -%}*/
/* */
/* {%- set page_offcanvas = page_offcanvas|trim ?: '' %}*/
/* {%- set offcanvas_position = page_offcanvas ? offcanvas.attributes.position|default('g-offcanvas-left') : '' -%}*/
/* */
/* {%- set page_layout %}*/
/*     {% block page_layout %}*/
/*     {% for segment in segments if segment.type != 'offcanvas' %}*/
/*         {% include '@nucleus/layout/' ~ segment.type ~ '.html.twig' with { 'segments': segment.children } %}*/
/*     {% endfor %}*/
/*     {% endblock %}*/
/* {% endset -%}*/
/* */
/* {%- set page_top %}*/
/*     {% block page_top %}*/
/*     {% endblock %}*/
/* {% endset -%}*/
/* */
/* {%- set page_bottom %}*/
/*     {% block page_bottom %}*/
/*     {% endblock %}*/
/* {% endset -%}*/
/* */
/* {# Head and footer needs to come last because of any of the above blocks may have CSS or JavaScript in them #}*/
/* */
/* {%- set page_head %}*/
/*     {% block page_head -%}*/
/*         {% include 'partials/page_head.html.twig' %}*/
/*     {%- endblock %}*/
/* {% endset -%}*/
/* */
/* {%- set page_footer %}*/
/*     {% block page_footer %}*/
/*         {{ gantry.scripts('footer')|join("\n    ")|raw }}*/
/*     {% endblock %}*/
/* {% endset -%}*/
/* */
/* {%- block page -%}*/
/* <!DOCTYPE {{ gantry.config.page.doctype|default('html')|raw }}>*/
/* <html{{ gantry.page.htmlAttributes|raw }}>*/
/*     {{ page_head|raw }}*/
/*     {% block page_body -%}*/
/*     <body{{ gantry.page.bodyAttributes({'class': [offcanvas_position, gantry.page.preset, 'g-style-' ~ gantry.theme.preset]})|raw }}>*/
/*         {{ gantry.config.page.body.body_top|raw }}*/
/*         {{ page_offcanvas|raw }}*/
/*         <div id="g-page-surround">*/
/*             {% if page_offcanvas|trim %}*/
/*             <div class="g-offcanvas-hide g-offcanvas-toggle" data-offcanvas-toggle><i class="fa fa-fw fa-bars"></i></div>*/
/*             {% endif %}*/
/*             {{ page_top|raw }}*/
/*             {{ page_layout|raw }}*/
/*             {{ page_bottom|raw }}*/
/*         </div>*/
/*         <script type="text/javascript" src="{{ url('gantry-assets://js/main.js') }}"></script>*/
/*         {{ page_footer|raw }}*/
/*         {{ gantry.config.page.body.body_bottom|raw }}*/
/*     </body>*/
/*     {%- endblock %}*/
/* */
/* </html>*/
/* {% endblock -%}*/
/* {% do gantry.platform.finalize() -%}*/
/* */
