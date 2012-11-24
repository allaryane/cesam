<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/******************** Entête UTF-8 ******************\
*
*	fichier			: libraries/Bktemplate.php
*	projet			: BK CodeIgniter Package
*	version			: 1.0.2 2011/05/16 09:30 EV
*
*	dépendance		: La librairie 'Template' créé par Colin Williams.
*					  http://williamsconcepts.com/ci/codeigniter/libraries/template/reference.html
\****************************************************/

require_once (APPPATH . 'libraries/Template.php');

class BkTemplate extends CI_Template {
	var $config_theme = array('active_theme' => 'default', 'default' => '');
	var $theme_path = '';

	// OVERRIDES CI_Template::CI_Template()
	public function  __construct() {
		// Copy an instance of CI so we can use the entire framework.
		$this->CI =& get_instance();

		// Load the template config file
		include(APPPATH.'config/template'.EXT);

		// Setup our theme
		if (isset($template_theme)) {
			$this->config_theme = $template_theme;
		}
		if (!isset($this->config_theme['active_theme'])) {
			$this->config_theme = array('active_theme' => 'default', 'default' => '');
		}
		$this->set_theme($this->config_theme['active_theme']);

		// Setup our master template and regions
		if (isset($template))
		{
			$this->config = $template;
			$this->set_template($template['active_template']);
		}
	}

	// EXTENDS CI_Template::initialize($props)
	function initialize($props) {
		// Set master template
		if (isset($props['template'])) {
			// find suggestions where to find the template
			$template_path = $props['template'];
			foreach ($this->_get_suggested_templates($props['template']) as $template_suggestion) {
				if ((file_exists(APPPATH .'views/'. $template_suggestion) or file_exists(APPPATH .'views/'. $template_suggestion . EXT))) {
					$props['template'] = $template_suggestion;
					break;
				}
			}
		}
		parent::initialize($props);
	}

	// EXTENDS CI_Template::write_view($region, $view, $data = NULL, $overwrite = FALSE)
	public function write_view($region, $view, $data = NULL, $overwrite = FALSE) {
		$views = $this->_get_suggested_views($view);
		$nb_views = count($views);
		if ($nb_views == 1) {
			parent::write_view($region, $views[0], $data, $overwrite);
		}
		elseif ($nb_views == 2) {
			parent::write_view($region, $views[0], $data, $overwrite, $views[1]);
		}
		elseif ($nb_views == 3) {
			parent::write_view($region, $views[0], $data, $overwrite, $views[1], $views[2]);
		}
		else {
			parent::write_view($region, $view, $data, $overwrite);
		}
	}

	// EXTENDS CI_Template::parse_view($region, $view, $data = NULL, $overwrite = FALSE)
	public function parse_view($region, $view, $data = NULL, $overwrite = FALSE) {
		$views = $this->_get_suggested_views($view);
		$nb_views = count($views);
		if ($nb_views == 1) {
			parent::parse_view($region, $views[0], $data, $overwrite);
		}
		elseif ($nb_views == 2) {
			parent::parse_view($region, $views[0], $data, $overwrite, $views[1]);
		}
		elseif ($nb_views == 3) {
			parent::parse_view($region, $views[0], $data, $overwrite, $views[1], $views[2]);
		}
		else {
			parent::parse_view($region, $view, $data, $overwrite);
		}
	}

   // OVERRIDES CI_Template::empty_region($name)
   /**
    * Empty a region's content
    *
    * @access  public
    * @param   string   Name to identify the region
    * @return  void
    */
	public function empty_region($name) {
		if (isset($this->regions[$name]['content'])) {
			$this->regions[$name]['content'] = array();
		}
	}

	/**
	 * Reset all regions that have been previously written to.
	 */
	public function reset_all_regions() {
		foreach ($this->regions as $region => $content) {
			if (isset($this->regions[$region]['content'])) {
			   $this->regions[$region]['content'] = array();
			}
		}
	}

	// New function : Used to switch to a different theme
	public function set_theme($group) {
		if (isset($this->config_theme[$group])) {
			$this->theme_path = $this->config_theme[$group];
			if (is_array($this->template)) {
				$this->initialize($this->template);
			}
		}
		else {
			show_error('The theme "'. $group .'" does not exist. Provide a valid theme group.  It should be present in the /config/template.php file');
		}
	}

	// New function : It's a wrapper for load view.
	// It returns the result of the view as a string.
	// The difference from the normal load->view() is that the input view is searched underneath the theme folder.
	public function render_view($view, $data = NULL) {
		$views = $this->_get_suggested_views($view);
		foreach ($views as $suggestion) {
            if (file_exists(APPPATH .'views/'. $suggestion . EXT) or file_exists(APPPATH .'views/'. $suggestion)) {
				$view = $suggestion;
				break;
			}
		}
		$content = $this->CI->load->view($view, $data, TRUE);
		return $content;
	}

	private function _get_suggested_views($view) {
		return $this->_get_suggested_filenames($view);
	}

	private function _get_suggested_templates($template) {
		return $this->_get_suggested_filenames($template);
	}

	private function _get_suggested_filenames($filename) {
		$filenames = array();
		$dirs = array($this->theme_path, $this->config_theme['default']);
		foreach ($dirs as $dir) {
			$new_filename = implode('/', array($dir, $filename));
			if (!in_array($new_filename, $filenames)) {
				$filenames[] = $new_filename;
			}
		}
		return $filenames;
	}



}