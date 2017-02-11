<?php

/* @particles/totop.html.twig */
class __TwigTemplate_8afe14710f357f9e7abdfa63ee2dfdb2883e4e2815cf36c98387910c45d61adb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/totop.html.twig", 1);
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
        echo "<div class=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "css", array()), "class", array()));
        echo " g-particle\">
    <div class=\"g-totop\">
        <a href=\"#\" id=\"g-totop\" rel=\"nofollow\">
            ";
        // line 7
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "icon", array())) {
            echo "<i class=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "icon", array()), "html", null, true);
            echo "\"></i>";
        }
        // line 8
        echo "            ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "content", array())) {
            echo $this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "content", array());
        }
        // line 9
        echo "            ";
        if (( !$this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "icon", array()) &&  !$this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "content", array()))) {
            echo "To Top";
        }
        // line 10
        echo "        </a>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@particles/totop.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 10,  49 => 9,  44 => 8,  38 => 7,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends '@nucleus/partials/particle.html.twig' %}*/
/* */
/* {% block particle %}*/
/* <div class="{{ particle.css.class|e }} g-particle">*/
/*     <div class="g-totop">*/
/*         <a href="#" id="g-totop" rel="nofollow">*/
/*             {% if particle.icon %}<i class="{{particle.icon}}"></i>{% endif %}*/
/*             {% if particle.content %}{{particle.content|raw}}{% endif %}*/
/*             {% if not particle.icon and not particle.content %}To Top{% endif %}*/
/*         </a>*/
/*     </div>*/
/* </div>*/
/* {% endblock %}*/
/* */
