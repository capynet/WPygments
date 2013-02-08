WPygments - Wordpress syntax highlighter based on Pygments
======================
[XML][]
Server side syntax highlighter based on Pygments highlighter software.

## Installation:
To use this plugin you need pygments in your server:

```
sudo apt-get install python-pygments
```

That's all. Now you can download the plugin and install it in your Wordpress.

## Usage
Once you get installed the plugin the usage is straightforward. just enclose your code between tokens named with the corresponding lang:

[javascript]....[/javascript]

[php]....[/php]

See "Languages and filetypes supported" section to know available languages.

#### Parameters
Tokens support a few parameters:

[php **style**="manni" **tabwidth**="4" **linenumbers**="true"]....[/php]

`style="manni"` defines code styling. Currently are 19 available styles.<br>
Default styling is `default` wich is very nice, but maybe you like other styles. see "Color styles" section.

`tabwidth="4"` defines tabspace. defaults `4`

`linenumbers="true"` show line numbers?. defaults `false`

#### Examples
```
[javascript]
//comment line
var foo = "foo";
var bar = function(){
	var baz;
}
[/javascript]
```

Outputs highlighted js with **default** style, **4** tabspace, **no** (false) linenumbers.

```
[javascript style="monokai"]
//comment line
var foo = "foo";
var bar = function(){
	var baz;
}
[/javascript]
```
Outputs highlighted js with **monokai** style, **4** tabspace (the default), **no** (false) linenumbers (the default).

And so on.

##Color styles
These are supported color styles:

* `monokai`<br>
![monokai example](Documentation/img/style__0018_Layer-20.png "")

* `manni`<br>
![monokai example](Documentation/img/style__0017_Layer-19.png "")

* `rrt`<br>
![monokai example](Documentation/img/style__0016_Layer-18.png "")

* `perldoc`<br>
![monokai example](Documentation/img/style__0015_Layer-17.png "")

* `borland`<br>
![monokai example](Documentation/img/style__0014_Layer-16.png "")

* `colorful`<br>
![monokai example](Documentation/img/style__0013_Layer-15.png "")

* `default`<br>
![monokai example](Documentation/img/style__0012_Layer-14.png "")

* `murphy`<br>
![monokai example](Documentation/img/style__0011_Layer-13.png "")

* `vs`<br>
![monokai example](Documentation/img/style__0010_Layer-12.png "")

* `trac`<br>
![monokai example](Documentation/img/style__0009_Layer-11.png "")

* `tango`<br>
![monokai example](Documentation/img/style__0008_Layer-10.png "")

* `fruity`<br>
![monokai example](Documentation/img/style__0007_Layer-9.png "")

* `autumn`<br>
![monokai example](Documentation/img/style__0006_Layer-8.png "")

* `bw`<br>
![monokai example](Documentation/img/style__0005_Layer-7.png "")

* `emacs`<br>
![monokai example](Documentation/img/style__0004_Layer-6.png "")

* `vim`<br>
![monokai example](Documentation/img/style__0003_Layer-5.png "")

* `pastie`<br>
![monokai example](Documentation/img/style__0002_Layer-4.png "")

* `friendly`<br>
![monokai example](Documentation/img/style__0001_Layer-3.png "")

* `native`<br>
![monokai example](Documentation/img/style__0000_Layer-1.png "")


##Languages and filetypes supported

Pygments not only highlights languages. also highlights filetypes like .conf **Nginx** configuration file, **Apache** (filenames .htaccess, apache.conf, apache2.conf), etc.

Here is a list of more used:

#####General
* `apacheconf`: (.htaccess, apache.conf, apache2.conf)
* `bash`, `sh`, `ksh`:
    (*.sh, *.ksh, *.bash, *.ebuild, *.eclass, .bashrc, bashrc)
* `ini`, `cfg`: (*.ini, *.cfg)
* `makefile`:
    (*.mak, Makefile, makefile, Makefile.*, GNUmakefile)
* `nginx`:
    Nginx configuration file 
* `yaml`:
    (*.yaml, *.yml)
* `perl`:
    Perl (*.pl, *.pm)
* `vb.net`:
    VB.net (*.vb, *.bas)
* `console`:
    Bash Session (*.sh-session)

#####Javascript
* `javascript`:
    (*.js)
* `coffee-script`:
    CoffeeScript (*.coffee)
* `json`:
    JSON (*.json)

#####PHP
* `css+php`: CSS+PHP 
* `html+php`: HTML+PHP (*.phtml)
* `js+php`
* `php`: (*.php, *.php3, *.php4, *.php5)
* `xml+php`

#####Ruby
* `ruby`, `duby`: Ruby (*.rb, *.rbw, *.rake, *.gemspec, *.rbx, *.duby)
* `css+erb`, `css+ruby`: CSS+Ruby 
* `xml+erb`, `xml+ruby`: XML+Ruby 

#####CSS and CSS compilers
* `css`:
    CSS (*.css)
* `sass`:
    Sass (*.sass)
* `scss`:
    SCSS (*.scss)

#####HTML and HTML template systems
* `html`:
    HTML (*.html, *.htm, *.xhtml, *.xslt)
* `haml`:
    Haml (*.haml)
* `jade`:
    Jade (*.jade)

#####SQL
* `sql`:
    SQL (*.sql)
* `sqlite3`:
    sqlite3con (*.sqlite3-console)
* `mysql`:
    MySQL 

#####Python & Django
* `python`:
    Python (*.py, *.pyw, *.sc, SConstruct, SConscript, *.tac)
* `python3`:
    Python 3 
* `xml+django`, `xml+jinja`:
    XML+Django/Jinja 
* `css+django`, `css+jinja`:
    CSS+Django/Jinja 
* `django`, `jinja`:
    Django/Jinja 
* `html+django`, `html+jinja`:
    HTML+Django/Jinja 
* `js+django`, `js+jinja`:
    JavaScript+Django/Jinja 

#####Java & Groovy
* `java`:
    Java (*.java)
* `groovy`:
    Groovy (*.groovy)
* `jsp`:
    Java Server Page (*.jsp)

#####C, C++, Objetive-c, C Sharp
* `c-objdump`:
    c-objdump (*.c-objdump)
* `c`:
    C (*.c, *.h, *.idc)
* `cpp`, `c++`:
    C++ (*.cpp, *.hpp, *.c++, *.h++, *.cc, *.hh, *.cxx, *.hxx)
* `csharp`:
    C# (*.cs)
* `objective-c`: (*.m)

#####XML#####
* `xml`: (*.xml, *.xsl, *.rss, *.xslt, *.xsd, *.wsdl)
* `xslt`: (*.xsl, *.xslt)


Pygments is virtually supports all available languages. You can see it in detail in [http://pygments.org/languages/](http://pygments.org/languages/ "")