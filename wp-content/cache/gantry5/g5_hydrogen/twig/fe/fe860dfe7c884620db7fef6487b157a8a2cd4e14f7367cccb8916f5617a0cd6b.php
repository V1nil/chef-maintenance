<?php

/* partials/comments.html.twig */
class __TwigTemplate_1a5707bd1a60fb8ae26043c0a48d6c09b903ff4f0ab2fbec9aec861f9bae18f4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'comments' => array($this, 'block_comments'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["twigTemplate"] = "comments.html.twig";
        // line 2
        echo "
";
        // line 3
        if ((call_user_func_array($this->env->getFunction('function')->getCallable(), array("get_option", "thread_comments")) == "1")) {
            // line 4
            echo "    ";
            $assetFunction = $this->env->getFunction('parse_assets')->getCallable();
            $assetVariables = array();
            if ($assetVariables && !is_array($assetVariables)) {
                throw new UnexpectedValueException('{% scripts with x %}: x is not an array');
            }
            $location = "footer";
            if ($location && !is_string($location)) {
                throw new UnexpectedValueException('{% scripts in x %}: x is not a string');
            }
            $priority = isset($assetVariables['priority']) ? $assetVariables['priority'] : 0;
            ob_start();
            // line 5
            echo "        <script type=\"text/javascript\" src=\"";
            echo $this->env->getExtension('GantryTwig')->urlFunc("wp-includes://js/comment-reply.min.js");
            echo "\"></script>
    ";
            $content = ob_get_clean();
            echo $assetFunction($content, $location, $priority);
        }
        // line 8
        echo "
";
        // line 9
        $this->displayBlock('comments', $context, $blocks);
    }

    public function block_comments($context, array $blocks = array())
    {
        // line 10
        echo "
    ";
        // line 12
        echo "    <section id=\"comments\" class=\"comments-area\">

        ";
        // line 14
        if ($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "comments", array())) {
            // line 15
            echo "            <div id=\"responses\">
                <h3>";
            // line 16
            echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Comments", "g5_hydrogen"));
            echo "</h3>

                <ol class=\"commentlist\">
                    ";
            // line 19
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("wp_list_comments", array("style" => "ol", "type" => "comment", "callback" => array(0 => "G5ThemeHelper", 1 => "comments"))));
            echo "
                </ol>

                <footer>
                    <nav id=\"comments-nav\">
                        <div class=\"comments-previous\">";
            // line 24
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("previous_comments_link", ("<i class=\"fa fa-chevron-left fa-fw\"></i> " . call_user_func_array($this->env->getFunction('__')->getCallable(), array("Older comments", "g5_hydrogen")))));
            echo "</div>
                        <div class=\"comments-next\">";
            // line 25
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("next_comments_link", (call_user_func_array($this->env->getFunction('__')->getCallable(), array("Newer comments", "g5_hydrogen")) . " <i class=\"fa fa-chevron-right fa-fw\"></i>")));
            echo "</div>
                    </nav>
                </footer>
            </div>
        ";
        }
        // line 30
        echo "
        ";
        // line 31
        if (($this->getAttribute((isset($context["post"]) ? $context["post"] : null), "comment_status", array()) == "open")) {
            // line 32
            echo "
            ";
            // line 33
            call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_before"));
            // line 34
            echo "
            <div id=\"respond\">
                <h3>";
            // line 36
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("comment_form_title", call_user_func_array($this->env->getFunction('__')->getCallable(), array("Leave a Reply", "g5_hydrogen")), call_user_func_array($this->env->getFunction('__')->getCallable(), array("Leave a Reply to %s", "g5_hydrogen"))));
            echo "</h3>

                <p class=\"cancel-comment-reply\">";
            // line 38
            echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("cancel_comment_reply_link"));
            echo "</p>

                ";
            // line 40
            if (($this->getAttribute((isset($context["site"]) ? $context["site"] : null), "comment_registration", array()) &&  !(isset($context["is_user_logged_in"]) ? $context["is_user_logged_in"] : null))) {
                // line 41
                echo "
                    <div class=\"notice\">
                        <p class=\"alert-info\">";
                // line 43
                echo sprintf(call_user_func_array($this->env->getFunction('__')->getCallable(), array("You must be <a href=\"%s\">logged in</a> to post a comment.", "g5_hydrogen")), call_user_func_array($this->env->getFunction('function')->getCallable(), array("wp_login_url", $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "link", array()))));
                echo "</p>
                    </div>

                    ";
                // line 46
                call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_must_log_in_after"));
                // line 47
                echo "
                ";
            } else {
                // line 49
                echo "
                    ";
                // line 50
                $context["req"] = call_user_func_array($this->env->getFunction('function')->getCallable(), array("get_option", "require_name_email"));
                // line 51
                echo "
                    <form action=\"";
                // line 52
                echo $this->getAttribute((isset($context["site"]) ? $context["site"] : null), "url", array());
                echo "/wp-comments-post.php\" method=\"post\" id=\"commentform\">

                        ";
                // line 54
                call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_top"));
                // line 55
                echo "
                        ";
                // line 56
                if ((isset($context["is_user_logged_in"]) ? $context["is_user_logged_in"] : null)) {
                    // line 57
                    echo "
                            <p>";
                    // line 58
                    echo sprintf(call_user_func_array($this->env->getFunction('__')->getCallable(), array("Logged in as <a href=\"%s/wp-admin/profile.php\">%s</a>.", "g5_hydrogen")), $this->getAttribute((isset($context["site"]) ? $context["site"] : null), "url", array()), $this->getAttribute((isset($context["current_user"]) ? $context["current_user"] : null), "display_name", array()));
                    echo " <a href=\"";
                    echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("wp_logout_url", $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "link", array())));
                    echo "\" title=\"";
                    echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Log out of this account", "g5_hydrogen"));
                    echo "\">";
                    echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Log out &raquo;", "g5_hydrogen"));
                    echo "</a></p>

                            ";
                    // line 60
                    call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_logged_in_after", "current_user", "current_user.display_name"));
                    // line 61
                    echo "
                        ";
                } else {
                    // line 63
                    echo "
                            ";
                    // line 64
                    call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_before_fields"));
                    // line 65
                    echo "
                            <p>
                                <input type=\"text\" class=\"inputbox respond-author\" name=\"author\" id=\"author\" placeholder=\"";
                    // line 67
                    echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Name", "g5_hydrogen"));
                    echo " ";
                    echo (((isset($context["req"]) ? $context["req"] : null)) ? (call_user_func_array($this->env->getFunction('__')->getCallable(), array("(required)", "g5_hydrogen"))) : (""));
                    echo "\" value=\"";
                    echo twig_escape_filter($this->env, (isset($context["comment_author"]) ? $context["comment_author"] : null));
                    echo "\" size=\"40\" tabindex=\"1\" aria-required='true' />
                            </p>
                            <p>
                                <input type=\"text\" class=\"inputbox respond-email\" name=\"email\" id=\"email\" placeholder=\"";
                    // line 70
                    echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Email", "g5_hydrogen"));
                    echo " ";
                    echo (((isset($context["req"]) ? $context["req"] : null)) ? (call_user_func_array($this->env->getFunction('__')->getCallable(), array("(required)", "g5_hydrogen"))) : (""));
                    echo "\" value=\"";
                    echo twig_escape_filter($this->env, (isset($context["comment_author_email"]) ? $context["comment_author_email"] : null));
                    echo "\" size=\"40\" tabindex=\"2\" aria-required='true' />
                            </p>
                            <p>
                                <input type=\"text\" class=\"inputbox respond-website\" name=\"url\" id=\"url\" placeholder=\"";
                    // line 73
                    echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Website", "g5_hydrogen"));
                    echo "\" value=\"";
                    echo twig_escape_filter($this->env, (isset($context["comment_author_url"]) ? $context["comment_author_url"] : null));
                    echo "\" size=\"40\" tabindex=\"3\">
                            </p>

                            ";
                    // line 76
                    call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_after_fields"));
                    // line 77
                    echo "
                        ";
                }
                // line 79
                echo "
                        <p>
                            <textarea  class=\"inputbox respond-textarea\" name=\"comment\" id=\"comment\" placeholder=\"";
                // line 81
                echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("Your comment goes here.", "g5_hydrogen"));
                echo "\" tabindex=\"4\"></textarea>
                        </p>

                        <p id=\"allowed_tags\" class=\"small\"><strong>XHTML:</strong> ";
                // line 84
                echo call_user_func_array($this->env->getFunction('__')->getCallable(), array("You can use these tags:", "g5_hydrogen"));
                echo " <code>";
                echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("allowed_tags"));
                echo "</code></p>
                        <p><input name=\"submit\" class=\"button\" type=\"submit\" id=\"submit\" tabindex=\"5\" value=\"";
                // line 85
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('__')->getCallable(), array("Submit Comment", "g5_hydrogen")));
                echo "\"></p>

                        ";
                // line 87
                echo call_user_func_array($this->env->getFunction('function')->getCallable(), array("comment_id_fields"));
                echo "
                        ";
                // line 88
                call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form", $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "id", array())));
                // line 89
                echo "                    </form>

                ";
            }
            // line 92
            echo "            </div>

            ";
            // line 94
            call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_after"));
            // line 95
            echo "
        ";
        } else {
            // line 97
            echo "
            ";
            // line 98
            call_user_func_array($this->env->getFunction('action')->getCallable(), array($context, "comment_form_comments_closed"));
            // line 99
            echo "
        ";
        }
        // line 101
        echo "
    </section>
    ";
        // line 104
        echo "
