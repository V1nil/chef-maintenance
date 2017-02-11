<?php

/* index.html.twig */
class __TwigTemplate_559c37d8704159cf373c84480945d6ea4bcb44d6750953739836c38f6a2dbc78 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("partials/page.html.twig", "index.html.twig", 1);
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
        $context["twigTemplate"] = "index.html.twig";
        // line 3
        $context["scope"] = "blog";
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <div class=\"platform-content\">
        <div class=\"blog\">

            ";
        // line 11
        echo "            ";
        if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".heading.enabled"), 1 => "0"), "method") &&  !twig_test_empty($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".heading.text")), "method")))) {
            // line 12
            echo "                <header class=\"page-header\">
                    <h1>
                        ";
            // line 14
            echo $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".heading.text")), "method");
            echo "
                    </h1>
                </header>
            ";
        }
        // line 18
        echo "            ";
        // line 19
        echo "
            ";
        // line 21
        echo "            <section class=\"entries\">
                ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["posts"]) ? $context["posts"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 23
            echo "                    ";
            $this->loadTemplate(array(0 => (("partials/content-" . (isset($context["scope"]) ? $context["scope"] : null)) . ".html.twig"), 1 => (($this->getAttribute($context["post"], "format", array())) ? ((("partials/content-" . $this->getAttribute($context["post"], "format", array())) . ".html.twig")) : ("")), 2 => "partials/content.html.twig"), "index.html.twig", 23)->display($context);
            // line 24
            echo "                ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "            </section>
            ";
        // line 27
        echo "
            ";
        // line 29
        echo "            ";
        if (($this->getAttribute((isset($context["pagination"]) ? $context["pagination"] : null), "pages", array()) && (twig_length_filter($this->env, $this->getAttribute((isset($context["pagination"]) ? $context["pagination"] : null), "pages", array())) > 1))) {
            // line 30
            echo "                ";
            $this->loadTemplate("partials/pagination.html.twig", "index.html.twig", 30)->display($context);
            // line 31
            echo "            ";
        }
        // line 32
        echo "            ";
        // line 33
        echo "
        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 33,  113 => 32,  110 => 31,  107 => 30,  104 => 29,  101 => 27,  98 => 25,  84 => 24,  81 => 23,  64 => 22,  61 => 21,  58 => 19,  56 => 18,  49 => 14,  45 => 12,  42 => 11,  36 => 6,  33 => 5,  29 => 1,  27 => 3,  25 => 2,  11 => 1,);
    }
}
/* {% extends "partials/page.html.twig" %}*/
/* {% set twigTemplate = 'index.html.twig' %}*/
/* {% set scope = 'blog' %}*/
/* */
/* {% block content %}*/
/* */
/*     <div class="platform-content">*/
/*         <div class="blog">*/
/* */
/*             {# Begin Page Header #}*/
/*             {% if gantry.config.get('content.' ~ scope ~ '.heading.enabled', '0') and gantry.config.get('content.' ~ scope ~ '.heading.text') is not empty %}*/
/*                 <header class="page-header">*/
/*                     <h1>*/
/*                         {{ gantry.config.get('content.' ~ scope ~ '.heading.text') }}*/
/*                     </h1>*/
/*                 </header>*/
/*             {% endif %}*/
/*             {# End Page Header #}*/
/* */
/*             {# Begin Post Entries #}*/
/*             <section class="entries">*/
/*                 {% for post in posts %}*/
/*                     {% include ['partials/content-' ~ scope ~ '.html.twig', (post.format) ? 'partials/content-' ~ post.format ~ '.html.twig' : '', 'partials/content.html.twig'] %}*/
/*                 {% endfor %}*/
/*             </section>*/
/*             {# End Post Entries #}*/
/* */
/*             {# Begin Pagination #}*/
/*             {% if pagination.pages and pagination.pages|length > 1 %}*/
/*                 {% include 'partials/pagination.html.twig' %}*/
/*             {% endif %}*/
/*             {# End Pagination #}*/
/* */
/*         </div>*/
/*     </div>*/
/* */
/* {% endblock %}*/
/* */
