#!/bin/bash

echo "Running this script will create the required DBM::Deep DB files"
echo "from the tab-delimited text files in '../data'."
echo ""
echo "DBM::Deep data files should end up approximately the following sizes:"
echo ""
echo "325M orthomcl_clusters.db"
echo " 13M orthomcl_clusters.function.db"
echo " 46M orthomcl_clusters.membership.db"
echo ""
echo "Run './test_db.pl' for a basic usability test"
echo ""
echo "Running './prep_db.pl' now..."
echo "..."
echo "[this will take a while, and only output produced is the '*.db' files]"
echo "..."

./prep_db.pl

echo "Files created, moving to '../db' ..."

mv -v orthomcl_clusters.*db ../db/

echo "...done."
