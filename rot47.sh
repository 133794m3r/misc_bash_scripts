#!/bin/bash
FILENAME=$1;
ENCODEDLINE='';
tmp='';
while read line
do
tmp="$(echo $line | tr 'A-Za-z' 'N-ZA-Mn-za-m')";
echo $tmp;
done < $FILENAME

