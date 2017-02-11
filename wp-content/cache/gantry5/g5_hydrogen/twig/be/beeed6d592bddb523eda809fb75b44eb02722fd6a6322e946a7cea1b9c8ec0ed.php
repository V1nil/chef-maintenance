<?php

/* @nucleus/page_head.html.twig */
class __TwigTemplate_c3d65800e79a2e30a6f1cb4a9681508d7ff3b7879173ae8a92f7702f5437632c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head_stylesheets' => array($this, 'block_head_stylesheets'),
            'head_platform' => array($this, 'block_head_platform'),
            'head_overrides' => array($this, 'block_head_overrides'),
            'head_meta' => array($this, 'block_head_meta'),
            'head_title' => array($this, 'block_head_title'),
            'head_application' => array($this, 'block_head_application'),
            'head_ie_stylesheets' => array($this, 'block_head_ie_stylesheets'),
            'head' => array($this, 'block_head'),
            'head_custom' => array($this, 'block_head_custom'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $assetFunction = $this->env->getFunction('parse_assets')->getCallable();
        $assetVariables = array("priority" => 10);
        if ($assetVariables && !is_array($assetVariables)) {
            throw new UnexpectedValueException('{% scripts with x %}: x is not an array');
        }
        $location = "head";
        if ($location && !is_string($location)) {
            throw new UnexpectedValueException('{% scripts in x %}: x is not a string');
        }
        $priority = isset($assetVariables['priority']) ? $assetVariables['priority'] : 0;
        ob_start();
        // line 2
        echo "    ";
        $this->displayBlock('head_stylesheets', $context, $blocks);
        // line 12
        $this->displayBlock('head_platform', $context, $blocks);
        // line 13
        echo "
    ";
        // line 14
        $this->displayBlock('head_overrides', $context, $blocks);
        $content = ob_get_clean();
        echo $assetFunction($content, $location, $priority);
        // line 23
        ob_start();
        // line 24
        echo "    ";
        if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "atoms", array())) {
            // line 25
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "atoms", array()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["atom"]) {
                // line 26
                echo "            ";
                try {                    // line 27
                    echo "                ";
                    $this->loadTemplate((("@particles/" . $this->getAttribute($context["atom"], "type", array())) . ".html.twig"), "@nucleus/page_head.html.twig", 27)->display(array_merge($context, array("particle" => $this->getAttribute($context["atom"], "attributes", array()))));
                    // line 28
                    echo "            ";
                } catch (\Exception $e) {
                    if ($context['gantry']->debug()) throw $e;
                    $context['e'] = $e;
                    // line 29
                    echo "                ";
                    // line 30
                    echo "            ";
                }
                // line 31
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['atom'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 32
            echo "    ";
        }
        // line 33
        echo "
    ";
        // line 34
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array())) {
            // line 35
            echo "        ";
            $this->loadTemplate("@particles/assets.html.twig", "@nucleus/page_head.html.twig", 35)->display(array_merge($context, array("particle" => twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), array("enabled" => 1)))));
            // line 36
            echo "    ";
        }
        $context["atoms"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 39
        echo "<head>
    ";
        // line 40
        $this->displayBlock('head_meta', $context, $blocks);
        // line 61
        $this->displayBlock('head_title', $context, $blocks);
        // line 65
        echo "
    ";
        // line 66
        $this->displayBlock('head_application', $context, $blocks);
        // line 70
        echo "
    ";
        // line 71
        $this->displayBlock('head_ie_stylesheets', $context, $blocks);
        // line 79
        $this->displayBlock('head', $context, $blocks);
        // line 80
        echo "    ";
        $this->displayBlock('head_custom', $context, $blocks);
        // line 85
        echo "</head>
";
    }

    // line 2
    public function block_head_stylesheets($context, array $blocks = array())
    {
        // line 3
        echo "<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-assets://css/font-awesome.min.css"), "html", null, true);
        echo "\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-engine://css-compiled/nucleus.css"), "html", null, true);
        echo "\" type=\"text/css\"/>
        ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array(), "any", false, true), "configuration", array(), "any", false, true), "css", array(), "any", false, true), "persistent", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array(), "any", false, true), "configuration", array(), "any", false, true), "css", array(), "any", false, true), "persistent", array()), $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "configuration", array()), "css", array()), "files", array()))) : ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "configuration", array()), "css", array()), "files", array()))));
        foreach ($context['_seq'] as $context["_key"] => $context["css"]) {
            // line 6
            $context["url"] = $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "css", array(0 => $context["css"]), "method"));
            if ((isset($context["url"]) ? $context["url"] : null)) {
                // line 7
                echo "            <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "css", array(0 => $context["css"]), "method")), "html", null, true);
                echo "\" type=\"text/css\"/>
        ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['css'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "    ";
    }

    // line 12
    public function block_head_platform($context, array $blocks = array())
    {
    }

    // line 14
    public function block_head_overrides($context, array $blocks = array())
    {
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "configuration", array()), "css", array()), "overrides", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["css"]) {
            // line 16
            $context["url"] = $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "css", array(0 => $context["css"]), "method"));
            if ((isset($context["url"]) ? $context["url"] : null)) {
                // line 17
                echo "            <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "theme", array()), "css", array(0 => $context["css"]), "method")), "html", null, true);
                echo "\" type=\"text/css\"/>
        ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['css'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "    ";
    }

    // line 40
    public function block_head_meta($context, array $blocks = array())
    {
        // line 41
        echo "        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
        ";
        // line 43
        if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "meta", array())) {
            // line 44
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "meta", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["attributes"]) {
                // line 45
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["attributes"]);
                foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                    // line 46
                    echo "                    <meta name=\"";
                    echo twig_escape_filter($this->env, $context["key"]);
                    echo "\" property=\"";
                    echo twig_escape_filter($this->env, $context["key"]);
                    echo "\" content=\"";
                    echo twig_escape_filter($this->env, $context["value"]);
                    echo "\" />
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attributes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 51
        if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), "favicon", array())) {
            // line 52
            echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), "favicon", array())), "html", null, true);
            echo "\" />
        ";
        }
        // line 54
        echo "
        ";
        // line 55
        if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), "touchicon", array())) {
            // line 56
            echo "        <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), "touchicon", array())), "html", null, true);
            echo "\">
        <link rel=\"icon\" sizes=\"192x192\" href=\"";
            // line 57
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "assets", array()), "touchicon", array())), "html", null, true);
            echo "\">
        ";
        }
        // line 59
        echo "    ";
    }

    // line 61
    public function block_head_title($context, array $blocks = array())
    {
        // line 62
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <title>Title</title>";
    }

    // line 66
    public function block_head_application($context, array $blocks = array())
    {
        // line 67
        echo twig_join_filter($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "styles", array(0 => "head"), "method"), "
");
        echo "
        ";
        // line 68
        echo twig_join_filter($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "scripts", array(0 => "head"), "method"), "
");
    }

    // line 71
    public function block_head_ie_stylesheets($context, array $blocks = array())
    {
        // line 72
        echo "<!--[if (gte IE 8)&(lte IE 9)]>
        <script type=\"text/javascript\" src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-assets://js/html5shiv-printshiv.min.js"), "html", null, true);
        echo "\"></script>
        <link rel=\"stylesheet\" href=\"";
        // line 74
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-engine://css/nucleus-ie9.css"), "html", null, true);
        echo "\" type=\"text/css\"/>
        <script type=\"text/javascript\" src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc("gantry-assets://js/matchmedia.polyfill.js"), "html", null, true);
        echo "\"></script>
        <![endif]-->
    ";
    }

    // line 79
    public function block_head($context, array $blocks = array())
    {
    }

    // line 80
    public function block_head_custom($context, array $blocks = array())
    {
        // line 81
        echo "        ";
        if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "head_bottom", array())) {
            // line 82
            echo "        ";
            echo $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gantry"]) ? $context["gantry"] : null), "config", array()), "page", array()), "head", array()), "head_bottom", array());
            echo "
        ";
        }
        // line 84
        echo "    ";
    }

    public function getTemplateName()
    {
        return "@nucleus/page_head.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  329 => 84,  323 => 82,  320 => 81,  317 => 80,  312 => 79,  305 => 75,  301 => 74,  297 => 73,  294 => 72,  291 => 71,  286 => 68,  281 => 67,  278 => 66,  273 => 62,  270 => 61,  266 => 59,  261 => 57,  256 => 56,  254 => 55,  251 => 54,  245 => 52,  243 => 51,  225 => 46,  221 => 45,  217 => 44,  215 => 43,  211 => 41,  208 => 40,  204 => 20,  194 => 17,  191 => 16,  187 => 15,  184 => 14,  179 => 12,  175 => 10,  165 => 7,  162 => 6,  158 => 5,  154 => 4,  149 => 3,  146 => 2,  141 => 85,  138 => 80,  136 => 79,  134 => 71,  131 => 70,  129 => 66,  126 => 65,  124 => 61,  122 => 40,  119 => 39,  115 => 36,  112 => 35,  110 => 34,  107 => 33,  104 => 32,  90 => 31,  87 => 30,  85 => 29,  80 => 28,  77 => 27,  75 => 26,  57 => 25,  54 => 24,  52 => 23,  48 => 14,  45 => 13,  43 => 12,  40 => 2,  28 => 1,);
    }
}
/* {% assets with { priority: 10 } %}*/
/*     {% block head_stylesheets -%}*/
/*         <link rel="stylesheet" href="{{ url('gantry-assets://css/font-awesome.min.css') }}" type="text/css"/>*/
/*         <link rel="stylesheet" href="{{ url('gantry-engine://css-compiled/nucleus.css') }}" type="text/css"/>*/
/*         {% for css in gantry.theme.configuration.css.persistent|default(gantry.theme.configuration.css.files) %}*/
/*             {%- set url = url(gantry.theme.css(css)) %}{% if url %}*/
/*             <link rel="stylesheet" href="{{ url(gantry.theme.css(css)) }}" type="text/css"/>*/
/*         {% endif %}*/
/*         {%- endfor %}*/
/*     {% endblock -%}*/
/* */
/*     {% block head_platform %}{% endblock %}*/
/* */
/*     {% block head_overrides -%}*/
/*         {% for css in gantry.theme.configuration.css.overrides %}*/
/*             {%- set url = url(gantry.theme.css(css)) %}{% if url %}*/
/*             <link rel="stylesheet" href="{{ url(gantry.theme.css(css)) }}" type="text/css"/>*/
/*         {% endif %}*/
/*         {%- endfor %}*/
/*     {% endblock -%}*/
/* {% endassets -%}*/
/* */
/* {%- set atoms %}*/
/*     {% if gantry.config.page.head.atoms %}*/
/*         {% for atom in gantry.config.page.head.atoms %}*/
/*             {% try %}*/
/*                 {% include '@particles/' ~ atom.type ~ '.html.twig' with { particle: atom.attributes } %}*/
/*             {% catch %}*/
/*                 {# TODO: Add message if atom is missing. #}*/
/*             {% endtry %}*/
/*         {% endfor %}*/
/*     {% endif %}*/
/* */
/*     {% if gantry.config.page.assets %}*/
/*         {% include '@particles/assets.html.twig' with { particle: gantry.config.page.assets|merge({'enabled': 1 }) } %}*/
/*     {% endif %}*/
/* {% endset -%}*/
/* */
/* <head>*/
/*     {% block head_meta %}*/
/*         <meta name="viewport" content="width=device-width, initial-scale=1.0">*/
/*         <meta http-equiv="X-UA-Compatible" content="IE=edge" />*/
/*         {% if gantry.config.page.head.meta -%}*/
/*             {% for attributes in gantry.config.page.head.meta -%}*/
/*                 {%- for key, value in attributes %}*/
/*                     <meta name="{{ key|e }}" property="{{ key|e }}" content="{{ value|e }}" />*/
/*                 {% endfor -%}*/
/*             {%- endfor -%}*/
/*         {%- endif -%}*/
/* */
/*         {% if gantry.config.page.assets.favicon %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ url(gantry.config.page.assets.favicon) }}" />*/
/*         {% endif %}*/
/* */
/*         {% if gantry.config.page.assets.touchicon %}*/
/*         <link rel="apple-touch-icon" sizes="180x180" href="{{ url(gantry.config.page.assets.touchicon) }}">*/
/*         <link rel="icon" sizes="192x192" href="{{ url(gantry.config.page.assets.touchicon) }}">*/
/*         {% endif %}*/
/*     {% endblock %}*/
/* */
/*     {%- block head_title -%}*/
/*         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />*/
/*         <title>Title</title>*/
/*     {%- endblock %}*/
/* */
/*     {% block head_application -%}*/
/*         {{ gantry.styles('head')|join("\n")|raw }}*/
/*         {{ gantry.scripts('head')|join("\n")|raw }}*/
/*     {%- endblock %}*/
/* */
/*     {% block head_ie_stylesheets -%}*/
/*         <!--[if (gte IE 8)&(lte IE 9)]>*/
/*         <script type="text/javascript" src="{{ url('gantry-assets://js/html5shiv-printshiv.min.js') }}"></script>*/
/*         <link rel="stylesheet" href="{{ url('gantry-engine://css/nucleus-ie9.css') }}" type="text/css"/>*/
/*         <script type="text/javascript" src="{{ url('gantry-assets://js/matchmedia.polyfill.js') }}"></script>*/
/*         <![endif]-->*/
/*     {% endblock -%}*/
/* */
/*     {% block head %}{% endblock %}*/
/*     {% block head_custom %}*/
/*         {% if gantry.config.page.head.head_bottom %}*/
/*         {{ gantry.config.page.head.head_bottom|raw }}*/
/*         {% endif %}*/
/*     {% endblock %}*/
/* </head>*/
/* */