";
    }

    public function getTemplateName()
    {
        return "partials/comments.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  275 => 104,  271 => 101,  267 => 99,  265 => 98,  262 => 97,  258 => 95,  256 => 94,  252 => 92,  247 => 89,  245 => 88,  241 => 87,  236 => 85,  230 => 84,  224 => 81,  220 => 79,  216 => 77,  214 => 76,  206 => 73,  196 => 70,  186 => 67,  182 => 65,  180 => 64,  177 => 63,  173 => 61,  171 => 60,  160 => 58,  157 => 57,  155 => 56,  152 => 55,  150 => 54,  145 => 52,  142 => 51,  140 => 50,  137 => 49,  133 => 47,  131 => 46,  125 => 43,  121 => 41,  119 => 40,  114 => 38,  109 => 36,  105 => 34,  103 => 33,  100 => 32,  98 => 31,  95 => 30,  87 => 25,  83 => 24,  75 => 19,  69 => 16,  66 => 15,  64 => 14,  60 => 12,  57 => 10,  51 => 9,  48 => 8,  40 => 5,  27 => 4,  25 => 3,  22 => 2,  20 => 1,);
    }
}
/* {% set twigTemplate = 'comments.html.twig' %}*/
/* */
/* {% if function('get_option', 'thread_comments') == '1' %}*/
/*     {% scripts in 'footer' %}*/
/*         <script type="text/javascript" src="{{ url('wp-includes://js/comment-reply.min.js') }}"></script>*/
/*     {% endscripts %}*/
/* {% endif %}*/
/* */
/* {% block comments %}*/
/* */
/*     {# Begin Comments #}*/
/*     <section id="comments" class="comments-area">*/
/* */
/*         {% if post.comments %}*/
/*             <div id="responses">*/
/*                 <h3>{{ __('Comments', 'g5_hydrogen') }}</h3>*/
/* */
/*                 <ol class="commentlist">*/
/*                     {{ function('wp_list_comments', {style: 'ol', type: 'comment', callback: ['G5ThemeHelper', 'comments']}) }}*/
/*                 </ol>*/
/* */
/*                 <footer>*/
/*                     <nav id="comments-nav">*/
/*                         <div class="comments-previous">{{ function('previous_comments_link', '<i class="fa fa-chevron-left fa-fw"></i> ' ~ __( 'Older comments', 'g5_hydrogen')) }}</div>*/
/*                         <div class="comments-next">{{ function('next_comments_link', __( 'Newer comments', 'g5_hydrogen') ~ ' <i class="fa fa-chevron-right fa-fw"></i>') }}</div>*/
/*                     </nav>*/
/*                 </footer>*/
/*             </div>*/
/*         {% endif %}*/
/* */
/*         {% if post.comment_status == 'open' %}*/
/* */
/*             {% do action('comment_form_before') %}*/
/* */
/*             <div id="respond">*/
/*                 <h3>{{ function('comment_form_title', __('Leave a Reply', 'g5_hydrogen'), __('Leave a Reply to %s', 'g5_hydrogen')) }}</h3>*/
/* */
/*                 <p class="cancel-comment-reply">{{ function('cancel_comment_reply_link') }}</p>*/
/* */
/*                 {% if site.comment_registration and not is_user_logged_in %}*/
/* */
/*                     <div class="notice">*/
/*                         <p class="alert-info">{{ __('You must be <a href="%s">logged in</a> to post a comment.', 'g5_hydrogen')|format(function('wp_login_url', post.link)) }}</p>*/
/*                     </div>*/
/* */
/*                     {% do action('comment_form_must_log_in_after') %}*/
/* */
/*                 {% else %}*/
/* */
/*                     {% set req = function('get_option', 'require_name_email') %}*/
/* */
/*                     <form action="{{ site.url }}/wp-comments-post.php" method="post" id="commentform">*/
/* */
/*                         {% do action('comment_form_top') %}*/
/* */
/*                         {% if is_user_logged_in %}*/
/* */
/*                             <p>{{ __('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'g5_hydrogen')|format(site.url, current_user.display_name) }} <a href="{{ function('wp_logout_url', post.link) }}" title="{{ __('Log out of this account', 'g5_hydrogen') }}">{{ __('Log out &raquo;', 'g5_hydrogen') }}</a></p>*/
/* */
/*                             {% do action('comment_form_logged_in_after', 'current_user', 'current_user.display_name') %}*/
/* */
/*                         {% else %}*/
/* */
/*                             {% do action('comment_form_before_fields') %}*/
/* */
/*                             <p>*/
/*                                 <input type="text" class="inputbox respond-author" name="author" id="author" placeholder="{{ __('Name', 'g5_hydrogen') }} {{ req ? __('(required)', 'g5_hydrogen') : '' }}" value="{{ comment_author|e }}" size="40" tabindex="1" aria-required='true' />*/
/*                             </p>*/
/*                             <p>*/
/*                                 <input type="text" class="inputbox respond-email" name="email" id="email" placeholder="{{ __('Email', 'g5_hydrogen') }} {{ req ? __('(required)', 'g5_hydrogen') : '' }}" value="{{ comment_author_email|e }}" size="40" tabindex="2" aria-required='true' />*/
/*                             </p>*/
/*                             <p>*/
/*                                 <input type="text" class="inputbox respond-website" name="url" id="url" placeholder="{{ __( 'Website', 'g5_hydrogen') }}" value="{{ comment_author_url|e }}" size="40" tabindex="3">*/
/*                             </p>*/
/* */
/*                             {% do action('comment_form_after_fields') %}*/
/* */
/*                         {% endif %}*/
/* */
/*                         <p>*/
/*                             <textarea  class="inputbox respond-textarea" name="comment" id="comment" placeholder="{{ __( 'Your comment goes here.', 'g5_hydrogen') }}" tabindex="4"></textarea>*/
/*                         </p>*/
/* */
/*                         <p id="allowed_tags" class="small"><strong>XHTML:</strong> {{ __('You can use these tags:', 'g5_hydrogen') }} <code>{{ function('allowed_tags') }}</code></p>*/
/*                         <p><input name="submit" class="button" type="submit" id="submit" tabindex="5" value="{{ __('Submit Comment', 'g5_hydrogen')|e }}"></p>*/
/* */
/*                         {{ function('comment_id_fields') }}*/
/*                         {% do action('comment_form', post.id) %}*/
/*                     </form>*/
/* */
/*                 {% endif %}*/
/*             </div>*/
/* */
/*             {% do action('comment_form_after') %}*/
/* */
/*         {% else %}*/
/* */
/*             {% do action('comment_form_comments_closed') %}*/
/* */
/*         {% endif %}*/
/* */
/*     </section>*/
/*     {# End Comments #}*/
/* */
/* {% endblock %}*/
/* */
