<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Export;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Plantuml implements ExportInterface
{
    /** @var Environment */
    protected $twig;

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
                'tables' => $schema->getTables(),
                'connections' => $schema->getConnections(),
            ]
        );

        $text = preg_replace('/^\s+/m', '', $text);

        return strtr(
            $text,
            [
                '[\t]' => "\t",
                '[\n]' => '',
            ]
        );
    }
}
