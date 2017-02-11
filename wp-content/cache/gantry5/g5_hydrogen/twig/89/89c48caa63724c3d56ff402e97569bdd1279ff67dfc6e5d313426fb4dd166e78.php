<?php

/* partials/page.html.twig */
class __TwigTemplate_3e93cb0251564a28c85e41776f565f695a603d1c19bdf2a4e8af6568ffc2d312 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/page.html.twig", "partials/page.html.twig", 1);
        $this->blocks = array(
            'page_head' => array($this, 'block_page_head'),
            'page_footer' => array($this, 'block_page_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/page.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_page_head($context, array $blocks = array())
    {
        // line 4
        if ((isset($context["page_head"]) ? $context["page_head"] : null)) {
            // line 5
            echo "        ";
            echo (isset($context["page_head"]) ? $context["page_head"] : null);
            echo "
    ";
        } else {
            // line 7
            echo "        ";
            $this->displayParentBlock("page_head", $context, $blocks);
            echo "
    ";
        }
    }

    // line 11
    public function block_page_footer($context, array $blocks = array())
    {
        // line 12
        echo "    ";
        $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "platform", array()), "finalize", array(), "method");
        // line 13
        echo "    ";
        echo (isset($context["wp_footer"]) ? $context["wp_footer"] : null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "partials/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 13,  51 => 12,  48 => 11,  40 => 7,  34 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }
}
/* {% extends "@nucleus/page.html.twig" %}*/
/* */
/* {% block page_head -%}*/
/*     {% if page_head %}*/
/*         {{ page_head|raw }}*/
/*     {% else %}*/
/*         {{ parent() }}*/
/*     {% endif %}*/
/* {%- endblock %}*/
/* */
/* {% block page_footer %}*/
/*     {% do gantry.platform.finalize() %}*/
/*     {{ wp_footer|raw }}*/
/* {% endblock %}*/
/* */
