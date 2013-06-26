<?php defined('BASEPATH') or exit('No direct script access allowed');
# dirty way to include the globals for the markdown class
# Optional title attribute for footnote links and backlinks.
@define( 'MARKDOWN_FN_LINK_TITLE',         "" );
@define( 'MARKDOWN_FN_BACKLINK_TITLE',     "" );

# Optional class attribute for footnote links and backlinks.
@define( 'MARKDOWN_FN_LINK_CLASS',         "" );
@define( 'MARKDOWN_FN_BACKLINK_CLASS',     "" );

# Optional class prefix for fenced code block.
@define( 'MARKDOWN_CODE_CLASS_PREFIX',     "" );

# Class attribute for code blocks goes on the `code` tag;
# setting this to true will put attributes on the `pre` tag instead.
@define( 'MARKDOWN_CODE_ATTR_ON_PRE',   false );

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
   * Overload to support ```[lang] code blocks
   */
  function doCodeBlocks( $text ) {
    $text = preg_replace_callback('{
      (?:\n|\A)
        # 1: Opening marker
      (
        `{3,} # Marker: three tilde or more.
        )
    [ ]*  # Optional whitspace following marker.
          # 2: Optional language
    (
      [a-zA-Z0-9_-]+  # Alphanumeric with hyphen and underscore allowed
      )?
    [ ]* \n # Optional whitespace and mandatory newline following marker and optional language.

          # 2: Content
    (
      (?>
        (?!\1 [ ]* \n)  # Not a closing marker.
        .*\n+
        )+
    )

          # Closing marker.
    \1 [ ]* \n
  }xm',
  array( $this, '_doCodeBlocks_callback' ), $text);

    return parent::doCodeBlocks( $text );
  }
  /**
   * Overload to support <pre class='prettyprint'><code class='lang-{lang}'> code blocks
   * taken from the original GH Markdown PHP project
   * added by James Doyle (james2doyle)
   * https://github.com/clevercherry/php-markdown/blob/0f50106a9e2aac6f8defb4b28f3f9fb956d13edd/markdown.php#L2555-L2597
   */
  function _doCodeBlocks_callback($matches) {
    $codeblock = $matches[3];

    $codeblock = $this->outdent($codeblock);
    $codeblock = htmlspecialchars($codeblock, ENT_NOQUOTES);

    # trim leading newlines and trailing newlines
    $codeblock = preg_replace('/\A\n+|\n+\z/', '', $codeblock);
    if (strlen($matches[2])) {
      $codeblock = "<pre class='prettyprint'><code class='lang-$matches[2]'>$codeblock\n</code></pre>";
    } else {
      $codeblock = "<pre><code>$codeblock\n</code></pre>";
    }
    return "\n\n".$this->hashBlock($codeblock)."\n\n";
  }
}