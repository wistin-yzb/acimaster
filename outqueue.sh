#!/bin/bash  
  
step=5 #间隔的秒数，不能大于60  
  
for (( i = 0; i < 60; i=(i+step) )); do  
    $(/usr/bin/php '/usr/local/etc/outqueue.php')  
    sleep $step  
done  
  
exit 0
