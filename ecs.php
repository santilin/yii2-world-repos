<?php
/*<<<<<USES*/
declare(strict_types=1);

use Symplify\EasyCodingStandard\ValueObject\Option;
/*>>>>>USES*/
/*<<<<<CONFIGURE*/
return Symplify\EasyCodingStandard\Config\ECSConfig::configure()
    ->withSpacing(Option::INDENTATION_TAB, \PHP_EOL)
    ->withPhpCsFixerSets(
        perCS20: true,
/*>>>>>CONFIGURE*/
/*<<<<<CONFIGURED_RULES*/
    )
    // Use withConfiguredRule for fixers with config
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Import\OrderedImportsFixer::class,
        [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class,
        [
            'elements' => ['property', 'method'],
        ],
    )->withConfiguredRule(
        PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer::class,
        [
            'on_multiline' => 'ignore',
        ],
    )->withConfiguredRule(
        PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer::class,  // This is the important addition
        [
            'elements' => ['arrays', 'parameters'], // Exclude 'arguments'
        ],
/*>>>>>CONFIGURED_RULES*/
/*<<<<<RULES*/
    )
    // Use withRules for fixers without config as array of strings
    ->withRules([
        // PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class,
         // PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer::class,
        PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class,
/*>>>>>RULES*/
/*<<<<<SKIP*/
    ])
    ->withSkip([
        __DIR__ . '/tests/Support/_generated',
        __DIR__ . '/web/assets',
        __DIR__ . '/runtime',
        __DIR__ . '/vendor',
        __DIR__ . '/capel',
        PhpCsFixer\Fixer\Import\OrderedImportsFixer::class, // DO NOT REMOVE!!!
        PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer::class,
        PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer::class,
        PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer::class,
        PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer::class,
        PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer::class,
        PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer::class,
        PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer::class,
        PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer::class,
/*>>>>>SKIP*/
/*<<<<<SCOPES*/
    ])
    ->withFileExtensions([
        'php',
/*>>>>>SCOPES*/
/*<<<<<WITH_PATHS*/
    ])->withPaths([
/*>>>>>WITH_PATHS*/
        __DIR__,
/*<<<<<END*/
    ]);
/*>>>>>END*/
