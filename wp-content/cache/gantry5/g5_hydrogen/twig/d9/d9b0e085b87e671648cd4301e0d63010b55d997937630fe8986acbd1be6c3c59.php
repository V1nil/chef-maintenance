<?php

/* partials/page_head.html.twig */
class __TwigTemplate_4eac4921e62c94610bf6b670dda6f45ba7ef12e64ada1f1e4ab5a7a4f43e9dca extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/page_head.html.twig", "partials/page_head.html.twig", 1);
        $this->blocks = array(
            'head_title' => array($this, 'block_head_title'),
            'head_application' => array($this, 'block_head_application'),
            'head_platform' => array($this, 'block_head_platform'),
            'head' => array($this, 'block_head'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/page_head.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head_title($context, array $blocks = array())
    {
        // line 4
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["site"]) ? $context["site"] : null), "charset", array()), "html", null, true);
        echo "\" />
    <link rel=\"profile\" href=\"http://gmpg.org/xfn/11\" />
    <link rel=\"pingback\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["site"]) ? $context["site"] : null), "pingback_url", array()), "html", null, true);
        echo "\" />";
    }

    // line 9
    public function block_head_application($context, array $blocks = array())
    {
        // line 10
        echo (isset($context["wp_head"]) ? $context["wp_head"] : null);
    }

    // line 13
    public function block_head_platform($context, array $blocks = array())
    {
        // line 14
        $this->displayParentBlock("head_platform", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-engine://css-compiled/wordpress.css"), "html", null, true);
        echo "\" type=\"text/css\" />
    <link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-theme://style.css"), "html", null, true);
        echo "\" type=\"text/css\" />";
    }

    // line 19
    public function block_head($context, array $blocks = array())
    {
        // line 20
        $this->displayParentBlock("head", $context, $blocks);
    }

    public function getTemplateName()
    {
        return "partials/page_head.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 20,  68 => 19,  63 => 16,  59 => 15,  55 => 14,  52 => 13,  48 => 10,  45 => 9,  40 => 6,  34 => 4,  31 => 3,  11 => 1,);
    }
}
/* {% extends "@nucleus/page_head.html.twig" %}*/
/* */
/* {% block head_title -%}*/
/*     <meta http-equiv="Content-Type" content="text/html; charset={{ site.charset }}" />*/
/*     <link rel="profile" href="http://gmpg.org/xfn/11" />*/
/*     <link rel="pingback" href="{{ site.pingback_url }}" />*/
/* {%- endblock %}*/
/* */
/* {% block head_application -%}*/
/*     {{ wp_head|raw }}*/
/* {%- endblock %}*/
/* */
/* {% block head_platform -%}*/
/*     {{ parent() }}*/
/*     <link rel="stylesheet" href="{{ url('gantry-engine://css-compiled/wordpress.css') }}" type="text/css" />*/
/*     <link rel="stylesheet" href="{{ url('gantry-theme://style.css') }}" type="text/css" />*/
/* {%- endblock %}*/
/* */
/* {% block head -%}*/
/*     {{ parent() }}*/
/* {%- endblock %}*/
/* */
