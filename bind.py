# -*- coding: utf-8 -*-

#################### argumments
import argparse

parser = argparse.ArgumentParser(description="noop")
parser.add_argument('--sourcefile')
parser.add_argument('--style')
parser.add_argument('--lang')
parser.add_argument('--tabwidth')
parser.add_argument('--getstyles')
args = parser.parse_args()

CSSCLASS_BASE = "highlighted-source"

#call pygments and return styled code
from pygments import highlight
from pygments.lexers import get_lexer_by_name
from pygments.formatters import HtmlFormatter

code = open(args.sourcefile).read()
formatter = HtmlFormatter(cssclass=CSSCLASS_BASE + ' ' + args.style + ' ' + args.lang)
lexer = get_lexer_by_name(args.lang)

print highlight(code, lexer, formatter).encode('utf8')
print '<<<<< divide&conquer >>>>>>'

if args.getstyles:
    print HtmlFormatter(style=args.style).get_style_defs('.' + CSSCLASS_BASE + '.' + args.style)