# zend-expressive Makefile
#
# Primary purpose is for generating the mkdocs.yml from the bookdown.json
# sources.
#
# Configurable variables:
# - BOOKDOWN2MKDOCS - specify the path to the executable; defaults to
#   				  ./vendor/bin/bookdown2mkdocs
#
# Available targets:
# - mkdocs   - regenerate mkdocs.yml
# - all      - synonym for mkdocs target

BOOKDOWN2MKDOCS?=$(CURDIR)/vendor/bin/bookdown2mkdocs.php

.PHONY : all mkdocs bookdown2mkdocs

all : mkdocs

mkdocs : 
	@echo "Generating mkdocs.yml from bookdown.json..."
	-$(BOOKDOWN2MKDOCS) convert --site-name=zend-code --repo-url=https://github.com/zendframework/zend-code --copyright-url=http://www.zend.com/ --copyright-author="Zend Technologies USA Inc."
	@echo "[DONE] Generating mkdocs.yml from bookdown.json"
