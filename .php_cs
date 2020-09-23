<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src'])
    ->name('*.php')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,

        // All items of the given phpdoc tags must be either left-aligned
        'phpdoc_align' => [
            'align' => 'left',
        ],

        // PHPDoc summary should end in either a full stop, exclamation mark, or question mark.
        'phpdoc_summary' => false,

        // Unused use statements must be removed.
        'no_unused_imports' => true,

        // PHP arrays should be declared using the configured syntax
        'array_syntax' => [
            'syntax' => 'short',
        ],

        // Ordering use statements
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha',
        ],

        // Move the semicolon to the new line for chained calls.
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],

        // Removes @param and @return tags that don't provide any useful information.
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true, // whether type mixed without description is allowed (true) or considered superfluous (false); defaults to false
        ],

        'single_line_throw' => false,

        'phpdoc_line_span' => [
            'property' => 'single',
        ],
    ])
    ->setFinder($finder)
;
