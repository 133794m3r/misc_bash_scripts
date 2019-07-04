#!/usr/bin/php
<?php
echo var_dump($argv);
function generate_next_palindrome($number,$n){
    $mid=floor($n/2);
    $i=$mid-1;
    $j=(( ($n % 2) === 0) ? $mid : $mid+1);
    $leftsmaller=false;
    $num=$number;
    while($i >= 0 && $num[$i] === $num[$j]){
        $i--;
        $j++;
    }
        
    if($i < 0 || $num[$i] < $num[$j]){
        $leftsmaller=true;
    }
    
    while($i >= 0){
        $num[$j++] = $num[$i--];
    }
    echo "n:$num[$mid]".PHP_EOL;
    if($leftsmaller){
        $carry=1;
        
        if(($n % 2 === 1) && ($num[$mid] <= 9)){
            $num[$mid]+=1;
            $carry=floor($num[$mid]/10);
            $num[$mid]=$num[$mid]%10;
        }
        $i=$mid-1;
        $j= ( ( ($n % 2) === 0) ? $mid : $mid +1);
        
        while($i>=0){
            $num[$i]=$num[$i] + $carry;
            $carry=floor($num[$i]/10);
        echo "c:$num[$i]".PHP_EOL;
            $num[$i]=$num[$i]%10;
            $num[$j]= $num[$i];
            $i--;
            $j++;
        }

    }

    return $num;
}

function is_all_9s($num,$n){
    for($i=0;$i<$n;$i++){
        if($num[$i] != 9)
            return false;
       }
        return true;
}

function generate_9s_palindrome($num,$n){
    $new_arr=array();
    $new_array[0]=1;
    for($i=1;$i<$n;$i++){
        $new_array[$i]=0;
    }
    $new_array[$i]=1;

    return $new_array;
}

function gen_palindrome($argv){
    $str=$argv[1];
    $num=str_split($str);
    $n=strlen($str);
    $palindrome=array();
    echo 'a';var_dump($num);
    if(is_all_9s($num,$n)==true){
        $palindrome=generate_9s_palindrome($num,$n);
    }
    else{
        $palindrome=generate_next_palindrome($num,$n);
    }
    var_dump($palindrome);
    $palindrome=join($palindrome,'');
    echo $palindrome.PHP_EOL;
}

gen_palindrome($argv);
?>
