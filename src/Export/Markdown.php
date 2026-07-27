<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Export;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final readonly class Markdown implements ExportInterface
{
    private Environment $twig;

    public function __construct(string $template)
    {
        $this->twig = new Environment(
            new ArrayLoader([
                'template' => $template,
            ])
        );
    }

    public function export(SchemaInterface $schema): string
    {
        $text = $this->twig->render(
            'template',
            [
                'tables' => $schema->tables,
                'connections' => $schema->connections,
            ]
        );

        $text = preg_replace('/^[ \t]+/m', '', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", (string) $text);

        return rtrim((string) $text, "\n") . "\n";
    }
}
