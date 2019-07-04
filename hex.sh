#/bin/bash
echo -e ` bc <<!
obase=16; "0x"; $1;
!`;
