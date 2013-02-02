=== Pygments for Wordpress ===
Contributors: dereks443
Donate link: 
Tags: pygments, syntax, highlight, highlighting, highlighter, hilite, colorize, code
Requires at least: 2.5.0
Tested up to: 3.2.1
Stable tag: trunk

This plugin uses pygments to highlight code on the server, with a simple shortcode.  For example, [pyg]print "Hi"[/pyg]).

== Description ==

This WordPress plugin is a syntax highlighter for many different computer languages, including HTML, Python, PHP, Javascript, CSS, and many others.  It uses the Pygments syntax highlighter from Python.

See http://derek.simkowiak.net/pygments-for-wordpress/ for full documentation.

== Features ==

* Line numbers are supported, using both an HTML table (which lets you copy'n'paste code from the page without any line numbers embedded), and alternatively "inline" line numbers, so that they are included when copy'n'pasting from the screen.

* Tabs are preserved.  They are not substituted with spaces. (The examples here use a width of 4 spaces.  Copy'n'paste it someplace to see!)

* Extra "bright" highlighting of arbitrary line numbers is supported, by specifying which line numbers you want to draw attention to.

* There are may pretty Pygments styles to choose from, and each block of code can have its own style. 

* Server-side highlighting.  In contrast to the older SyntaxHighlighter or SyntaxHighlighter Evolved plugins, this library does the syntax highlighting on the server, not in the web browser.  It uses only CSS markup and HTML, and no Javascript.  

* Unlike WpPygments, this plugin does not communicate with any remote web services.

* This plugin may be installed in parallel with the other syntax highlighter plugins.

* Just ~320 lines of PHP code, and about a third of that is license and comments.

* The shortcode options for language, style, tabwidth, linenos, and nowrap are remembered after each call. So you only need to specify them once, for the first code block.  Then they become the defaults for the rest of the page (which is convenient).

== Installation ==

This plugin depends on the command "pygmentize" being in the web server's path.  With Ubuntu or Debian,
this can be achieved by typing

sudo apt-get install python-pygments

After that, install this plugin like any other.  Go to Admin > Plugins > Add New > Upload.
If that's too easy for you, try this:

1. Put it into `/wp-content/plugins/` directory 
2. Activate it in the admin Plugin page.

== Usage ==

Here are some examples:

[pygmentize language="python"] ... [/pygmentize]
[pygmentize language="html+php" style="monokai" ] ... [/pygmentize]

Typing in "pygmentize" gets old, so you can use pyg for short:

[pyg language="ruby" style="colorful" ] ... [/pyg]
[pyg language="bbcode" tabwidth="3"] ... [/pyg]

You can also use the short form 'l' and 's' to for 'language' and 'style':

[pyg l="python" s="tango" linenos="table"] ... [/pyg]
[pyg l="python" s="autumn" linenos="inline"] ... [/pyg]

The following settings are remembered each call,
so you only need to specify them for your first block
of code and then they are the defaults:

* language
* style
* tabwidth
* linenos
* nowrap

[pyg l="python" s="monokai" linenos="table" linenostart="54" nowrap="True"] ... [/pyg]

Now any subsequent calls default to python, with line numbers, in the monokai style:

[pyg] ... [/pyg]
[pyg hl_lines="3 4 7"] ... [/pyg]


