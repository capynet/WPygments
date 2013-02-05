<?php
/*
Plugin Name: WPygments
Plugin URI: https://github.com/capy/WPygments
Description: Server side syntax highlighter based on Pygments highlighter software
Version: 1.0 beta 1
Author: Marcelo Iván Tosco (Capy)
Author URI: http://ecapy.com/
License: GPL v3
*/

require_once(dirname(__FILE__) . "/pygments_for_php.inc.php");

class Pygmentizer
{

    private $hidden_php_tab = false;
    private $expose_php_open_tag = true;
    private $attrs;
    private $extra_opts_array = array();
    private $content;
    private $result;
    private $shortcodes = array(
        "pygmentize",
        "pyg",
        "php"
    );

    private $shortcuts = array(
        "javascript",
        "php",
        "html",
        "xml",
        "mysql",
        "sql",
        "css"
    );

    function __construct()
    {
        add_filter('comment_text', array(&$this, 'parseShortcodes'), 7);
        add_filter('the_content', array(&$this, 'parseShortcodes'), 7);
    }

    /**
     * A filter function that runs do_shortcode() but only with this plugin's shortcodes
     *
     * @param $content
     * @return string
     */
    function parseShortcodes($content)
    {
        global $shortcode_tags;

        // Backup current registered shortcodes and clear them all out
        $orig_shortcode_tags = $shortcode_tags;
        remove_all_shortcodes();

        // Register all of this plugin's shortcodes
        foreach ($this->shortcodes as $shortcode) {
            add_shortcode($shortcode, array(&$this, 'parseShortcode'));
        }

        //Traduct shortcuts to [pyg lang="LANGNAME"]...[/pyg]
        foreach ($this->shortcuts as $shortcut) {
            $pattern = '\\[(' . "$shortcut" . ')\\](' . '[\S\s]*?' . ')\\[\/' . "$shortcut" . '\\]';
            $content = preg_replace("/$pattern/s", '[pyg lang="$1"]$2[/pyg]', $content);
        }

        $content = do_shortcode($content);

        // Put the original shortcodes back
        $shortcode_tags = $orig_shortcode_tags;

        return $content;
    }


    /**
     * Extract and merge attrs defined in shortcode with defaults.
     *
     * @param $attributes array shortcodes params
     * @return Pygmentizer
     */
    private function getAttrs($attributes)
    {

        $attrs = (object)shortcode_atts(array(
            'lang' => "text",
            'style' => "default",
            'tabwidth' => "4",
            // These are passed in using $extra_opts:
            'linenos' => null,
            'linenostart' => null,
            'hl_lines' => null,
            'nowrap' => false,
        ), $attributes);

        /* Make sure there are no wonky shell characters in these args.  At this
        writing (2011-05-01) only alnum and +,- are used in these two options */
        if (preg_match("/[^[:alnum:]+-]/", $attrs->lang) !== 0) {
            $attrs->lang = "text";
        }

        if (preg_match("/[^[:alnum:]+-]/", $attrs->style) !== 0) {
            $attrs->style = "default";
        }

        $this->attrs = $attrs;

        return $this;
    }


    /**
     * @return Pygmentizer
     */
    private function getCMDExtraArgs()
    {

        $extra_opts_array = array();

        // "every true value except 'inline' means the same as 'table'"
        // http://pygments.org/docs/formatters/
        if ($this->attrs->linenos == "inline") {
            $extra_opts_array[] = "linenos=inline";
        } else if ($this->attrs->linenos) {
            $extra_opts_array[] = "linenos=table";
        }

        if (is_numeric($this->attrs->linenostart)) {
            $extra_opts_array[] = "linenostart=$this->attrs->linenostart";
        }

        if ($this->attrs->hl_lines != NULL) {
            /* We split apart the passed-in arg to make sure each one is numeric: */
            $hl_lines_array = preg_split('/ +/', $this->attrs->hl_lines);
            $hl_lines_array_safe = array();

            foreach ($hl_lines_array as $line_no) {
                if (is_numeric($line_no)) {
                    $hl_lines_array_safe[] = $line_no;
                }
            }

            $option = "hl_lines='" . join(" ", $hl_lines_array_safe) . "'";
            $extra_opts_array[] = $option;
        }

        if (($this->attrs->nowrap != NULL) && (strtolower($this->attrs->nowrap) != "false")) {
            $extra_opts_array[] = "nowrap=True";
        }

        /* Join the array with commas and pass it to the PHP function: */
        $this->extra_opts_array = count($extra_opts_array) > 0 ? "-O " . join(",", $extra_opts_array) : "";

        return $this;
    }

    /**
     * Prepare contents before sent to pygments highlighter
     *
     * @param string $content
     * @return Pygmentizer
     */
    private function prepareContent($content)
    {

        $content = trim($content);
        define("PHP_OPEN_TAG", "<?php");

        //Prevent broken "< ?php" (caused by Wordpress)
        $purePHP = array("php", "php3", "php4", "php5");
        $mixedPHP = array("html+php", "css+php", "js+php", "xml+php");
        $preventBrokenTags = array_merge($mixedPHP, $purePHP);

        if (in_array($this->attrs->lang, $preventBrokenTags)) {
            $content = preg_replace("/\<\s\?php/", PHP_OPEN_TAG, $content);
        }

        define("XML_OPEN_TAG", "<?xml");
        //XML
        if (in_array($this->attrs->lang, array("xml"))) {
            $content = preg_replace("/\<\s\?xml/", XML_OPEN_TAG, $content);
        }

        define("HTML_DOCTYPE_TAG", "<!DOCTYPE");

        //HTML
        if (in_array($this->attrs->lang, array("html"))) {
            $content = preg_replace("/\<\s\!DOCTYPE/", HTML_DOCTYPE_TAG, $content);
        }

        //HELPER if only php code and not open tag specified, we add one
        if (in_array($this->attrs->lang, $purePHP) && substr($content, 0, 5) !== PHP_OPEN_TAG) {
            $content = PHP_OPEN_TAG . "\n" . $content;
            $this->hidden_php_tab = true;
        }

        $this->content = $content;
        return $this;
    }

    /**
     * Post process content generated by pygment highlighter.
     * @return void
     */
    private function postProcessContent()
    {
        if ($this->hidden_php_tab && !$this->expose_php_open_tag) {
            $this->result["code"] = str_replace('<span class="cp">&lt;?php</span>', "", $this->result);
        }
    }

    /**
     * Parses shortcode contents.
     *
     * Sends content (code to highlight) to pygments app.
     *
     * @param array $atts extracted attributes defined by user.
     * @param string $content code to highlight.
     * @return string code highlighted
     */
    function parseShortcode($atts, $content)
    {

        //Prepare all stuff
        $this->getAttrs($atts)->getCMDExtraArgs()->prepareContent($content);

        $cacheKey = md5($this->content . $this->attrs->lang . $this->attrs->style . $this->attrs->tabwidth . $this->extra_opts_array);

        $cache = wp_cache_get($cacheKey, "wpygments");

        if (false && $cache != false) return $cache;

        //Call pygmentize wrapper
        $this->result = pygmentize(
            $this->content,
            $this->attrs->lang,
            $this->attrs->style,
            $this->attrs->tabwidth,
            $this->extra_opts_array
        );

        $this->postProcessContent();

        wp_cache_set($cacheKey, $this->result["code"], "wpygments");

        return $this->result["code"];
    }

}

add_action('plugins_loaded', create_function('', 'global $pygmentizer; $pygmentizer = new Pygmentizer();'));
