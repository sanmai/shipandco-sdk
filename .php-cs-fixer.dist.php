<?php

$header = trim('This code is licensed under the MIT License.'.substr(file_get_contents('LICENSE'), strlen('The MIT License')));

use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        'header_comment' => ['header' => $header, 'separate' => 'bottom', 'location' => 'after_open', 'comment_type' => 'PHPDoc'],
        '@PER-CS' => true,
        'array_indentation' => true,
        'native_function_invocation' => [
            'include' => ['@internal'],
            'scope' => 'namespaced',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'declare_equal_normalize' => ['space' => 'none'],
        'trailing_comma_in_multiline' => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'blank_line_after_opening_tag' => false,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->in(__DIR__)
    )
;

return $config;
