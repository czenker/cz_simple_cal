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

all: pdf

pdf: $(addsuffix .pdf,$(BUILDABLE_FILES)) 

# build pdf files 
$(addsuffix .pdf,$(BUILDABLE_FILES)) : 
	xsltproc $(XSLTPROC_OPTIONS) -o $(FOLDER_PDF)$(subst .pdf,.fo,$@) $(STYLESHEETS_DIR)/fo/docbook.xsl $(FOLDER_XML)$(subst .pdf,.xml,$@)
	fop -pdf $(FOLDER_PDF)$@ -fo $(FOLDER_PDF)$(subst .pdf,.fo,$@)
	rm -rf $(FOLDER_PDF)$(subst .pdf,.fo,$@)

clean:
	rm -rf $(FOLDER_PDF)