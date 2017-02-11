<?php

/* partials/content.html.twig */
class __TwigTemplate_b6b43ab664f0c61a6a92c053e83b76ca39a21115d080a1a99dff12ca3e17f149 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<article class=\"tease tease-";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_type", array());
        echo " ";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "class", array());
        echo " clearfix\" id=\"tease-";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "ID", array());
        echo "\">

    ";
        // line 3
        $this->displayBlock('content', $context, $blocks);
        // line 90
        echo "
</article>
";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
        ";
        // line 6
        echo "        <section class=\"entry-header\">

            ";
        // line 9
        echo "            ";
        if ($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".title.enabled"), 1 => "1"), "method")) {
            // line 10
            echo "                <h2 class=\"entry-title\">
                    ";
            // line 11
            if ($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".title.link"), 1 => "0"), "method")) {
                // line 12
                echo "                        <a href=\"";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "link", array());
                echo "\" title=\"";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title", array());
                echo "\">";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title", array());
                echo "</a>
                    ";
            } else {
                // line 14
                echo "                        ";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title", array());
                echo "
                    ";
            }
            // line 16
            echo "                </h2>
            ";
        }
        // line 18
        echo "            ";
        // line 19
        echo "
            ";
        // line 21
        echo "            ";
        if ((((($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".meta-date.enabled"), 1 => "1"), "method") || $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".meta-author.enabled"), 1 => "1"), "method")) || $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".meta-comments.enabled"), 1 => "1"), "method")) || $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".meta-categories.enabled"), 1 => "1"), "method")) || $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".meta-tags.enabled"), 1 => "0"), "method"))) {
            // line 22
            echo "                ";
            $this->loadTemplate(array(0 => (("partials/meta-" . (isset($context["scope"]) ? $context["scope"] : null)) . ".html.twig"), 1 => "partials/meta.html.twig"), "partials/content.html.twig", 22)->display($context);
            // line 23
            echo "            ";
        }
        // line 24
        echo "            ";
        // line 25
        echo "
        </section>
        ";
        // line 28
        echo "
        ";
        // line 30
        echo "        ";
        if ( !call_user_func_array($this->env->getFunction('function')->getCallable(), array("post_password_required", $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "ID", array())))) {
            // line 31
            echo "
            ";
            // line 33
            echo "            <section class=\"entry-content\">

                ";
            // line 36
            echo "                ";
            if (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".featured-image.enabled"), 1 => "1"), "method") && $this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "thumbnail", array()), "src", array()))) {
                // line 37
                echo "                    ";
                $context["position"] = ((($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".featured-image.position"), 1 => "none"), "method") == "none")) ? ("") : (("float-" . $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".featured-image.position"), 1 => "none"), "method"))));
                // line 38
                echo "                    <a href=\"";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "link", array());
                echo "\" class=\"post-thumbnail\" aria-hidden=\"true\">
                        <img src=\"";
                // line 39
                echo call_user_func_array($this->env->getFilter('resize')->getCallable(), array($this->getAttribute($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "thumbnail", array()), "src", array()), $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".featured-image.width"), 1 => "1200"), "method"), $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".featured-image.height"), 1 => "350"), "method")));
                echo "\" class=\"featured-image tease-featured-image ";
                echo (isset($context["position"]) ? $context["position"] : null);
                echo "\" alt=\"";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title", array());
                echo "\" />
                    </a>
                ";
            }
            // line 42
            echo "                ";
            // line 43
            echo "
                ";
            // line 45
            echo "                ";
            if ((($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".content.type"), 1 => "content"), "method") == "excerpt") &&  !twig_test_empty($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_excerpt", array())))) {
                // line 46
                echo "                    <div class=\"post-excerpt\">";
                echo call_user_func_array($this->env->getFilter('apply_filters')->getCallable(), array($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_excerpt", array()), "the_excerpt"));
                echo "</div>
                ";
            } else {
                // line 48
                echo "                    <div class=\"post-content\">
                        ";
                // line 49
                $context["readmore"] = $this->env->getExtension('GantryTwig')->pregMatch("/<!--more(.*?)?-->/", $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_content", array()));
                // line 50
                echo "                        ";
                if ((isset($context["readmore"]) ? $context["readmore"] : null)) {
                    // line 51
                    echo "                            ";
                    $context["split_content"] = twig_split_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_content", array()), $this->getAttribute((isset($context["readmore"]) ? $context["readmore"] : null), 0, array(), "array"), 2);
                    // line 52
                    echo "                            ";
                    echo call_user_func_array($this->env->getFilter('apply_filters')->getCallable(), array($this->getAttribute((isset($context["split_content"]) ? $context["split_content"] : null), 0, array(), "array"), "the_content"));
                    echo "
                        ";
                } elseif (twig_in_filter("<!--nextpage-->", $this->getAttribute(                // line 53
(isset($context["post"]) ? $context["post"] : null), "post_content", array()))) {
                    // line 54
                    echo "                            ";
                    $context["split_content"] = twig_split_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_content", array()), "<!--nextpage-->", 2);
                    // line 55
                    echo "                            ";
                    echo call_user_func_array($this->env->getFilter('apply_filters')->getCallable(), array($this->getAttribute((isset($context["split_content"]) ? $context["split_content"] : null), 0, array(), "array"), "the_content"));
                    echo "
                        ";
                } else {
                    // line 57
                    echo "                            ";
                    echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "content", array());
                    echo "
                        ";
                }
                // line 59
                echo "                    </div>
                ";
            }
            // line 61
            echo "
                ";
            // line 62
            if ((($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".read-more.mode"), 1 => "auto"), "method") == "always") || (($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".read-more.mode"), 1 => "auto"), "method") == "auto") && ((isset($context["readmore"]) ? $context["readmore"] : null) ||  !twig_test_empty($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_excerpt", array())))))) {
                // line 63
                echo "                    <a href=\"";
                echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "link", array());
                echo "\" class=\"read-more button\">
                        ";
                // line 64
                if ( !twig_test_empty($this->getAttribute((isset($context["readmore"]) ? $context["readmore"] : null), 1, array(), "array"))) {
                    // line 65
                    echo $this->getAttribute((isset($context["readmore"]) ? $context["readmore"] : null), 1, array(), "array");
                } else {
                    // line 67
                    echo "                            ";
                    echo $this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "get", array(0 => (("content." . (isset($context["scope"]) ? $context["scope"] : null)) . ".read-more.label"), 1 => "Read More"), "method");
                    echo "
                        ";
                }
                // line 69
                echo "                    </a>
                ";
            }
            // line 71
            echo "                ";
            // line 72
            echo "
            </section>
            ";
            // line 75
            echo "
        ";
        } else {
            // line 77
            echo "
            ";
            // line 79
            echo "            <div class=\"password-form\">

                ";
            // line 82
            echo "                ";
            $this->loadTemplate("partials/password-form.html.twig", "partials/content.html.twig", 82)->display($context);
            // line 83
            echo "
            </div>
            ";
            // line 86
            echo "
        ";
        }
        // line 88
        echo "
    ";
    }

    public function getTemplateName()
    {
        return "partials/content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  234 => 88,  230 => 86,  226 => 83,  223 => 82,  219 => 79,  216 => 77,  212 => 75,  208 => 72,  206 => 71,  202 => 69,  196 => 67,  193 => 65,  191 => 64,  186 => 63,  184 => 62,  181 => 61,  177 => 59,  171 => 57,  165 => 55,  162 => 54,  160 => 53,  155 => 52,  152 => 51,  149 => 50,  147 => 49,  144 => 48,  138 => 46,  135 => 45,  132 => 43,  130 => 42,  120 => 39,  115 => 38,  112 => 37,  109 => 36,  105 => 33,  102 => 31,  99 => 30,  96 => 28,  92 => 25,  90 => 24,  87 => 23,  84 => 22,  81 => 21,  78 => 19,  76 => 18,  72 => 16,  66 => 14,  56 => 12,  54 => 11,  51 => 10,  48 => 9,  44 => 6,  41 => 4,  38 => 3,  32 => 90,  30 => 3,  20 => 1,);
    }
}
/* <article class="tease tease-{{ post.post_type }} {{ post.class }} clearfix" id="tease-{{ post.ID }}">*/
/* */
/*     {% block content %}*/
/* */
/*         {# Begin Entry Header #}*/
/*         <section class="entry-header">*/
/* */
/*             {# Begin Entry Title #}*/
/*             {% if gantry.config.get('content.' ~ scope ~ '.title.enabled', '1') %}*/
/*                 <h2 class="entry-title">*/
/*                     {% if gantry.config.get('content.' ~ scope ~ '.title.link', '0') %}*/
/*                         <a href="{{ post.link }}" title="{{ post.title }}">{{ post.title }}</a>*/
/*                     {% else %}*/
/*                         {{ post.title }}*/
/*                     {% endif %}*/
/*                 </h2>*/
/*             {% endif %}*/
/*             {# End Entry Title #}*/
/* */
/*             {# Begin Entry Meta #}*/
/*             {% if gantry.config.get('content.' ~ scope ~ '.meta-date.enabled', '1') or gantry.config.get('content.' ~ scope ~ '.meta-author.enabled', '1') or gantry.config.get('content.' ~ scope ~ '.meta-comments.enabled', '1') or gantry.config.get('content.' ~ scope ~ '.meta-categories.enabled', '1') or gantry.config.get('content.' ~ scope ~ '.meta-tags.enabled', '0') %}*/
/*                 {% include ['partials/meta-' ~ scope ~ '.html.twig', 'partials/meta.html.twig'] %}*/
/*             {% endif %}*/
/*             {# End Entry Meta #}*/
/* */
/*         </section>*/
/*         {# End Entry Header #}*/
/* */
/*         {# Check if post is password protected #}*/
/*         {% if not function( 'post_password_required', post.ID ) %}*/
/* */
/*             {# Begin Entry Content #}*/
/*             <section class="entry-content">*/
/* */
/*                 {# Begin Featured Image #}*/
/*                 {% if gantry.config.get('content.' ~ scope ~ '.featured-image.enabled', '1') and post.thumbnail.src %}*/
/*                     {% set position = (gantry.config.get('content.' ~ scope ~ '.featured-image.position', 'none') == 'none') ? '' : 'float-' ~ gantry.config.get('content.' ~ scope ~ '.featured-image.position', 'none') %}*/
/*                     <a href="{{ post.link }}" class="post-thumbnail" aria-hidden="true">*/
/*                         <img src="{{ post.thumbnail.src|resize(gantry.config.get('content.' ~ scope ~ '.featured-image.width', '1200'), gantry.config.get('content.' ~ scope ~ '.featured-image.height', '350')) }}" class="featured-image tease-featured-image {{ position }}" alt="{{ post.title }}" />*/
/*                     </a>*/
/*                 {% endif %}*/
/*                 {# End Featured Image #}*/
/* */
/*                 {# Begin Tease #}*/
/*                 {% if gantry.config.get('content.' ~ scope ~ '.content.type', 'content') == 'excerpt' and post.post_excerpt is not empty %}*/
/*                     <div class="post-excerpt">{{ post.post_excerpt|apply_filters('the_excerpt')|raw }}</div>*/
/*                 {% else %}*/
/*                     <div class="post-content">*/
/*                         {% set readmore = preg_match('/<!--more(.*?)?-->/', post.post_content) %}*/
/*                         {% if readmore %}*/
/*                             {% set split_content = post.post_content|split(readmore[0], 2) %}*/
/*                             {{ split_content[0]|apply_filters('the_content')|raw }}*/
/*                         {% elseif '<!--nextpage-->' in post.post_content %}*/
/*                             {% set split_content = post.post_content|split('<!--nextpage-->', 2) %}*/
/*                             {{ split_content[0]|apply_filters('the_content')|raw }}*/
/*                         {% else %}*/
/*                             {{ post.content|raw }}*/
/*                         {% endif %}*/
/*                     </div>*/
/*                 {% endif %}*/
/* */
/*                 {% if gantry.config.get('content.' ~ scope ~ '.read-more.mode', 'auto') == 'always' or (gantry.config.get('content.' ~ scope ~ '.read-more.mode', 'auto') == 'auto' and (readmore or post.post_excerpt is not empty) )  %}*/
/*                     <a href="{{ post.link }}" class="read-more button">*/
/*                         {% if readmore[1] is not empty %}*/
/*                             {{- readmore[1] -}}*/
/*                         {% else %}*/
/*                             {{ gantry.config.get('content.' ~ scope ~ '.read-more.label', 'Read More') }}*/
/*                         {% endif %}*/
/*                     </a>*/
/*                 {% endif %}*/
/*                 {# End Tease #}*/
/* */
/*             </section>*/
/*             {# End Entry Content #}*/
/* */
/*         {% else %}*/
/* */
/*             {# Begin Password Protected Form #}*/
/*             <div class="password-form">*/
/* */
/*                 {# Include the password form #}*/
/*                 {% include 'partials/password-form.html.twig' %}*/
/* */
/*             </div>*/
/*             {# End Password Protected Form #}*/
/* */
/*         {% endif %}*/
/* */
/*     {% endblock %}*/
/* */
/* </article>*/
/* */
