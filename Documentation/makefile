STYLESHEETS_DIR = /usr/share/xml/docbook/stylesheet/nwalsh
.SUFFIXES: .pdf .fo .html .xml
XSLTPROC_OPTIONS = --xinclude
FOLDER_XML = XML/
FOLDER_PDF = pdf/
FOLDER_HTML = html/

LANGUAGES = en
FILES = index development

# a list of all buildable files in all languages
BUILDABLE_FILES = $(foreach lang,$(LANGUAGES),$(addprefix $(lang)/,$(FILES)))

all: pdf html readme

pdf: $(addsuffix .pdf,$(BUILDABLE_FILES)) 

html: $(addsuffix .html,$(BUILDABLE_FILES))

# build pdf files 
$(addsuffix .pdf,$(BUILDABLE_FILES)) : 
	xsltproc $(XSLTPROC_OPTIONS) -o $(FOLDER_PDF)$(subst .pdf,.fo,$@) $(STYLESHEETS_DIR)/fo/docbook.xsl $(FOLDER_XML)$(subst .pdf,.xml,$@)
	fop -pdf $(FOLDER_PDF)$@ -fo $(FOLDER_PDF)$(subst .pdf,.fo,$@)
	rm -rf $(FOLDER_PDF)$(subst .pdf,.fo,$@)

$(addsuffix .html,$(BUILDABLE_FILES)) : 
	xsltproc $(XSLTPROC_OPTIONS) -o $(FOLDER_HTML)$@ $(STYLESHEETS_DIR)/html/docbook.xsl $(FOLDER_XML)$(subst .html,.xml,$@)

readme: 
	xsltproc $(XSLTPROC_OPTIONS) --stringparam generate.toc 0 --stringparam  chapter.autolabel 0 -o ../README.html $(STYLESHEETS_DIR)/xhtml/docbook.xsl $(FOLDER_XML)en/readme.xml
	lynx -dump ../README.html -nolist -width 100 > ../README
	rm ../README.html

clean:
	rm -rf $(FOLDER_PDF) $(FOLDER_HTML)