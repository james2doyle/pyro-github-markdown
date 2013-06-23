<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Github Markdown Field Type
 *
 * @package		Addons\Field Types
 * @author		James Doyle (james2doyle@gmail.com)
 * @license		MIT License
 * @link		http://github.com/james2doyle/pyro-github-markdown
 */
class Field_github_markdown
{
	public $field_type_slug    = 'github_markdown';
	public $db_col_type        = 'text';
	public $version            = '1.0.0';
	public $author             = array('name'=>'James Doyle', 'url'=>'http://github.com/james2doyle/pyro-github-markdown');
	// public $custom_parameters  = array('folder_select');

	// --------------------------------------------------------------------------

	public $parser;

	public function __construct()
	{
		$this->CI =& get_instance();
		// Original Author Evan Solomon
		include(__DIR__ . '/lib/ES_GHF_Markdown_Parser.php');
		$this->parser = new ES_GHF_Markdown_Parser;
	}

	// --------------------------------------------------------------------------

	public function pre_output($input, $data)
	{
		return $input;
	}

	public function pre_output_plugin($input, $data)
	{
		return $this->parser->transform($input);
	}

	/**
	 * Output form textarea
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		return form_textarea($data['form_slug'], $data['value'], 'class="md-area"');
	}
	// load up the css and js
	public function event($field)
	{
		$this->CI->type->add_js('github_markdown', 'github_markdown.js');
		$this->CI->type->add_css('github_markdown', 'github_markdown.css');
	}
}