You can get an instant preview of various available styles by 
using the form at this link:(http://pygments.org/demo/ "Pygments Demo")

Here are the styles supported out-of-the-box with Ubuntu:

Styles:
~~~~~~~
* monokai
* manni
* perldoc
* borland
* colorful
* default
* murphy
* vs
* trac
* tango
* fruity
* autumn
* bw
* emacs
* pastie
* friendly
* native

Languages:
~~~~~~~~~~
* Cucumber, cucumber, Gherkin, gherkin:
    Gherkin (filenames *.feature)
* abap:
    ABAP (filenames *.abap)
* antlr-as, antlr-actionscript:
    ANTLR With ActionScript Target (filenames *.G, *.g)
* antlr-cpp:
    ANTLR With CPP Target (filenames *.G, *.g)
* antlr-csharp, antlr-c#:
    ANTLR With C# Target (filenames *.G, *.g)
* antlr-java:
    ANTLR With Java Target (filenames *.G, *.g)
* antlr-objc:
    ANTLR With ObjectiveC Target (filenames *.G, *.g)
* antlr-perl:
    ANTLR With Perl Target (filenames *.G, *.g)
* antlr-python:
    ANTLR With Python Target (filenames *.G, *.g)
* antlr-ruby, antlr-rb:
    ANTLR With Ruby Target (filenames *.G, *.g)
* antlr:
    ANTLR 
* apacheconf, aconf, apache:
    ApacheConf (filenames .htaccess, apache.conf, apache2.conf)
* applescript:
    AppleScript (filenames *.applescript)
* as, actionscript:
    ActionScript (filenames *.as)
* as3, actionscript3:
    ActionScript 3 (filenames *.as)
* aspx-cs:
    aspx-cs (filenames *.aspx, *.asax, *.ascx, *.ashx, *.asmx, *.axd)
* aspx-vb:
    aspx-vb (filenames *.aspx, *.asax, *.ascx, *.ashx, *.asmx, *.axd)
* asy:
    Asymptote (filenames *.asy)
* basemake:
    Makefile 
* bash, sh:
    Bash (filenames *.sh, *.ebuild, *.eclass)
* bat:
    Batchfile (filenames *.bat, *.cmd)
* bbcode:
    BBCode 
* befunge:
    Befunge (filenames *.befunge)
* boo:
    Boo (filenames *.boo)
* brainfuck, bf:
    Brainfuck (filenames *.bf, *.b)
* c-objdump:
    c-objdump (filenames *.c-objdump)
* c:
    C (filenames *.c, *.h)
* cheetah, spitfire:
    Cheetah (filenames *.tmpl, *.spt)
* clojure, clj:
    Clojure (filenames *.clj)
* cmake:
    CMake (filenames *.cmake)
* common-lisp, cl:
    Common Lisp (filenames *.cl, *.lisp, *.el)
* console:
    Bash Session (filenames *.sh-session)
* control:
    Debian Control file (filenames control)
* cpp, c++:
    C++ (filenames *.cpp, *.hpp, *.c++, *.h++, *.cc, *.hh, *.cxx, *.hxx)
* cpp-objdump, c++-objdumb, cxx-objdump:
    cpp-objdump (filenames *.cpp-objdump, *.c++-objdump, *.cxx-objdump)
* csharp, c#:
    C# (filenames *.cs)
* css+django, css+jinja:
    CSS+Django/Jinja 
* css+erb, css+ruby:
    CSS+Ruby 
* css+genshitext, css+genshi:
    CSS+Genshi Text 
* css+mako:
    CSS+Mako 
* css+mako:
    CSS+Mako 
* css+myghty:
    CSS+Myghty 
* css+php:
    CSS+PHP 
* css+smarty:
    CSS+Smarty 
* css:
    CSS (filenames *.css)
* cython, pyx:
    Cython (filenames *.pyx, *.pxd, *.pxi)
* d-objdump:
    d-objdump (filenames *.d-objdump)
* d:
    D (filenames *.d, *.di)
* delphi, pas, pascal, objectpascal:
    Delphi (filenames *.pas)
* diff, udiff:
    Diff (filenames *.diff, *.patch)
* django, jinja:
    Django/Jinja 
* dpatch:
    Darcs Patch (filenames *.dpatch, *.darcspatch)
* dylan:
    Dylan (filenames *.dylan)
* erb:
    ERB 
* erl:
    Erlang erl session (filenames *.erl-sh)
* erlang:
    Erlang (filenames *.erl, *.hrl)
* evoque:
    Evoque (filenames *.evoque)
* fortran:
    Fortran (filenames *.f, *.f90)
* gas:
    GAS (filenames *.s, *.S)
* genshi, kid, xml+genshi, xml+kid:
    Genshi (filenames *.kid)
* genshitext:
    Genshi Text 
* glsl:
    GLSL (filenames *.vert, *.frag, *.geo)
* gnuplot:
    Gnuplot (filenames *.plot, *.plt)
* go:
    Go (filenames *.go)
* groff, nroff, man:
    Groff (filenames *.[1234567], *.man)
* haskell, hs:
    Haskell (filenames *.hs)
* html+cheetah, html+spitfire:
    HTML+Cheetah 
* html+django, html+jinja:
    HTML+Django/Jinja 
* html+evoque:
    HTML+Evoque (filenames *.html)
* html+genshi, html+kid:
    HTML+Genshi 
* html+mako:
    HTML+Mako 
* html+mako:
    HTML+Mako 
* html+myghty:
    HTML+Myghty 
* html+php:
    HTML+PHP (filenames *.phtml)
* html+smarty:
    HTML+Smarty 
* html:
    HTML (filenames *.html, *.htm, *.xhtml, *.xslt)
* ini, cfg:
    INI (filenames *.ini, *.cfg, *.properties)
* io:
    Io (filenames *.io)
* irc:
    IRC logs (filenames *.weechatlog)
* java:
    Java (filenames *.java)
* js+cheetah, javascript+cheetah, js+spitfire, javascript+spitfire:
    JavaScript+Cheetah 
* js+django, javascript+django, js+jinja, javascript+jinja:
    JavaScript+Django/Jinja 
* js+erb, javascript+erb, js+ruby, javascript+ruby:
    JavaScript+Ruby 
* js+genshitext, js+genshi, javascript+genshitext, javascript+genshi:
    JavaScript+Genshi Text 
* js+mako, javascript+mako:
    JavaScript+Mako 
* js+mako, javascript+mako:
    JavaScript+Mako 
* js+myghty, javascript+myghty:
    JavaScript+Myghty 
* js+php, javascript+php:
    JavaScript+PHP 
* js+smarty, javascript+smarty:
    JavaScript+Smarty 
* js, javascript:
    JavaScript (filenames *.js)
* jsp:
    Java Server Page (filenames *.jsp)
* lhs, literate-haskell:
    Literate Haskell (filenames *.lhs)
* lighty, lighttpd:
    Lighttpd configuration file 
* llvm:
    LLVM (filenames *.ll)
* logtalk:
    Logtalk (filenames *.lgt)
* lua:
    Lua (filenames *.lua)
* make, makefile, mf, bsdmake:
    Makefile (filenames *.mak, Makefile, makefile, Makefile.*, GNUmakefile)
* mako:
    Mako (filenames *.mao)
* mako:
    Mako (filenames *.mao)
* matlab, octave:
    Matlab (filenames *.m)
* matlabsession:
    Matlab session 
* minid:
    MiniD (filenames *.md)
* modelica:
    Modelica (filenames *.mo)
* moocode:
    MOOCode (filenames *.moo)
* mupad:
    MuPAD (filenames *.mu)
* mxml:
    MXML (filenames *.mxml)
* myghty:
    Myghty (filenames *.myt, autodelegate)
* mysql:
    MySQL 
* nasm:
    NASM (filenames *.asm, *.ASM)
* newspeak:
    Newspeak (filenames *.ns2)
* nginx:
    Nginx configuration file 
* numpy:
    NumPy 
* objdump:
    objdump (filenames *.objdump)
* objective-c, objectivec, obj-c, objc:
    Objective-C (filenames *.m)
* ocaml:
    OCaml (filenames *.ml, *.mli, *.mll, *.mly)
* ooc:
    Ooc (filenames *.ooc)
* perl, pl:
    Perl (filenames *.pl, *.pm)
* php, php3, php4, php5:
    PHP (filenames *.php, *.php[345])
* pot, po:
    Gettext Catalog (filenames *.pot, *.po)
* pov:
    POVRay (filenames *.pov, *.inc)
* prolog:
    Prolog (filenames *.prolog, *.pro, *.pl)
* py3tb:
    Python 3.0 Traceback (filenames *.py3tb)
* pycon:
    Python console session 
* pytb:
    Python Traceback (filenames *.pytb)
* python, py:
    Python (filenames *.py, *.pyw, *.sc, SConstruct, SConscript)
* python3, py3:
    Python 3 
* ragel-c:
    Ragel in C Host (filenames *.rl)
* ragel-cpp:
    Ragel in CPP Host (filenames *.rl)
* ragel-d:
    Ragel in D Host (filenames *.rl)
* ragel-em:
    Embedded Ragel (filenames *.rl)
* ragel-java:
    Ragel in Java Host (filenames *.rl)
* ragel-objc:
    Ragel in Objective C Host (filenames *.rl)
* ragel-ruby, ragel-rb:
    Ragel in Ruby Host (filenames *.rl)
* ragel:
    Ragel 
* raw:
    Raw token data 
* rb, ruby:
    Ruby (filenames *.rb, *.rbw, Rakefile, *.rake, *.gemspec, *.rbx)
* rbcon, irb:
    Ruby irb session 
* rebol:
    REBOL (filenames *.r, *.r3)
* redcode:
    Redcode (filenames *.cw)
* rhtml, html+erb, html+ruby:
    RHTML (filenames *.rhtml)
* rst, rest, restructuredtext:
    reStructuredText (filenames *.rst, *.rest)
* scala:
    Scala (filenames *.scala)
* scheme, scm:
    Scheme (filenames *.scm)
* smalltalk, squeak:
    Smalltalk (filenames *.st)
* smarty:
    Smarty (filenames *.tpl)
* sourceslist, sources.list:
    Debian Sourcelist (filenames sources.list)
* splus, s, r:
    S (filenames *.S, *.R)
* sql:
    SQL (filenames *.sql)
* sqlite3:
    sqlite3con (filenames *.sqlite3-console)
* squidconf, squid.conf, squid:
    SquidConf (filenames squid.conf)
* tcl:
    Tcl (filenames *.tcl)
* tcsh, csh:
    Tcsh (filenames *.tcsh, *.csh)
* tex, latex:
    TeX (filenames *.tex, *.aux, *.toc)
* text:
    Text only (filenames *.txt)
* trac-wiki, moin:
    MoinMoin/Trac Wiki markup 
* vala, vapi:
    Vala (filenames *.vala, *.vapi)
* vb.net, vbnet:
    VB.net (filenames *.vb, *.bas)
* vim:
    VimL (filenames *.vim, .vimrc)
* xml+cheetah, xml+spitfire:
    XML+Cheetah 
* xml+django, xml+jinja:
    XML+Django/Jinja 
* xml+erb, xml+ruby:
    XML+Ruby 
* xml+evoque:
    XML+Evoque (filenames *.xml)
* xml+mako:
    XML+Mako 
* xml+mako:
    XML+Mako 
* xml+myghty:
    XML+Myghty 
* xml+php:
    XML+PHP 
* xml+smarty:
    XML+Smarty 
* xml:
    XML (filenames *.xml, *.xsl, *.rss, *.xslt, *.xsd, *.wsdl)
* xslt:
    XSLT (filenames *.xsl, *.xslt)
* yaml:
    YAML (filenames *.yaml, *.yml)

== Frequently Asked Questions ==

= Are all tabs really preserved? =

Almost.  Although the code is preserved correctly in the editor, as of 
this writing (2011-06-28) the Pygments "pygmentize" command trims
all whitespace from the end of the lines when displaying in HTML.  I didn't
see an option to disable that behavior in the documentation.  Other than that, formatting is
preserved.  My end goal is to make it preserve all tabs, such that a copy'n'paste 
from the web page would result in an exact MD5 match of the original.


== Screenshots ==

[none]

== Changelog ==

= 1.0 =
* Official stable release.

= 0.1 =
* Initial launch.

== Upgrade Notice ==

Just copy the new version over the old version.  This plugin does
not use the database for anything.


