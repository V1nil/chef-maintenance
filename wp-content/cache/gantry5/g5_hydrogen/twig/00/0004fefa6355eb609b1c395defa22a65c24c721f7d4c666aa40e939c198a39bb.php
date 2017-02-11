<?php

/* @particles/contentarray.html.twig */
class __TwigTemplate_37f5a05f6a7cd9e2d538c7545b3760458c09123d32601650b61fd10fd0c3303e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/contentarray.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $context["attr_extra"] = "";
        // line 4
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "extra", array())) {
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "extra", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["attributes"]) {
                // line 6
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["attributes"]);
                foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                    // line 7
                    $context["attr_extra"] = ((((((isset($context["attr_extra"]) ? $context["attr_extra"] : null) . " ") . twig_escape_filter($this->env, $context["key"])) . "=\"") . twig_escape_filter($this->env, $context["value"], "html_attr")) . "\"");
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attributes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 12
    public function block_particle($context, array $blocks = array())
    {
        // line 13
        echo "    ";
        $context["post_settings"] = $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "post", array());
        // line 14
        echo "    ";
        $context["filter"] = $this->getAttribute((isset($context["post_settings"]) ? $context["post_settings"] : null), "filter", array());
        // line 15
        echo "    ";
        $context["sort"] = $this->getAttribute((isset($context["post_settings"]) ? $context["post_settings"] : null), "sort", array());
        // line 16
        echo "    ";
        $context["limit"] = $this->getAttribute((isset($context["post_settings"]) ? $context["post_settings"] : null), "limit", array());
        // line 17
        echo "    ";
        $context["display"] = $this->getAttribute((isset($context["post_settings"]) ? $context["post_settings"] : null), "display", array());
        // line 18
        echo "
    ";
        // line 20
        echo "    ";
        $context["sticky_posts"] = (($this->getAttribute((isset($context["filter"]) ? $context["filter"] : null), "sticky", array())) ? (false) : (true));
        // line 21
        echo "
    ";
        // line 23
        echo "    ";
        $context["query_parameters"] = array("cat" => twig_replace_filter($this->getAttribute(        // line 24
(isset($context["filter"]) ? $context["filter"] : null), "categories", array()), " ", ","), "posts_per_page" => (($this->getAttribute(        // line 25
(isset($context["limit"]) ? $context["limit"] : null), "total", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["limit"]) ? $context["limit"] : null), "total", array()), "-1")) : ("-1")), "offset" => (($this->getAttribute(        // line 26
(isset($context["limit"]) ? $context["limit"] : null), "start", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["limit"]) ? $context["limit"] : null), "start", array()), "0")) : ("0")), "orderby" => $this->getAttribute(        // line 27
(isset($context["sort"]) ? $context["sort"] : null), "orderby", array()), "order" => $this->getAttribute(        // line 28
(isset($context["sort"]) ? $context["sort"] : null), "ordering", array()), "ignore_sticky_posts" =>         // line 29
(isset($context["sticky_posts"]) ? $context["sticky_posts"] : null));
        // line 31
        echo "
    ";
        // line 32
        $context["posts"] = $this->getAttribute((isset($context["wordpress"]) ? $context["wordpress"] : null), "call", array(0 => "Timber::get_posts", 1 => (isset($context["query_parameters"]) ? $context["query_parameters"] : null)), "method");
        // line 33
        echo "
    ";
        // line 35
        echo "    <div class=\"g-content-array g-wordpress-posts";
        if ($this->getAttribute($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "css", array()), "class", array())) {
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "css", array()), "class", array()), "html", null, true);
        }
        echo "\" ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "extra", array())) {
            echo (isset($context["attr_extra"]) ? $context["attr_extra"] : null);
        }
        echo ">

        ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_array_batch((isset($context["posts"]) ? $context["posts"] : null), $this->getAttribute((isset($context["limit"]) ? $context["limit"] : null), "columns", array())));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 38
            echo "            <div class=\"g-grid\">
                ";
            // line 39
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["column"]);
            foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
                // line 40
                echo "
                    <div class=\"g-block\">
                        <div class=\"g-content\">
                            <div class=\"g-array-item\">
                                ";
                // line 44
                if (($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "image", array()), "enabled", array()) && $this->getAttribute($this->getAttribute($context["post"], "thumbnail", array()), "src", array()))) {
                    // line 45
                    echo "                                    <div class=\"g-array-item-image\">
                                        <a href=\"";
                    // line 46
                    echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "link", array()), "html", null, true);
                    echo "\">
                                            <img src=\"";
                    // line 47
                    echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute($context["post"], "thumbnail", array()), "src", array())), "html", null, true);
                    echo "\" />
                                        </a>
                                    </div>
                                ";
                }
                // line 51
                echo "
                                ";
                // line 52
                if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "title", array()), "enabled", array())) {
                    // line 53
                    echo "                                    <div class=\"g-array-item-title\">
                                        <h3 class=\"g-item-title\">
                                            <a href=\"";
                    // line 55
                    echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "link", array()), "html", null, true);
                    echo "\">
                                                ";
                    // line 56
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "title", array()), "limit", array())) ? ($this->env->getExtension('GantryTwig')->truncateText($this->getAttribute($context["post"], "title", array()), $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "title", array()), "limit", array()))) : ($this->getAttribute($context["post"], "title", array()))), "html", null, true);
                    echo "
                                            </a>
                                        </h3>
                                    </div>
                                ";
                }
                // line 61
                echo "
                                ";
                // line 62
                if (((($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "date", array()), "enabled", array()) || $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "author", array()), "enabled", array())) || $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "category", array()), "enabled", array())) || $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "comments", array()), "enabled", array()))) {
                    // line 63
                    echo "                                    <div class=\"g-array-item-details\">
                                        ";
                    // line 64
                    if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "date", array()), "enabled", array())) {
                        // line 65
                        echo "                                            <span class=\"g-array-item-date\">
                                                ";
                        // line 66
                        if (($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "date", array()), "enabled", array()) == "modified")) {
                            // line 67
                            echo "                                                    <i class=\"fa fa-clock-o\"></i>";
                            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->getAttribute($context["post"], "post_modified", array()), $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "date", array()), "format", array()))), "html", null, true);
                            echo "
                                                ";
                        } else {
                            // line 69
                            echo "                                                    <i class=\"fa fa-clock-o\"></i>";
                            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('date')->getCallable(), array($this->getAttribute($context["post"], "post_date", array()), $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "date", array()), "format", array()))), "html", null, true);
                            echo "
                                                ";
                        }
                        // line 71
                        echo "                                            </span>
                                        ";
                    }
                    // line 73
                    echo "
                                        ";
                    // line 74
                    if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "author", array()), "enabled", array())) {
                        // line 75
                        echo "                                            <span class=\"g-array-item-author\">
                                                <i class=\"fa fa-user\"></i>";
                        // line 76
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["post"], "author", array()), "name", array()), "html", null, true);
                        echo "
                                            </span>
                                        ";
                    }
                    // line 79
                    echo "
                                        ";
                    // line 80
                    if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "category", array()), "enabled", array())) {
                        // line 81
                        echo "                                            ";
                        $context["category_link"] = ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "category", array()), "enabled", array()) == "link");
                        // line 82
                        ob_start();
                        // line 83
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["post"], "categories", array()));
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
                        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                            // line 84
                            if ((isset($context["category_link"]) ? $context["category_link"] : null)) {
                                // line 85
                                echo "<a href=\"";
                                echo twig_escape_filter($this->env, $this->getAttribute($context["category"], "link", array()), "html", null, true);
                                echo "\">
                                                            ";
                                // line 86
                                echo twig_escape_filter($this->env, $this->getAttribute($context["category"], "title", array()), "html", null, true);
                                echo "
                                                        </a>";
                            } else {
                                // line 89
                                echo twig_escape_filter($this->env, $this->getAttribute($context["category"], "title", array()), "html", null, true);
                            }
                            // line 91
                            if ( !$this->getAttribute($context["loop"], "last", array())) {
                                echo twig_escape_filter($this->env, trim(","), "html", null, true);
                            }
                            // line 92
                            echo "                                                ";
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
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        $context["post_categories"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 95
                        echo "<span class=\"g-array-item-category\">
                                                <i class=\"fa fa-folder-open\"></i>";
                        // line 96
                        echo (isset($context["post_categories"]) ? $context["post_categories"] : null);
                        echo "
                                            </span>
                                        ";
                    }
                    // line 99
                    echo "
                                        ";
                    // line 100
                    if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "comments", array()), "enabled", array())) {
                        // line 101
                        ob_start();
                        // line 102
                        if (($this->getAttribute($context["post"], "comment_count", array()) == "0")) {
                            // line 103
                            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('__')->getCallable(), array("No comments", "gantry5")), "html", null, true);
                        } elseif (($this->getAttribute(                        // line 104
$context["post"], "comment_count", array()) == "1")) {
                            // line 105
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["post"], "comment_count", array()) . " ") . call_user_func_array($this->env->getFunction('__')->getCallable(), array("Comment", "gantry5"))), "html", null, true);
                        } else {
                            // line 107
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["post"], "comment_count", array()) . " ") . call_user_func_array($this->env->getFunction('__')->getCallable(), array("Comments", "gantry5"))), "html", null, true);
                        }
                        $context["comment_count"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 111
                        echo "<span class=\"g-array-item-comments\">
                                                <i class=\"fa fa-comments\"></i>";
                        // line 112
                        echo twig_escape_filter($this->env, (isset($context["comment_count"]) ? $context["comment_count"] : null), "html", null, true);
                        echo "
                                            </span>
                                        ";
                    }
                    // line 115
                    echo "                                    </div>
                                ";
                }
                // line 117
                echo "
                                ";
                // line 118
                if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "text", array()), "type", array())) {
                    // line 119
                    echo "                                    ";
                    $context["post_text"] = ((($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "text", array()), "type", array()) == "excerpt")) ? ($this->getAttribute($context["post"], "post_excerpt", array())) : ($this->getAttribute($context["post"], "content", array())));
                    // line 120
                    echo "                                    <div class=\"g-array-item-text\">
                                        ";
                    // line 121
                    if (($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "text", array()), "formatting", array()) == "text")) {
                        // line 122
                        echo "                                            ";
                        echo $this->env->getExtension('GantryTwig')->truncateText((isset($context["post_text"]) ? $context["post_text"] : null), $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "text", array()), "limit", array()));
                        echo "
                                        ";
                    } else {
                        // line 124
                        echo "                                            ";
                        echo $this->env->getExtension('GantryTwig')->truncateHtml((isset($context["post_text"]) ? $context["post_text"] : null), $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "text", array()), "limit", array()));
                        echo "
                                        ";
                    }
                    // line 126
                    echo "                                    </div>
                                ";
                }
                // line 128
                echo "
                                ";
                // line 129
                if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "read_more", array()), "enabled", array())) {
                    // line 130
                    echo "                                    <div class=\"g-array-item-read-more\">
                                        <a href=\"";
                    // line 131
                    echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "link", array()), "html", null, true);
                    echo "\">
                                            <button class=\"button";
                    // line 132
                    if ($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "read_more", array()), "css", array())) {
                        echo " ";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "read_more", array()), "css", array()), "html", null, true);
                    }
                    echo "\">";
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "read_more", array(), "any", false, true), "label", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute((isset($context["display"]) ? $context["display"] : null), "read_more", array(), "any", false, true), "label", array()), "Read More...")) : ("Read More...")), "html", null, true);
                    echo "</button>
                                        </a>
                                    </div>
                                ";
                }
                // line 136
                echo "                            </div>
                        </div>
                    </div>

                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 141
            echo "            </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 143
        echo "    </div>

