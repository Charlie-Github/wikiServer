#!/bin/sh  

	Dsize=`du -s`
	Oldsize=$Dsize

while : ; do 
	Dsize=`du -s`
    if [[ "$Dsize" != "$Oldsize" ]];
     then  
        echo "0"  
    fi  
    Oldsize=$Dsize
    echo "1"
    sleep 2  
done