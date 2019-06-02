#!/bin/bash
date_str=$(date +%Y-%m-%d);
mysqldump -u 133794m3r -p $1 > /tmpdownload/"$date_str-$1";
