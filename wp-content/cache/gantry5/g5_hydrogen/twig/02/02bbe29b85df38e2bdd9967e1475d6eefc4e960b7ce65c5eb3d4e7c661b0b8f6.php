<?php

/* partials/content-single.html.twig */
class __TwigTemplate_240d88acbd9044c85cbdfe96f57fe11a94158295b4f3c48e8ac7ed40afff3834 extends Twig_Template
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
        echo "<article class=\"post-type-";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_type", array());
        echo " ";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "class", array());
        echo "\" id=\"post-";
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "ID", array());
        echo "\">

    ";
        // line 3
        $this->displayBlock('content', $context, $blocks);
        // line 77
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
            $this->loadTemplate(array(0 => (("partials/meta-" . (isset($context["scope"]) ? $context["scope"] : null)) . ".html.twig"), 1 => "partials/meta.html.twig"), "partials/content-single.html.twig", 22)->display($context);
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
            echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "paged_content", array());
            echo "

                ";
            // line 47
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("wp_link_pages", array("before" => "<div class=\"page-links\" itemprop=\"pagination\">", "after" => "</div>", "link_before" => "<span class=\"page-number page-numbers\">", "link_after" => "</span>", "echo" => 0)));
            echo "
                ";
            // line 49
            echo "
                ";
            // line 51
            echo "                ";
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("edit_post_link", call_user_func_array($this->env->getFunction('__')->getCallable(), array("Edit", "g5_hydrogen")), "<span class=\"edit-link\">", "</span>"));
            echo "
                ";
            // line 53
            echo "
            </section>
            ";
            // line 56
            echo "
            ";
            // line 58
            echo "            ";
            if (((($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "comment_status", array()) == "open") || ($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "comment_count", array()) > 0)) && ($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_type", array()) != "product"))) {
                // line 59
                echo "                ";
                echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("comments_template"));
                echo "
            ";
            }
            // line 61
            echo "            ";
            // line 62
            echo "
        ";
        } else {
            // line 64
            echo "
            ";
            // line 66
            echo "            <div class=\"password-form\">

                ";
            // line 69
            echo "                ";
            $this->loadTemplate("partials/password-form.html.twig", "partials/content-single.html.twig", 69)->display($context);
            // line 70
            echo "
            </div>
            ";
            // line 73
            echo "
        ";
        }
        // line 75
        echo "
    ";
    }

    public function getTemplateName()
    {
        return "partials/content-single.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  193 => 75,  189 => 73,  185 => 70,  182 => 69,  178 => 66,  175 => 64,  171 => 62,  169 => 61,  163 => 59,  160 => 58,  157 => 56,  153 => 53,  148 => 51,  145 => 49,  141 => 47,  135 => 45,  132 => 43,  130 => 42,  120 => 39,  115 => 38,  112 => 37,  109 => 36,  105 => 33,  102 => 31,  99 => 30,  96 => 28,  92 => 25,  90 => 24,  87 => 23,  84 => 22,  81 => 21,  78 => 19,  76 => 18,  72 => 16,  66 => 14,  56 => 12,  54 => 11,  51 => 10,  48 => 9,  44 => 6,  41 => 4,  38 => 3,  32 => 77,  30 => 3,  20 => 1,);
    }
}
/* <article class="post-type-{{ post.post_type }} {{ post.class }}" id="post-{{ post.ID }}">*/
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
/*                 {# Begin Page Content #}*/
/*                 {{ post.paged_content|raw }}*/
/* */
/*                 {{ function('wp_link_pages', {'before': '<div class="page-links" itemprop="pagination">', 'after': '</div>', 'link_before': '<span class="page-number page-numbers">', 'link_after': '</span>', 'echo': 0}) }}*/
/*                 {# End Page Content #}*/
/* */
/*                 {# Begin Edit Link #}*/
/*                 {{ function('edit_post_link', __('Edit', 'g5_hydrogen'), '<span class="edit-link">', '</span>') }}*/
/*                 {# End Edit Link #}*/
/* */
/*             </section>*/
/*             {# End Entry Content #}*/
/* */
/*             {# Begin Comments #}*/
/*             {% if (post.comment_status == 'open' or post.comment_count > 0) and post.post_type != 'product' %}*/
/*                 {{ function('comments_template')|raw }}*/
/*             {% endif %}*/
/*             {# End Comments #}*/
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
