#Copyright (c) 2010 Fabien Potencier
#
#Permission is hereby granted, free of charge, to any person obtaining a copy
#of this software and associated documentation files (the "Software"), to deal
#in the Software without restriction, including without limitation the rights
#to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
#copies of the Software, and to permit persons to whom the Software is furnished
#to do so, subject to the following conditions:
#
#The above copyright notice and this permission notice shall be included in all
#copies or substantial portions of the Software.
#
#THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
#IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
#FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
#AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
#LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
#OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
#THE SOFTWARE.

from docutils.parsers.rst import Directive, directives
from docutils import nodes
from string import upper

class configurationblock(nodes.General, nodes.Element):
    pass

class ConfigurationBlock(Directive):
    has_content = True
    required_arguments = 0
    optional_arguments = 0
    final_argument_whitespace = True
    option_spec = {}
    formats = {
        'html':            'HTML',
        'xml':             'XML',
        'php':             'PHP',
        'yaml':            'YAML',
        'jinja':           'Twig',
        'html+jinja':      'Twig',
        'jinja+html':      'Twig',
        'php+html':        'PHP',
        'html+php':        'PHP',
        'ini':             'INI',
        'php-annotations': 'Annotations',
    }

    def run(self):
        env = self.state.document.settings.env

        node = nodes.Element()
        node.document = self.state.document
        self.state.nested_parse(self.content, self.content_offset, node)

        entries = []
        for i, child in enumerate(node):
            if isinstance(child, nodes.literal_block):
                # add a title (the language name) before each block
                #targetid = "configuration-block-%d" % env.new_serialno('configuration-block')
                #targetnode = nodes.target('', '', ids=[targetid])
                #targetnode.append(child)

                innernode = nodes.emphasis(self.formats[child['language']], self.formats[child['language']])

                para = nodes.paragraph()
                para += [innernode, child]

                entry = nodes.list_item('')
                entry.append(para)
                entries.append(entry)

        resultnode = configurationblock()
        resultnode.append(nodes.bullet_list('', *entries))

        return [resultnode]

def visit_configurationblock_html(self, node):
    self.body.append(self.starttag(node, 'div', CLASS='configuration-block'))

def depart_configurationblock_html(self, node):
    self.body.append('</div>\n')

def visit_configurationblock_latex(self, node):
    pass

def depart_configurationblock_latex(self, node):
    pass

def setup(app):
    app.add_node(configurationblock,
                 html=(visit_configurationblock_html, depart_configurationblock_html),
                 latex=(visit_configurationblock_latex, depart_configurationblock_latex))
    app.add_directive('configuration-block', ConfigurationBlock)
