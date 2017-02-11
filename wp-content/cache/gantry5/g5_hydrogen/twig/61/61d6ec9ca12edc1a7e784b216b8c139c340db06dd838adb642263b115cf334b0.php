<?php

/* single.html.twig */
class __TwigTemplate_eb749bc03bde356cea9e578b89be54f87b166815538aa8d62843a4f413cd06a3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/page.html.twig", "single.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "partials/page.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["twigTemplate"] = "single.html.twig";
        // line 3
        $context["scope"] = "single";
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <div class=\"platform-content\">
        <div class=\"content-wrapper\">
            <section class=\"entry\">

                ";
        // line 11
        $this->loadTemplate(array(0 => (("partials/content-" . (isset($context["scope"]) ? $context["scope"] : null)) . ".html.twig"), 1 => "partials/content.html.twig"), "single.html.twig", 11)->display($context);
        // line 12
        echo "
            </section>
        </div> <!-- /content-wrapper -->
    </div>

";
    }

    public function getTemplateName()
    {
        return "single.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 12,  43 => 11,  36 => 6,  33 => 5,  29 => 1,  27 => 3,  25 => 2,  11 => 1,);
    }
}
/* {% extends "partials/page.html.twig" %}*/
/* {% set twigTemplate = 'single.html.twig' %}*/
/* {% set scope = 'single' %}*/
/* */
/* {% block content %}*/
/* */
/*     <div class="platform-content">*/
/*         <div class="content-wrapper">*/
/*             <section class="entry">*/
/* */
/*                 {% include ['partials/content-' ~ scope ~ '.html.twig', 'partials/content.html.twig'] %}*/
/* */
/*             </section>*/
/*         </div> <!-- /content-wrapper -->*/
/*     </div>*/
/* */
/* {% endblock %}*/
/* */
