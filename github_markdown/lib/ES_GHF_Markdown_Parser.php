<?php defined('BASEPATH') or exit('No direct script access allowed');

include('markdown.php');
// From `extra` branch of https://github.com/michelf/php-markdown/
include('markdown-extra.php');
/**
 * @plugin Name: GitHub-Flavored Markdown Comments
 * @plugin URI: https://github.com/evansolomon/wp-github-flavored-markdown-comments
 * @description: Markdown-powered WordPress comments, with a GitHub Twist
 * @version: 1.0
 * @author: Evan Solomon
 * @author URI: http://evansolomon.me/
*/
class ES_GHF_Markdown_Parser extends MarkdownExtra_Parser {
  /**
   * Overload to enable single-newline paragraphs
   * https://github.com/github/github-flavored-markdown/blob/gh-pages/index.md#newlines
  */
  function formParagraphs( $text ) {
      // Treat single linebreaks as double linebreaks
    $text = preg_replace('#([^\n])\n([^\n])#', "$1\n\n$2", $text );
    return parent::formParagraphs( $text );
  }

  /**
   * Overload to support ```-fenced code blocks
   * https://github.com/github/github-flavored-markdown/blob/gh-pages/index.md#fenced-code-blocks
   */
  function doCodeBlocks( $text ) {
    $text = preg_replace_callback(
      '#'       .
        '^```'    . // Fenced code block
        '[^\n]*$' . // No language-specific support yet
        '\n'      . // Newline
        '(.+?)'   . // Actual code here
        '\n'      . // Last newline
        '^```$'   . // End of block
        '#ms',      // Multiline mode + dot matches newlines
        array( $this, '_doCodeBlocks_callback' ),
        $text
        );

    return parent::doCodeBlocks( $text );
  }
}