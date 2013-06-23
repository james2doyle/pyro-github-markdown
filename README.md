pyro-github-markdown
====================

Github flavoured markdown field type for PyroCMS.

Most of the work for this repo is taken from [GitHub-Flavored Markdown Comments](https://github.com/evansolomon/wp-github-flavored-markdown-comments) plugin for Wordpress. That repository is also based on [Michel Fortin's PHP markdown library](https://github.com/michelf/php-markdown/) with added features from [GitHub-flavored Markdown](https://github.com/github/github-flavored-markdown).

*All I did was just bring it all together and make it play nice with Pyro.*

![write your markdown](https://raw.github.com/james2doyle/pyro-github-markdown/master/write.png)

![preview your markdown](https://raw.github.com/james2doyle/pyro-github-markdown/master/preview.png)

### Usage

* Install the field type as normal.
* Add the field type to a page type or stream
* Enter in your sexy Github Markdown
* Just use `{{ the_field_slug }}` to render the HTML

### Examples

Input:

```markdown
GitHub-Flavored Markdown Comments
=============================

Based on [Michel Fortin's PHP markdown library](https://github.com/michelf/php-markdown/) with added features from [GitHub-flavored Markdown](https://github.com/github/github-flavored-markdown).

* Single linebreaks are treated as new paragraphs
* Code "fencing" with three backticks (```)

### Heading 3

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
```

Output:

```html
<h1>GitHub-Flavored Markdown Comments</h1>

<p>Based on <a href="https://github.com/michelf/php-markdown/">Michel Fortin's PHP markdown library</a> with added features from <a href="https://github.com/github/github-flavored-markdown">GitHub-flavored Markdown</a>.</p>

<ul>
<li>Single linebreaks are treated as new paragraphs</li>
<li>Code "fencing" with three backticks (```)</li>
</ul>

<h3>Heading 3</h3>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
```

### More Info!

If you need to know more about the caveats of this plugin, please [see the README](https://github.com/evansolomon/wp-github-flavored-markdown-comments/blob/master/README.md) for the original lib.