<?php

/* @particles/sample.html.twig */
class __TwigTemplate_39ead7b140432dfb6fb48e598bd52d3ce336fc1aab5ea543b7727b72bafda14e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/sample.html.twig", 1);
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "\t<div class=\"sample-content\">
\t\t<div class=\"g-grid\">
\t\t\t<div class=\"g-block\">
\t\t\t\t<div class=\"g-content\">
\t\t\t\t\t";
        // line 8
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "image", array())) {
            echo "<img src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "image", array())), "html", null, true);
            echo "\" class=\"logo-large\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "headline", array()));
            echo "\" />";
        }
        // line 9
        echo "\t\t\t\t\t";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "headline", array())) {
            echo "<h1>";
            echo $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "headline", array());
            echo "</h1>";
        }
        // line 10
        echo "\t\t\t\t\t";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "description", array())) {
            echo "<div class=\"sample-description\">";
            echo $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "description", array());
            echo "</div>";
        }
        // line 11
        echo "\t\t\t\t\t";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "linktext", array())) {
            echo "<p><a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "link", array()));
            echo "\" class=\"button\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "linktext", array()));
            echo "</a></p>";
        }
        // line 12
        echo "\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"g-grid\">
\t\t\t";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "samples", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["sample"]) {
            // line 17
            echo "\t\t\t\t<div ";
            if ($this->getAttribute($context["sample"], "id", array())) {
                echo "id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["sample"], "id", array()));
                echo "\"";
            }
            // line 18
            echo "\t\t\t\t\t class=\"g-block ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["sample"], "class", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["sample"], "variations", array()), "html", null, true);
            echo "\">
\t\t\t\t\t<div class=\"g-content\">
\t\t\t\t\t\t<i class=\"";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute($context["sample"], "icon", array()), "html", null, true);
            echo " sample-icons\"></i>
\t\t\t\t\t\t<h4>";
            // line 21
            echo $this->getAttribute($context["sample"], "title", array());
            echo "</h4>
\t\t\t\t\t\t";
            // line 22
            echo $this->getAttribute($context["sample"], "subtitle", array());
            echo "
\t\t\t\t\t\t";
            // line 23
            echo $this->getAttribute($context["sample"], "description", array());
            echo "
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sample'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "\t\t</div>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "@particles/sample.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 27,  105 => 23,  101 => 22,  97 => 21,  93 => 20,  85 => 18,  78 => 17,  74 => 16,  68 => 12,  59 => 11,  52 => 10,  45 => 9,  37 => 8,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block particle %}*/
/* 	<div class="sample-content">*/
/* 		<div class="g-grid">*/
/* 			<div class="g-block">*/
/* 				<div class="g-content">*/
/* 					{% if particle.image %}<img src="{{ url(particle.image) }}" class="logo-large" alt="{{ particle.headline|e }}" />{% endif %}*/
/* 					{% if particle.headline %}<h1>{{ particle.headline|raw }}</h1>{% endif %}*/
/* 					{% if particle.description %}<div class="sample-description">{{ particle.description|raw }}</div>{% endif %}*/
/* 					{% if particle.linktext %}<p><a href="{{ particle.link|e }}" class="button">{{ particle.linktext|e }}</a></p>{% endif %}*/
/* 				</div>*/
/* 			</div>*/
/* 		</div>*/
/* 		<div class="g-grid">*/
/* 			{% for sample in particle.samples %}*/
/* 				<div {% if sample.id %}id="{{ sample.id|e }}"{% endif %}*/
/* 					 class="g-block {{ sample.class }} {{ sample.variations }}">*/
/* 					<div class="g-content">*/
/* 						<i class="{{ sample.icon }} sample-icons"></i>*/
/* 						<h4>{{ sample.title|raw }}</h4>*/
/* 						{{ sample.subtitle|raw }}*/
/* 						{{ sample.description|raw }}*/
/* 					</div>*/
/* 				</div>*/
/* 			{% endfor %}*/
/* 		</div>*/
/* 	</div>*/
/* {% endblock %}*/
