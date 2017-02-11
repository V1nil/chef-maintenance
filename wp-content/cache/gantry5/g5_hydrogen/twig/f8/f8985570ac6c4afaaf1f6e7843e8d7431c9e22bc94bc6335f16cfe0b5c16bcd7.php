<?php

/* partials/messages.html.twig */
class __TwigTemplate_d826ce8b2af53ca0127e263d85ae6e644e95b9c8d3f8e662ff20dd841f89c8be extends Twig_Template
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
        echo "<div id=\"system-message-container\">
    <div id=\"system-message\">
        ";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["messages"]) ? $context["messages"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 4
            echo "        <div class=\"alert alert-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["message"], "type", array()), "html", null, true);
            echo "\">
            <div>
                <p>";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context["message"], "message", array()), "html", null, true);
            echo "</p>
            </div>
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "partials/messages.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 10,  33 => 6,  27 => 4,  23 => 3,  19 => 1,);
    }
}
/* <div id="system-message-container">*/
/*     <div id="system-message">*/
/*         {% for message in messages %}*/
/*         <div class="alert alert-{{ message.type }}">*/
/*             <div>*/
/*                 <p>{{ message.message }}</p>*/
/*             </div>*/
/*         </div>*/
/*         {% endfor %}*/
/*     </div>*/
/* </div>*/
