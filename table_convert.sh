#!/bin/bash


DATABASE=learning_system_practice_tests;

#ROW_FORMAT=DYNAMIC
ROW_FORMAT=COMPRESSED

TABLES=$(echo SHOW TABLES | mysql -s $DATABASE)

for TABLE in $TABLES ; do
    echo "ALTER TABLE $TABLE ROW_FORMAT=$ROW_FORMAT;"
    echo "ALTER TABLE $TABLE ROW_FORMAT=$ROW_FORMAT" | mysql $DATABASE
done
