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
	public $version            = '1.1.0';
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

	public function ajax_md_preview()
	{
		// AJAX functionality here.
		// http://example.com/streams_core/public_ajax/field/github_markdown/md_preview
		$info = $this->CI->input->post();
		return $this->parser->transform($info['message']);
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
		$html = '<div class="markdown-field" id="'.$data['form_slug'].'"><ul id="md-tabs-menu" class="tab-menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all"><li class="ui-state-default ui-corner-top ui-state-active ui-tabs-selected"><a href="#md-write-'.$data['form_slug'].'"><span>'.lang('streams:github_markdown.markdown').'</span></a></li><li class="ui-state-default ui-corner-top"><a href="#md-preview-'.$data['form_slug'].'"><span>'.lang('streams:github_markdown.preview').'</span></a></li></ul><div id="md-forms"><div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom" id="md-write-'.$data['form_slug'].'">'.form_textarea($data['form_slug'], $data['value'], 'class="md-write-area"').'</div><div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="md-preview-'.$data['form_slug'].'"><div class="md-preview-area"></div></div></div></div><div class="clearfix"></div>';
		return $html;
	}
	// load up the css and js
	public function event($field)
	{
		$this->CI->type->add_js('github_markdown', 'github_markdown.js');
		$this->CI->type->add_css('github_markdown', 'github_markdown.css');
	}
}
