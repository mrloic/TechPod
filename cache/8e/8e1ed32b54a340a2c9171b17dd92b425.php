<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* base.html.twig */
class __TwigTemplate_083d75eece285bf51b23907f858a33c5 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("title", $context)) ? (Twig\Extension\CoreExtension::default(($context["title"] ?? null), "Tech Pod")) : ("Tech Pod")), "html", null, true);
        yield "</title>
    <link href=\"/media/style/main.css\" rel=\"stylesheet\">
    <link rel=\"icon\" href=\"/media/img/logo.svg\" type=\"image/x-icon\">
</head>
<body class=\"background\">
    <header>
        <div class=\"header\">
            <div class=\"profile\">
                <img src=\"/media/img/profile_1.svg\" alt=\"profile_logo\" class=\"profile_logo\">
            </div>
            <div class=\"search_bar\">
                <input type=\"text\" class=\"search_input\" placeholder=\"Текст для поиска\">
                <a class=\"search_btn\" id=\"search_btn\">
                    <img src=\"/media/img/search.svg\" alt=\"search_icon\" class=\"search_icon\">
                </a>
                <a class=\"add_card_btn\" id=\"addCardBtn\">
                    <img src=\"/media/img/plus.svg\" alt=\"add_card_icon\" class=\"add_card_icon\">
                </a>
            </div>
            <div class=\"logo_r\">
                <a href=\"https://rsvpu.ru/\" class=\"logo\" id=\"logo\">
                    <img src=\"/media/img/logo_22.svg\" alt=\"logo\" class=\"logo\">
                </a>
            </div>
        </div>
    </header>
    <main>
        ";
        // line 33
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 34
        yield "    </main>
    <script src=\"/media/script/script.js\"></script>
</body>
</html>
";
        yield from [];
    }

    // line 33
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  91 => 33,  82 => 34,  80 => 33,  50 => 6,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "base.html.twig", "/home/deck/TechPod/templates/base.html.twig");
    }
}