";
    }

    public function getTemplateName()
    {
        return "@particles/contentarray.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  381 => 143,  374 => 141,  364 => 136,  352 => 132,  348 => 131,  345 => 130,  343 => 129,  340 => 128,  336 => 126,  330 => 124,  324 => 122,  322 => 121,  319 => 120,  316 => 119,  314 => 118,  311 => 117,  307 => 115,  301 => 112,  298 => 111,  294 => 107,  291 => 105,  289 => 104,  287 => 103,  285 => 102,  283 => 101,  281 => 100,  278 => 99,  272 => 96,  269 => 95,  254 => 92,  250 => 91,  247 => 89,  242 => 86,  237 => 85,  235 => 84,  218 => 83,  216 => 82,  213 => 81,  211 => 80,  208 => 79,  202 => 76,  199 => 75,  197 => 74,  194 => 73,  190 => 71,  184 => 69,  178 => 67,  176 => 66,  173 => 65,  171 => 64,  168 => 63,  166 => 62,  163 => 61,  155 => 56,  151 => 55,  147 => 53,  145 => 52,  142 => 51,  135 => 47,  131 => 46,  128 => 45,  126 => 44,  120 => 40,  116 => 39,  113 => 38,  109 => 37,  96 => 35,  93 => 33,  91 => 32,  88 => 31,  86 => 29,  85 => 28,  84 => 27,  83 => 26,  82 => 25,  81 => 24,  79 => 23,  76 => 21,  73 => 20,  70 => 18,  67 => 17,  64 => 16,  61 => 15,  58 => 14,  55 => 13,  52 => 12,  48 => 1,  37 => 7,  33 => 6,  29 => 5,  27 => 4,  25 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% set attr_extra = '' %}*/
/* {% if particle.extra %}*/
/*     {% for attributes in particle.extra %}*/
/*         {% for key, value in attributes %}*/
/*             {% set attr_extra = attr_extra ~ ' ' ~ key|e ~ '="' ~ value|e('html_attr') ~ '"' %}*/
/*         {% endfor %}*/
/*     {% endfor %}*/
/* {% endif %}*/
/* */
/* {% block particle %}*/
/*     {% set post_settings = particle.post %}*/
/*     {% set filter = post_settings.filter %}*/
/*     {% set sort = post_settings.sort %}*/
/*     {% set limit = post_settings.limit %}*/
/*     {% set display = post_settings.display %}*/
/* */
/*     {# Sticky Posts #}*/
/*     {% set sticky_posts = filter.sticky ? false : true %}*/
/* */
/*     {# Query Posts #}*/
/*     {% set query_parameters = {*/
/*         'cat': filter.categories|replace(' ', ','),*/
/*         'posts_per_page': limit.total|default('-1'),*/
/*         'offset': limit.start|default('0'),*/
/*         'orderby': sort.orderby,*/
/*         'order': sort.ordering,*/
/*         'ignore_sticky_posts': sticky_posts*/
/*     } %}*/
/* */
/*     {% set posts = wordpress.call('Timber::get_posts', query_parameters) %}*/
/* */
/*     {# All Posts #}*/
/*     <div class="g-content-array g-wordpress-posts{% if particle.css.class %} {{ particle.css.class }}{% endif %}" {% if particle.extra %}{{ attr_extra|raw }}{% endif %}>*/
/* */
/*         {% for column in posts|batch(limit.columns) %}*/
/*             <div class="g-grid">*/
/*                 {% for post in column %}*/
/* */
/*                     <div class="g-block">*/
/*                         <div class="g-content">*/
/*                             <div class="g-array-item">*/
/*                                 {% if display.image.enabled and post.thumbnail.src %}*/
/*                                     <div class="g-array-item-image">*/
/*                                         <a href="{{ post.link }}">*/
/*                                             <img src="{{ url(post.thumbnail.src) }}" />*/
/*                                         </a>*/
/*                                     </div>*/
/*                                 {% endif %}*/
/* */
/*                                 {% if display.title.enabled %}*/
/*                                     <div class="g-array-item-title">*/
/*                                         <h3 class="g-item-title">*/
/*                                             <a href="{{ post.link }}">*/
/*                                                 {{ display.title.limit ? post.title|truncate_text(display.title.limit) : post.title }}*/
/*                                             </a>*/
/*                                         </h3>*/
/*                                     </div>*/
/*                                 {% endif %}*/
/* */
/*                                 {% if display.date.enabled or display.author.enabled or display.category.enabled or display.comments.enabled %}*/
/*                                     <div class="g-array-item-details">*/
/*                                         {% if display.date.enabled %}*/
/*                                             <span class="g-array-item-date">*/
/*                                                 {% if display.date.enabled == 'modified' %}*/
/*                                                     <i class="fa fa-clock-o"></i>{{ post.post_modified|date(display.date.format) }}*/
/*                                                 {% else %}*/
/*                                                     <i class="fa fa-clock-o"></i>{{ post.post_date|date(display.date.format) }}*/
/*                                                 {% endif %}*/
/*                                             </span>*/
/*                                         {% endif %}*/
/* */
/*                                         {% if display.author.enabled %}*/
/*                                             <span class="g-array-item-author">*/
/*                                                 <i class="fa fa-user"></i>{{ post.author.name }}*/
/*                                             </span>*/
/*                                         {% endif %}*/
/* */
/*                                         {% if display.category.enabled %}*/
/*                                             {% set category_link = display.category.enabled == 'link' %}*/
/*                                             {%- set post_categories -%}*/
/*                                                 {% for category in post.categories %}*/
/*                                                     {%- if category_link -%}*/
/*                                                         <a href="{{ category.link }}">*/
/*                                                             {{ category.title }}*/
/*                                                         </a>*/
/*                                                     {%- else -%}*/
/*                                                         {{ category.title }}*/
/*                                                     {%- endif -%}*/
/*                                                     {% if not loop.last %}{{ ','|trim }}{% endif %}*/
/*                                                 {% endfor %}*/
/*                                             {%- endset -%}*/
/* */
/*                                             <span class="g-array-item-category">*/
/*                                                 <i class="fa fa-folder-open"></i>{{ post_categories|raw }}*/
/*                                             </span>*/
/*                                         {% endif %}*/
/* */
/*                                         {% if display.comments.enabled %}*/
/*                                             {%- set comment_count -%}*/
/*                                                 {%- if post.comment_count == '0' -%}*/
/*                                                     {{ __('No comments', 'gantry5') }}*/
/*                                                 {%- elseif post.comment_count == '1' -%}*/
/*                                                     {{ post.comment_count ~ ' ' ~ __('Comment', 'gantry5') }}*/
/*                                                 {%- else -%}*/
/*                                                     {{ post.comment_count ~ ' ' ~ __('Comments', 'gantry5') }}*/
/*                                                 {%- endif -%}*/
/*                                             {%- endset -%}*/
/* */
/*                                             <span class="g-array-item-comments">*/
/*                                                 <i class="fa fa-comments"></i>{{ comment_count }}*/
/*                                             </span>*/
/*                                         {% endif %}*/
/*                                     </div>*/
/*                                 {% endif %}*/
/* */
/*                                 {% if display.text.type %}*/
/*                                     {% set post_text = display.text.type == 'excerpt' ? post.post_excerpt : post.content %}*/
/*                                     <div class="g-array-item-text">*/
/*                                         {% if display.text.formatting == 'text' %}*/
/*                                             {{ post_text|truncate_text(display.text.limit)|raw }}*/
/*                                         {% else %}*/
/*                                             {{ post_text|truncate_html(display.text.limit)|raw }}*/
/*                                         {% endif %}*/
/*                                     </div>*/
/*                                 {% endif %}*/
/* */
/*                                 {% if display.read_more.enabled %}*/
/*                                     <div class="g-array-item-read-more">*/
/*                                         <a href="{{ post.link }}">*/
/*                                             <button class="button{% if display.read_more.css %} {{ display.read_more.css }}{% endif %}">{{ display.read_more.label|default('Read More...') }}</button>*/
/*                                         </a>*/
/*                                     </div>*/
/*                                 {% endif %}*/
/*                             </div>*/
/*                         </div>*/
/*                     </div>*/
/* */
/*                 {% endfor %}*/
/*             </div>*/
/*         {% endfor %}*/
/*     </div>*/
/* */
/* {% endblock %}*/
/* */
