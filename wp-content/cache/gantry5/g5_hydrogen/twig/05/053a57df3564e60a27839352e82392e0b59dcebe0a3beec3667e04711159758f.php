<?php

/* @particles/slideshow.html.twig */
class __TwigTemplate_43b524aa2dda01d6b039c9f69b6bd02fef7f19a8717ad0a6ff11472745555c16 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/slideshow.html.twig", 1);
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
        // line 12
        ob_start();
        // line 13
        echo "    {
        autoplay:";
        // line 14
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "autoplay", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "autoplay", array()), "true")) : ("true")));
        echo ",
        autoplayInterval:";
        // line 15
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "autoplayInterval", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "autoplayInterval", array()), 7000)) : (7000)));
        echo ",
        kenburns:";
        // line 16
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "kenburns", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "kenburns", array()), "false")) : ("false")));
        echo ",
        animation:'";
        // line 17
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "animation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "animation", array()), "fade")) : ("fade")));
        echo "',
        duration:";
        // line 18
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "animationDuration", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "animationDuration", array()), 500)) : (500)));
        echo ",
        pauseOnHover:";
        // line 19
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "pauseOnHover", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "pauseOnHover", array()), "true")) : ("true")));
        echo ",
        height:'";
        // line 20
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "height", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "height", array()), "auto")) : ("auto")));
        echo "'
    }
