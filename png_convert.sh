#/bin/bash
#find -iname *.jpg > tmp;
sed -i "s/\.\///" tmp;
let a=0;
FILENAME=tmp;
while read line
do
#cd $line;
#echo $line;
convert -quality 00 "$line.jpg" "$line.png";
#cp "$line" "$a.jpg";
let a=a+1;
sleep 0.125;
if[[ $a -ge 256 ]];
then
sleep 1.5;
fi

done < $FILENAME
