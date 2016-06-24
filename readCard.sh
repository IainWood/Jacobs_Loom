#!/bin/bash
 
 clear
echo "Welcome"
while[1]
do
        echo "Please Swipe Your Card: (Press Enter to Exit)"
        read data

        if[ "$data" = "" ]
        then
                echo"Exiting"
                exit 0

        clear
        num="$(echo "$data"|cut -d\% -f2|cut -d\\n -f1)"
        track1="$echo "$data"|cut -d\% -f2|cut -d\? -f2)"
        track2="$echo "$data"|cut -d\; -f2|cut -d\? -f2)"
        track3="$echo "$data"|cut -d\+ -f2|cut -d\? -f2)"

        echo "FULL LINE: $num"
        echo "Track 1: $track1"
        echo "Track 2: $track2"
        echo "Track 3: $track3"
        echo "-------------------------------"
done
