#!/bin/bash
file=/tmpdownload/debug
nvidia-settings -v >> $file
cat /etc/debian_vesion >> $file
uname -a >> $file
