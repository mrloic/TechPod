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

/* main.html.twig */
class __TwigTemplate_d5e559c7bfc15145e2841727bc6f2142 extends Template
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

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "main.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 4
        yield "<div class=\"main\">
    <div class=\"boardsContainer\">
        <div class=\"head_container\">
            <span>В работе</span>
        </div>
        <div class=\"content_board\">
            <div class=\"board\">
                <div class=\"head_board\">
                    <span>Неразобранное</span>
                    <div class=\"board_btn\">
                        <img src=\"/media/img/menu.svg\" alt=\"menu\">
                        <img src=\"/media/img/mini_plus.svg\" alt=\"plus\">
                    </div>
                </div>
                <div class=\"card\" id=\"card\">
                    <div class=\"hr\"></div>
                    <span class=\"card-span\">Задача 1</span>
                    <div class=\"profile_card\">
                        <img src=\"media/img/profile.svg\" alt=\"profile\" class=\"profile_img\">
                        <div class=\"date\">
                            <span>5 дек.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "main.html.twig";
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
        return array (  58 => 4,  51 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "main.html.twig", "/home/deck/TechPod/templates/main.html.twig");
    }
}
