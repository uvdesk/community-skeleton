#!/bin/bash
EXECPATH=`dirname $0`
cd $EXECPATH
cd ..

rm build -Rf
sphinx-build en build

sphinx-build -b latex en build/pdf
rubber --into build/pdf --pdf build/pdf/Doctrine2ORM.tex