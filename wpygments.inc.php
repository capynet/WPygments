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

require_once dirname(__FILE__) . "/PHPygments/src/PHPygments/PHPygments.php";
require_once dirname(__FILE__) . "/PHPygments/src/PHPygments/Pygmentizer.php";

use \PHPygments\PHPygments;
use \PHPygments\Pygmentizer;

/**
 * The Wordpress plugin
 * Class WPygments
 */
class WPygments extends Pygmentizer {

  public $content;
  private $shortcodes = array(
    "pygmentize",
    "pyg"
  );

  function __construct() {

    parent::__construct();

    add_filter('comment_text', array(&$this, 'parseShortcodes'), 1);
    add_filter('the_content', array(&$this, 'parseShortcodes'), 1);
  }

  /**
   * A filter function that runs do_shortcode() but only with this plugin's shortcodes
   *
   * @param $content
   * @return string
   */
  function parseShortcodes($content) {
    global $shortcode_tags;

    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();

    // Register all of this plugin's shortcodes
    foreach ($this->shortcodes as $shortcode) {
      add_shortcode($shortcode, array(&$this, 'parseShortcode'));
    }

    //Traduct shortcuts to [pyg lang="LANGNAME"]...[/pyg]
    $this->shortcuts2shortcodes($content);

    $this->content = $content;

    $content = do_shortcode($content);

    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;

    return $content;
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
  function parseShortcode($atts, $content) {

    $this->pygmentParams = $atts + $this->pygmentParams;
    $this->prepareContent($content);
    $cacheKey = md5($content . implode("", $atts));

    $cache = wp_cache_get($cacheKey, "wpygments");

    wp_enqueue_style('wpygments-styles-' . str_replace(array("/", "."), "-", $this->pygmentParams["style"]), plugins_url("PHPygments/src/PHPygments/styles/" . $this->pygmentParams["style"] . ".css", __FILE__));

    if ($cache != FALSE) {
      return $cache;
    }

    $return = PHPygments::render($content, $this->pygmentParams['lang'], $this->pygmentParams['style'], $this->pygmentParams['linenumbers']);

    wp_cache_set($cacheKey, $return["code"], "wpygments");

    return $return["code"];
  }

  /**
   * Prepare contents before sent to pygments highlighter
   * Prevent broken "< ?php" (caused by Wordpress)
   *
   * @param string $content
   * @return Pygmentizer
   */
  private function prepareContent(&$content) {

    $content = trim($content);
    define("PHP_OPEN_FULL_TAG", "<?php");

    //Prevent broken "< ?php" (caused by Wordpress)
    $purePHP = array("php", "php3", "php4", "php5");
    $mixedPHP = array("html+php", "css+php", "js+php", "xml+php");
    $preventBrokenTags = array_merge($mixedPHP, $purePHP);

    if (in_array($this->pygmentParams["lang"], $preventBrokenTags)) {
      $content = preg_replace("/\<\s\?php|\<\s\?/", PHP_OPEN_FULL_TAG, $content);
    }

    define("XML_OPEN_TAG", "<?xml");
    //XML
    if (in_array($this->pygmentParams["lang"], array("xml"))) {
      $content = preg_replace("/\<\s\?xml/", XML_OPEN_TAG, $content);
    }

    define("HTML_DOCTYPE_TAG", "<!DOCTYPE");

    //HTML
    if (in_array($this->pygmentParams["lang"], array("html"))) {
      $content = preg_replace("/\<\s\!DOCTYPE/", HTML_DOCTYPE_TAG, $content);
    }

    return $this;
  }

}

add_action('plugins_loaded', create_function('', 'global $wpygments; $wpygments = new WPygments();'));