";
        $context["slideshow_settings"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 24
        ob_start();
        // line 25
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 26
            echo "
        ";
            // line 27
            ob_start();
            // line 28
            echo "            ";
            if ($this->getAttribute($context["item"], "image", array())) {
                // line 29
                echo "                <img alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "alt", array()));
                echo "\" src=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('GantryTwig')->urlFunc($this->getAttribute($context["item"], "image", array())), "html", null, true);
                echo "\" ";
                echo $this->env->getExtension('GantryTwig')->imageSize($this->getAttribute($context["item"], "image", array()));
                echo ">
            ";
            }
            // line 31
            echo "            ";
            if ($this->getAttribute($context["item"], "videoiframe", array())) {
                // line 32
                echo "                ";
                echo $this->getAttribute($context["item"], "videoiframe", array());
                echo "
            ";
            }
            // line 34
            echo "        ";
            $context["slide_media"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            echo " 

        ";
            // line 36
            ob_start();
            // line 37
            echo "
            ";
            // line 38
            ob_start();
            // line 39
            echo "                ";
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom")) {
                // line 40
                echo "                    uk-overlay-bottom
                ";
            }
            // line 42
            echo "
                ";
            // line 43
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "left")) {
                // line 44
                echo "                    uk-overlay-left
                ";
            }
            // line 46
            echo "
                ";
            // line 47
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "right")) {
                // line 48
                echo "                    uk-overlay-right
                ";
            }
            // line 50
            echo "
                ";
            // line 51
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top")) {
                // line 52
                echo "                    uk-overlay-top
                ";
            }
            // line 54
            echo "
                ";
            // line 55
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom-left")) {
                // line 56
                echo "                    uk-flex-bottom
                ";
            }
            // line 58
            echo "
                ";
            // line 59
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom-center")) {
                // line 60
                echo "                    uk-flex-bottom uk-flex-center
                ";
            }
            // line 62
            echo "
                ";
            // line 63
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom-right")) {
                // line 64
                echo "                    uk-flex-bottom uk-flex-right
                ";
            }
            // line 66
            echo "
                ";
            // line 67
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "middle-left")) {
                // line 68
                echo "                    uk-flex-middle
                ";
            }
            // line 70
            echo "
                ";
            // line 71
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "middle-center")) {
                // line 72
                echo "                    uk-flex-middle uk-flex-center
                ";
            }
            // line 74
            echo "
                ";
            // line 75
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "middle-right")) {
                // line 76
                echo "                    uk-flex-middle uk-flex-right
                ";
            }
            // line 78
            echo "
                ";
            // line 79
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top-left")) {
                // line 80
                echo "                    uk-flex-top
                ";
            }
            // line 82
            echo "
                ";
            // line 83
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top-center")) {
                // line 84
                echo "                    uk-flex-top uk-flex-center
                ";
            }
            // line 86
            echo "
                ";
            // line 87
            if (((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top-right")) {
                // line 88
                echo "                    uk-flex-top uk-flex-right
                ";
            }
            // line 90
            echo "            ";
            $context["overlay_position"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 91
            echo "
            ";
            // line 92
            ob_start();
            // line 93
            echo "                ";
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "fade")) {
                // line 94
                echo "                    uk-overlay-fade
                ";
            }
            // line 96
            echo "
                ";
            // line 97
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-left")) {
                // line 98
                echo "                    uk-overlay-slide-left
                ";
            }
            // line 100
            echo "
                ";
            // line 101
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-right")) {
                // line 102
                echo "                    uk-overlay-slide-right
                ";
            }
            // line 104
            echo "
                ";
            // line 105
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-top")) {
                // line 106
                echo "                    uk-overlay-slide-top
                ";
            }
            // line 108
            echo "
                ";
            // line 109
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-bottom")) {
                // line 110
                echo "                    uk-overlay-slide-bottom
                ";
            }
            // line 112
            echo "
                ";
            // line 113
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-left-short")) {
                // line 114
                echo "                    uk-overlay-slide-left uk-overlay-left-short
                ";
            }
            // line 116
            echo "
                ";
            // line 117
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-right-short")) {
                // line 118
                echo "                    uk-overlay-slide-right uk-overlay-right-short
                ";
            }
            // line 120
            echo "
                ";
            // line 121
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-top-short")) {
                // line 122
                echo "                    uk-overlay-slide-top uk-overlay-top-short
                ";
            }
            // line 124
            echo "
                ";
            // line 125
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "slide-bottom-short")) {
                // line 126
                echo "                    uk-overlay-slide-bottom uk-overlay-bottom-short
                ";
            }
            // line 128
            echo "
                ";
            // line 129
            if (((($this->getAttribute($context["item"], "overlayanimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayanimation", array()), "fade")) : ("fade")) == "scale")) {
                // line 130
                echo "                    uk-overlay-scale
                ";
            }
            // line 132
            echo "            ";
            $context["slide_overlay_animation"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 133
            echo "
            ";
            // line 134
            if (((($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")) == "style1")) {
                // line 135
                echo "
                ";
                // line 136
                if ((((((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom") || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top")) || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "left")) || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "right"))) {
                    // line 137
                    echo "                     <div class=\"uk-overlay-panel uk-overlay-background ";
                    echo twig_escape_filter($this->env, (isset($context["overlay_position"]) ? $context["overlay_position"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (isset($context["slide_overlay_animation"]) ? $context["slide_overlay_animation"] : null), "html", null, true);
                    echo " ";
                    if ((twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null)))) != "auto")) {
                        echo " uk-width-1-";
                        echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null))));
                    }
                    echo " ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")));
                    echo "\">
                        <div class=\"slideshow-caption\">
                            ";
                    // line 139
                    if ($this->getAttribute($context["item"], "title", array())) {
                        echo "<h3 class=\"g-slideshow-title\">";
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "<a target=\"";
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "target", array()), "_parent")) : ("_parent")));
                            echo "\" href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "link", array()));
                            echo "\">";
                        }
                        echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()));
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "</a>";
                        }
                        echo "</h3>";
                    }
                    // line 140
                    echo "                            ";
                    if ($this->getAttribute($context["item"], "description", array())) {
                        echo "<div class=\"g-slideshow-desc\"> ";
                        echo $this->getAttribute($context["item"], "description", array());
                        echo "</div>";
                    }
                    // line 141
                    echo "                        </div>
                    </div>
                ";
                } else {
                    // line 144
                    echo "                    <div class=\"uk-overlay-panel uk-flex ";
                    echo twig_escape_filter($this->env, (isset($context["overlay_position"]) ? $context["overlay_position"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (isset($context["slide_overlay_animation"]) ? $context["slide_overlay_animation"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")));
                    echo "\">
                        <div class=\"slideshow-caption uk-overlay-background ";
                    // line 145
                    if ((twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null)))) != "auto")) {
                        echo " uk-width-1-";
                        echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null))));
                    }
                    echo "\">
                            ";
                    // line 146
                    if ($this->getAttribute($context["item"], "title", array())) {
                        echo "<h3 class=\"g-slideshow-title\">";
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "<a target=\"";
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "target", array()), "_parent")) : ("_parent")));
                            echo "\" href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "link", array()));
                            echo "\">";
                        }
                        echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()));
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "</a>";
                        }
                        echo "</h3>";
                    }
                    // line 147
                    echo "                            ";
                    if ($this->getAttribute($context["item"], "description", array())) {
                        echo "<div class=\"g-slideshow-desc\"> ";
                        echo $this->getAttribute($context["item"], "description", array());
                        echo "</div>";
                    }
                    // line 148
                    echo "                        </div>
                    </div>
                ";
                }
                // line 151
                echo "
            ";
            }
            // line 153
            echo "
            ";
            // line 154
            if (((($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")) == "style2")) {
                // line 155
                echo "                
                ";
                // line 156
                if ((((((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "bottom") || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "top")) || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "left")) || ((($this->getAttribute($context["item"], "overlayposition", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlayposition", array()), "bottom")) : ("bottom")) == "right"))) {
                    // line 157
                    echo "                     <div class=\"uk-overlay-panel ";
                    echo twig_escape_filter($this->env, (isset($context["overlay_position"]) ? $context["overlay_position"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (isset($context["slide_overlay_animation"]) ? $context["slide_overlay_animation"] : null), "html", null, true);
                    echo " ";
                    if ((twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null)))) != "auto")) {
                        echo " uk-width-1-";
                        echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null))));
                    }
                    echo " ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")));
                    echo "\">
                        <div class=\"slideshow-caption\">
                            ";
                    // line 159
                    if ($this->getAttribute($context["item"], "title", array())) {
                        echo "<h3 class=\"g-slideshow-title\">";
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "<a target=\"";
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "target", array()), "_parent")) : ("_parent")));
                            echo "\" href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "link", array()));
                            echo "\">";
                        }
                        echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()));
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "</a>";
                        }
                        echo "</h3>";
                    }
                    // line 160
                    echo "                            ";
                    if ($this->getAttribute($context["item"], "description", array())) {
                        echo "<div class=\"g-slideshow-desc\"> ";
                        echo $this->getAttribute($context["item"], "description", array());
                        echo "</div>";
                    }
                    // line 161
                    echo "                        </div>
                    </div>
                ";
                } else {
                    // line 164
                    echo "                    <div class=\"uk-overlay-panel uk-flex ";
                    echo twig_escape_filter($this->env, (isset($context["overlay_position"]) ? $context["overlay_position"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (isset($context["slide_overlay_animation"]) ? $context["slide_overlay_animation"] : null), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaystyle", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaystyle", array()), "style1")) : ("style1")));
                    echo "\">
                        <div class=\"slideshow-caption ";
                    // line 165
                    if ((twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null)))) != "auto")) {
                        echo " uk-width-1-";
                        echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "overlaywidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "overlaywidth", array()), (isset($context["auto"]) ? $context["auto"] : null))) : ((isset($context["auto"]) ? $context["auto"] : null))));
                    }
                    echo "\">
                            ";
                    // line 166
                    if ($this->getAttribute($context["item"], "title", array())) {
                        echo "<h3 class=\"g-slideshow-title\">";
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "<a target=\"";
                            echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "target", array()), "_parent")) : ("_parent")));
                            echo "\" href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "link", array()));
                            echo "\">";
                        }
                        echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()));
                        if ($this->getAttribute($context["item"], "link", array())) {
                            echo "</a>";
                        }
                        echo "</h3>";
                    }
                    // line 167
                    echo "                            ";
                    if ($this->getAttribute($context["item"], "description", array())) {
                        echo "<div class=\"g-slideshow-desc\"> ";
                        echo $this->getAttribute($context["item"], "description", array());
                        echo "</div>";
                    }
                    // line 168
                    echo "                        </div>
                    </div>
                ";
                }
                // line 171
                echo "
            ";
            }
            // line 173
            echo "
        ";
            $context["slide_overlay"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 175
            echo "
        <li class=\"g-slideshow-item";
            // line 176
            if ($this->getAttribute($context["item"], "class", array())) {
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "class", array()));
            }
            echo "\">
                ";
            // line 177
            echo twig_escape_filter($this->env, (isset($context["slide_media"]) ? $context["slide_media"] : null), "html", null, true);
            echo "
            ";
            // line 178
            if (($this->getAttribute($context["item"], "title", array()) || $this->getAttribute($context["item"], "description", array()))) {
                // line 179
                echo "                ";
                echo twig_escape_filter($this->env, (isset($context["slide_overlay"]) ? $context["slide_overlay"] : null), "html", null, true);
                echo "
            ";
            }
            // line 181
            echo "        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        $context["slideshow_slides"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 185
    public function block_particle($context, array $blocks = array())
    {
        // line 186
        echo "    
    <div class=\"g-slideshow";
        // line 187
        if ($this->getAttribute($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "css", array()), "class", array())) {
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "css", array()), "class", array()));
        }
        echo "\" ";
        if ($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "extra", array())) {
            echo (isset($context["attr_extra"]) ? $context["attr_extra"] : null);
        }
        echo ">
        <div class=\"uk-slidenav-position";
        // line 188
        if ((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "fullscreen", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "fullscreen", array()), 0)) : (0))) {
            echo " fullscreen";
        }
        echo "\" data-uk-slideshow=\"";
        echo twig_escape_filter($this->env, (isset($context["slideshow_settings"]) ? $context["slideshow_settings"] : null), "html", null, true);
        echo "\">
            <ul class=\"uk-slideshow uk-overlay-active";
        // line 189
        if ((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "fullscreen", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "fullscreen", array()), 0)) : (0))) {
            echo " uk-slideshow-fullscreen";
        }
        echo "\">
                ";
        // line 190
        echo twig_escape_filter($this->env, (isset($context["slideshow_slides"]) ? $context["slideshow_slides"] : null), "html", null, true);
        echo "
            </ul>
            ";
        // line 192
        if ((((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "arrows") || ((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "both"))) {
            echo "<a href=\"\" class=\"uk-slidenav uk-slidenav-previous\" data-uk-slideshow-item=\"previous\"></a>";
        }
        // line 193
        echo "            ";
        if ((((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "arrows") || ((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "both"))) {
            echo "<a href=\"\" class=\"uk-slidenav uk-slidenav-next\" data-uk-slideshow-item=\"next\"></a>";
        }
        // line 194
        echo "            ";
        if ((((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "dots") || ((($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "navigation", array()), "arrows")) : ("arrows")) == "both"))) {
            echo "<ul class=\"uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center\">
                ";
            // line 195
            $context["counter"] = 0;
            // line 196
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["particle"]) ? $context["particle"] : null), "items", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 197
                echo "                    <li data-uk-slideshow-item=\"";
                echo twig_escape_filter($this->env, (isset($context["counter"]) ? $context["counter"] : null), "html", null, true);
                echo "\"><a href=\"\"></a></li>
                    ";
                // line 198
                $context["counter"] = ((isset($context["counter"]) ? $context["counter"] : null) + 1);
                // line 199
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 200
            echo "            </ul>";
        }
        // line 201
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "@particles/slideshow.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  657 => 201,  654 => 200,  648 => 199,  646 => 198,  641 => 197,  636 => 196,  634 => 195,  629 => 194,  624 => 193,  620 => 192,  615 => 190,  609 => 189,  601 => 188,  590 => 187,  587 => 186,  584 => 185,  580 => 1,  572 => 181,  566 => 179,  564 => 178,  560 => 177,  553 => 176,  550 => 175,  546 => 173,  542 => 171,  537 => 168,  530 => 167,  514 => 166,  507 => 165,  498 => 164,  493 => 161,  486 => 160,  470 => 159,  455 => 157,  453 => 156,  450 => 155,  448 => 154,  445 => 153,  441 => 151,  436 => 148,  429 => 147,  413 => 146,  406 => 145,  397 => 144,  392 => 141,  385 => 140,  369 => 139,  354 => 137,  352 => 136,  349 => 135,  347 => 134,  344 => 133,  341 => 132,  337 => 130,  335 => 129,  332 => 128,  328 => 126,  326 => 125,  323 => 124,  319 => 122,  317 => 121,  314 => 120,  310 => 118,  308 => 117,  305 => 116,  301 => 114,  299 => 113,  296 => 112,  292 => 110,  290 => 109,  287 => 108,  283 => 106,  281 => 105,  278 => 104,  274 => 102,  272 => 101,  269 => 100,  265 => 98,  263 => 97,  260 => 96,  256 => 94,  253 => 93,  251 => 92,  248 => 91,  245 => 90,  241 => 88,  239 => 87,  236 => 86,  232 => 84,  230 => 83,  227 => 82,  223 => 80,  221 => 79,  218 => 78,  214 => 76,  212 => 75,  209 => 74,  205 => 72,  203 => 71,  200 => 70,  196 => 68,  194 => 67,  191 => 66,  187 => 64,  185 => 63,  182 => 62,  178 => 60,  176 => 59,  173 => 58,  169 => 56,  167 => 55,  164 => 54,  160 => 52,  158 => 51,  155 => 50,  151 => 48,  149 => 47,  146 => 46,  142 => 44,  140 => 43,  137 => 42,  133 => 40,  130 => 39,  128 => 38,  125 => 37,  123 => 36,  117 => 34,  111 => 32,  108 => 31,  98 => 29,  95 => 28,  93 => 27,  90 => 26,  85 => 25,  83 => 24,  77 => 20,  73 => 19,  69 => 18,  65 => 17,  61 => 16,  57 => 15,  53 => 14,  50 => 13,  48 => 12,  37 => 7,  33 => 6,  29 => 5,  27 => 4,  25 => 3,  11 => 1,);
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
/* {% set slideshow_settings %}*/
/*     {*/
/*         autoplay:{{ particle.autoplay|default("true")|e }},*/
/*         autoplayInterval:{{ particle.autoplayInterval|default(7000)|e }},*/
/*         kenburns:{{ particle.kenburns|default("false")|e }},*/
/*         animation:'{{ particle.animation|default('fade')|e }}',*/
/*         duration:{{ particle.animationDuration|default(500)|e }},*/
/*         pauseOnHover:{{ particle.pauseOnHover|default("true")|e }},*/
/*         height:'{{ particle.height|default('auto')|e }}'*/
/*     }*/
/* {% endset %}*/
/* */
/* {% set slideshow_slides %}*/
/*     {% for item in particle.items %}*/
/* */
/*         {% set slide_media %}*/
/*             {% if item.image %}*/
/*                 <img alt="{{ item.alt|e }}" src="{{ url(item.image) }}" {{ item.image|imagesize|raw }}>*/
/*             {% endif %}*/
/*             {% if item.videoiframe %}*/
/*                 {{ item.videoiframe|raw }}*/
/*             {% endif %}*/
/*         {% endset %} */
/* */
/*         {% set slide_overlay %}*/
/* */
/*             {% set overlay_position %}*/
/*                 {% if item.overlayposition|default('bottom') == 'bottom' %}*/
/*                     uk-overlay-bottom*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'left' %}*/
/*                     uk-overlay-left*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'right' %}*/
/*                     uk-overlay-right*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'top' %}*/
/*                     uk-overlay-top*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'bottom-left' %}*/
/*                     uk-flex-bottom*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'bottom-center' %}*/
/*                     uk-flex-bottom uk-flex-center*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'bottom-right' %}*/
/*                     uk-flex-bottom uk-flex-right*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'middle-left' %}*/
/*                     uk-flex-middle*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'middle-center' %}*/
/*                     uk-flex-middle uk-flex-center*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'middle-right' %}*/
/*                     uk-flex-middle uk-flex-right*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'top-left' %}*/
/*                     uk-flex-top*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'top-center' %}*/
/*                     uk-flex-top uk-flex-center*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayposition|default('bottom') == 'top-right' %}*/
/*                     uk-flex-top uk-flex-right*/
/*                 {% endif %}*/
/*             {% endset %}*/
/* */
/*             {% set slide_overlay_animation %}*/
/*                 {% if item.overlayanimation|default('fade') == 'fade' %}*/
/*                     uk-overlay-fade*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-left' %}*/
/*                     uk-overlay-slide-left*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-right' %}*/
/*                     uk-overlay-slide-right*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-top' %}*/
/*                     uk-overlay-slide-top*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-bottom' %}*/
/*                     uk-overlay-slide-bottom*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-left-short' %}*/
/*                     uk-overlay-slide-left uk-overlay-left-short*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-right-short' %}*/
/*                     uk-overlay-slide-right uk-overlay-right-short*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-top-short' %}*/
/*                     uk-overlay-slide-top uk-overlay-top-short*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'slide-bottom-short' %}*/
/*                     uk-overlay-slide-bottom uk-overlay-bottom-short*/
/*                 {% endif %}*/
/* */
/*                 {% if item.overlayanimation|default('fade') == 'scale' %}*/
/*                     uk-overlay-scale*/
/*                 {% endif %}*/
/*             {% endset %}*/
/* */
/*             {% if item.overlaystyle|default('style1') == 'style1' %}*/
/* */
/*                 {% if (item.overlayposition|default('bottom') == 'bottom') or (item.overlayposition|default('bottom') == 'top') or (item.overlayposition|default('bottom') == 'left') or (item.overlayposition|default('bottom') == 'right') %}*/
/*                      <div class="uk-overlay-panel uk-overlay-background {{ overlay_position }} {{ slide_overlay_animation }} {% if item.overlaywidth|default(auto)|e != 'auto' %} uk-width-1-{{ item.overlaywidth|default(auto)|e }}{% endif %} {{ item.overlaystyle|default("style1")|e }}">*/
/*                         <div class="slideshow-caption">*/
/*                             {% if item.title %}<h3 class="g-slideshow-title">{% if item.link %}<a target="{{ item.target|default('_parent')|e }}" href="{{ item.link|e }}">{% endif %}{{ item.title|e }}{% if item.link %}</a>{% endif %}</h3>{% endif %}*/
/*                             {% if item.description %}<div class="g-slideshow-desc"> {{ item.description|raw }}</div>{% endif %}*/
/*                         </div>*/
/*                     </div>*/
/*                 {% else %}*/
/*                     <div class="uk-overlay-panel uk-flex {{ overlay_position }} {{ slide_overlay_animation }} {{ item.overlaystyle|default("style1")|e }}">*/
/*                         <div class="slideshow-caption uk-overlay-background {% if item.overlaywidth|default(auto)|e != 'auto' %} uk-width-1-{{ item.overlaywidth|default(auto)|e }}{% endif %}">*/
/*                             {% if item.title %}<h3 class="g-slideshow-title">{% if item.link %}<a target="{{ item.target|default('_parent')|e }}" href="{{ item.link|e }}">{% endif %}{{ item.title|e }}{% if item.link %}</a>{% endif %}</h3>{% endif %}*/
/*                             {% if item.description %}<div class="g-slideshow-desc"> {{ item.description|raw }}</div>{% endif %}*/
/*                         </div>*/
/*                     </div>*/
/*                 {% endif %}*/
/* */
/*             {% endif %}*/
/* */
/*             {% if item.overlaystyle|default('style1') == 'style2' %}*/
/*                 */
/*                 {% if (item.overlayposition|default('bottom') == 'bottom') or (item.overlayposition|default('bottom') == 'top') or (item.overlayposition|default('bottom') == 'left') or (item.overlayposition|default('bottom') == 'right') %}*/
/*                      <div class="uk-overlay-panel {{ overlay_position }} {{ slide_overlay_animation }} {% if item.overlaywidth|default(auto)|e != 'auto' %} uk-width-1-{{ item.overlaywidth|default(auto)|e }}{% endif %} {{ item.overlaystyle|default("style1")|e }}">*/
/*                         <div class="slideshow-caption">*/
/*                             {% if item.title %}<h3 class="g-slideshow-title">{% if item.link %}<a target="{{ item.target|default('_parent')|e }}" href="{{ item.link|e }}">{% endif %}{{ item.title|e }}{% if item.link %}</a>{% endif %}</h3>{% endif %}*/
/*                             {% if item.description %}<div class="g-slideshow-desc"> {{ item.description|raw }}</div>{% endif %}*/
/*                         </div>*/
/*                     </div>*/
/*                 {% else %}*/
/*                     <div class="uk-overlay-panel uk-flex {{ overlay_position }} {{ slide_overlay_animation }} {{ item.overlaystyle|default("style1")|e }}">*/
/*                         <div class="slideshow-caption {% if item.overlaywidth|default(auto)|e != 'auto' %} uk-width-1-{{ item.overlaywidth|default(auto)|e }}{% endif %}">*/
/*                             {% if item.title %}<h3 class="g-slideshow-title">{% if item.link %}<a target="{{ item.target|default('_parent')|e }}" href="{{ item.link|e }}">{% endif %}{{ item.title|e }}{% if item.link %}</a>{% endif %}</h3>{% endif %}*/
/*                             {% if item.description %}<div class="g-slideshow-desc"> {{ item.description|raw }}</div>{% endif %}*/
/*                         </div>*/
/*                     </div>*/
/*                 {% endif %}*/
/* */
/*             {% endif %}*/
/* */
/*         {% endset %}*/
/* */
/*         <li class="g-slideshow-item{% if item.class %} {{ item.class|e }}{% endif %}">*/
/*                 {{ slide_media }}*/
/*             {% if item.title or item.description %}*/
/*                 {{ slide_overlay }}*/
/*             {% endif %}*/
/*         </li>*/
/*     {% endfor %}*/
/* {% endset %}*/
/* */
/* {% block particle %}*/
/*     */
/*     <div class="g-slideshow{% if particle.css.class %} {{ particle.css.class|e }}{% endif %}" {% if particle.extra %}{{ attr_extra|raw }}{% endif %}>*/
/*         <div class="uk-slidenav-position{% if particle.fullscreen|default(0) %} fullscreen{% endif %}" data-uk-slideshow="{{ slideshow_settings }}">*/
/*             <ul class="uk-slideshow uk-overlay-active{% if particle.fullscreen|default(0) %} uk-slideshow-fullscreen{% endif %}">*/
/*                 {{ slideshow_slides }}*/
/*             </ul>*/
/*             {% if (particle.navigation|default('arrows') == 'arrows') or (particle.navigation|default('arrows') == 'both') %}<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slideshow-item="previous"></a>{% endif %}*/
/*             {% if (particle.navigation|default('arrows') == 'arrows') or (particle.navigation|default('arrows') == 'both') %}<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slideshow-item="next"></a>{% endif %}*/
/*             {% if (particle.navigation|default('arrows') == 'dots') or (particle.navigation|default('arrows') == 'both') %}<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">*/
/*                 {% set counter = 0 %}*/
/*                 {% for item in particle.items %}*/
/*                     <li data-uk-slideshow-item="{{ counter }}"><a href=""></a></li>*/
/*                     {% set counter = counter + 1 %}*/
/*                 {% endfor %}*/
/*             </ul>{% endif %}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
