<?php
/*
Plugin Name: Pygments for Wordpress
Plugin URI: http://derek.simkowiak.net/pygments-for-wordpress/
Description: This plugin uses pygments to highlight code on the server.  For example, [pygments language=python]print "Hello"[/pygments]
Version: 1.0
Author: Derek Simkowiak
Author URI: http://derek.simkowiak.net/
License: MIT
*/

/*
Copyright (c) 2011 Derek Simkowiak

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
require_once( dirname( __FILE__ ) . "/pygments_for_php.inc.php" );


/* Create a unique class name to provide a unique plugin namespace: */
class Pygmentizer {
	
	// Use the latest PHP5 style construtor:
	function __construct() {
		
		// This plugin is WP 2.5+ only:
		if ( !function_exists('add_shortcode') ) return;
		
		// Hack to get the [pygmentize] blocks before wpautop()
		$this->unformatted_shortcode_blocks = array();
		
		add_filter( 'the_content', array(&$this, 'get_unformatted_shortcode_blocks'), 8 );

		// Handler for [pygmentize] and [pyg]
		add_shortcode( 'pygmentize', array(&$this, 'my_shortcode_handler2') );
		add_shortcode( 'pyg', array(&$this, 'my_shortcode_handler2') );
		
		// Feature: We remember this setting each call, so that the user only
		// needs to specify them the first time (per page):
		$this->language = 'text';
		$this->style = 'default';
		$this->tabwidth = '4';
		$this->linenos = null;
		$this->linenostart = null;
		$this->nowrap = null;
	
	}
	
	// Inspired by media.php
	
	/**
	 * Process the [pygmentize] shortcode.
	 *
	 * Since the [pygmentize] shortcode needs to be run earlier than other shortcodes,
	 * this function removes all existing shortcodes, registers the [pygmentize] shortcode,
	 * calls {@link do_shortcode()}, and then re-registers the old shortcodes.
	 *
	 * @uses $shortcode_tags
	 * @uses remove_all_shortcodes()
	 * @uses add_shortcode()
	 * @uses do_shortcode()
	 *
	 * @param string $content Content to parse
	 * @return string Content with shortcode parsed
	 */
	function get_unformatted_shortcode_blocks( $content ) {
		global $shortcode_tags;

		// Back up current registered shortcodes and clear them all out
		$orig_shortcode_tags = $shortcode_tags;
		remove_all_shortcodes();

		add_shortcode( 'pygmentize', array(&$this, 'my_shortcode_handler1') );
		// Short version.  Typing pygmentize gets old fast.
		add_shortcode( 'pyg', array(&$this, 'my_shortcode_handler1') );

		// Do the shortcode (only the [pygmentize] one is registered)
		$content = do_shortcode( $content );

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;

		return $content;
	}

	function my_shortcode_handler1( $atts, $content=null, $code="" ) {
		
		// Store the unformatted content for later:
		$this->unformatted_shortcode_blocks[] = $content;
		
		$content_index = count( $this->unformatted_shortcode_blocks ) - 1;
		
		// Put the shortcode tag back around the content, so it gets processed below.
		// Since we pull the actual (unformatted) content from the array, we
		// just stick the array index between the tags.
		
		$atts_as_string = " ";
		foreach ( $atts as $key => $value ) {
			$atts_as_string .= $key . '="' . $value . '" '; 
		}
		$output = "[pygmentize $atts_as_string ]" . $content_index . "[/pygmentize]";
		return $output;
	}

	
	// See http://codex.wordpress.org/Shortcode_API
	function my_shortcode_handler2( $atts, $content=null, $code="" ) {
		
		extract( shortcode_atts( array(
			'language' => null,
			'l' => null,
			
			'style' => null,
			's' => null,
			
			'tabwidth' => null,
			// These are passed in using $extra_opts:
			'linenos' => null,
			'linenostart' => null,
			'hl_lines' => null,
			'nowrap' => null,
		), $atts ) );
		
		/* Some of the shortcode options are passed directly to pgymentize().  But 
		   others are converted to generic shell command-line options: */
		   
		$extra_opts_array = array();// Used to build e.g. "linenos=table,hl_lines='3 7'"
		
		// The short forms l and s overwrite the long forms:
		if ( $l != null ) { $language = $l; }
		if ( $s != null ) { $style = $s; }
		
		
		// Use defaults saved from last time:
		if ( $language === null ) { $language = $this->language; }
		if ( $style === null ) { $style = $this->style; }
		if ( $tabwidth === null ) { $tabwidth = $this->tabwidth; }
		if ( $linenos === null ) { $linenos = $this->linenos; }
		if ( $nowrap === null ) { $nowrap = $this->nowrap; }
		
		
		/* Make sure there are no wonky shell characters in these args.  At this
		   writing (2011-05-01) only alnum and +,- are used in these two options */
		if ( preg_match( "/[^[:alnum:]+-]/", $language ) !== 0 ) {
			$language = "text";
		}
		
		if ( preg_match( "/[^[:alnum:]+-]/", $style ) !== 0 ) {
			$style = "default";
		}
		
		if ( ! is_numeric($tabwidth) ) {
			$tabwidth = "4";
		}
		
		// "every true value except 'inline' means the same as 'table'"
		// http://pygments.org/docs/formatters/
		if ( $linenos=="inline" ) {
			$extra_opts_array[] = "linenos=inline";
		} else if ( $linenos ) {
			$extra_opts_array[] = "linenos=table";
		} else {
			// pass, no line numbers
		}
		
		if ( is_numeric( $linenostart ) ) {
			$extra_opts_array[] = "linenostart=$linenostart";
		}
		
		if ( $hl_lines != NULL ) {
			/* We split apart the passed-in arg to make sure each one is numeric: */
			$hl_lines_array = preg_split( '/ +/', $hl_lines );
			$hl_lines_array_safe = array();
			
			foreach ( $hl_lines_array as $line_no ) {
					if ( is_numeric( $line_no ) ) {
					$hl_lines_array_safe[] = $line_no;
				}
			}
			$option = "hl_lines='" . join(" ", $hl_lines_array_safe ) . "'";
			$extra_opts_array[] = $option;
		}
		
		if (  ($nowrap != NULL)  &&  (strtolower( $nowrap ) != "false")  ) {
			$extra_opts_array[] = "nowrap=True";
		}
		
		/* Join the array with commas and pass it to the PHP function: */
		$extra_opts = "";
		if ( count( $extra_opts_array ) > 0 ) {
			$extra_opts = "-O " . join(",", $extra_opts_array );
		}
		
		// Save the options for next time:
		$this->language = $language;
		$this->style = $style;
		$this->tabwidth = $tabwidth;
		$this->linenos = $linenos;
		$this->nowrap = $nowrap;
		
		// Extract the unformatted content out of the array:
		$content = $this->unformatted_shortcode_blocks[ $content ];
			
		return pygmentize( $content, $language, $style, $tabwidth, $extra_opts );
	}
}

add_action( 'plugins_loaded', create_function( '', 'global $pygmentizer; $pygmentizer = new Pygmentizer();' ) );


