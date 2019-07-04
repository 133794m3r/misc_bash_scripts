#!/bin/bash
#a Number guessing game that's riced up written entirely in BASH
#Macarthur Inbody <mdi2455@email.vccs.edu> 2019-
#The function declaration syntax.
min=1;
max=10;
delay=0.0625;
function get_random_number() {
#local says the variable shouldn't be exposed outside of function
local min=$1;
local max=$2;
#todo math you have to do it inside of a subshell $((<Expression> ))
#we are returning a status code instead of to stdout to make it look more like a normal
#program. Normally you'd echo the output and then capture it inside of a subshell.
return $(( ($RANDOM % $max ) + $min ));
}
function lucky_number_guesser(){
clear;
local do_it_again=0;
local delay2=$( echo - | awk "{print $delay/2}");

get_random_number $min $max;
#to get the value you have to utilize $? as a hack.
#really what the previous function did was output a return status. To make it output to
#stdout then we'd have to make this block
#random_number=$(( get_random_number 1 10));
local random_number=$?;
local your_number=0;
local guesses=0;
local guesses_max=15;
while [[ $guesses -ne $guesses_max ]]; do
slow_print_string $delay2 "Enter your number from $min to $max." 1;

read your_number
if [[ $your_number -lt $random_number ]]; then
slow_print_string $delay2 'Sorry your guess is too low.' 1;

elif [[ $your_number -gt $random_number ]]; then
slow_print_string $delay2 'Sorry your guess is high.' 1;

elif [[ $your_number -eq $random_number ]]; then
break;
else
slow_print_string $delay2 'Your guess was not in the valid range' 1;

fi
guesses=$(( guesses+1 ));
done;

if [[ $your_number -eq $random_number ]];then
slow_print_string $delay2 "You are correct the lucky number was $random_number" 1;
fi

slow_print_string $delay 'Do you wish to play again?' 1;

slow_print_string $delay 'Y/N' 1; 

read play_again
case $play_again in
    'y'|'Y'|'Yes'|'YES')
	do_it_again=1;;
    *)
       do_it_again=0;;
esac
return $do_it_again;
}
function lucky_numbers(){
clear;
local do_it_again=1;
while [[ $do_it_again -eq 1 ]]; do
lucky_number_guesser;
do_it_again=$?
done
slow_print_string $delay 'Goodbye \e[1mDavid\e[0m. I am ready to play a more interesting game when you are.' 1;
return 0;
}
function slow_print_string(){
local delay=$1;
local string=$2;
local i=0;
#local string_array;
#string_array=$(declare -p string_array);
local string_len=${#string};
local tmp_str='';
#read -r -a string_array <<< "$string";
#for (( i=0; i<$string_len; i++ )){
#    string_array[$i]=${string:$i:1};
#}
#local string_array_len=${#string_array};
#sleep $delay; echo -n ${string_array[i]};
#for ((i=1; i<$string_array_len; i++)){
#    sleep $delay; echo -n ' '${string_array[i]};
for ((i=0; i<$string_len; i++ )){
    sleep $delay; echo -n "${string:$i:1}";
# echo $i;
}
sleep $delay;
if [[ $3 ]]; then
echo '';
fi
return 0;
}
function main(){
local answer='';
slow_print_string $delay 'Shall we play a game?' 1;
#echo '';
slow_print_string $delay 'Y/N' 1

read answer;
case $answer in
    'y'|'Y'|'Yes'|'yes')
    lucky_numbers;;
    'Thermo Nuclear War'|'THERMO NUCLEAR WAR'|'thermo nuclear war')
        slow_print_string $delay 'I am sorry but the game Thermo Nuclear War is not available right now.' 1;
        slow_print_string $delay 'The missles have ';
        echo -ne '\e[1;3m'
        slow_print_string $delay 'already been launched';
        echo -ne '\e[0m'
        slow_print_string $delay '.' 1;
        slow_print_string $delay 'Goodbye'; 
        echo -en '\e[1m';
        slow_print_string $delay 'David';
        echo -en '\e[0m';
        slow_print_string $delay '.' 1;;
    *)
    slow_print_string $delay 'Maybe next time.' 1;
        slow_print_string $delay 'Goodbye ';
        echo -en '\e[1m';
        slow_print_string $delay 'David';
        echo -en '\e[0m';
        slow_print_string $delay '.' 1;;
    
    esac;
}
main;
