#include <stdio.h>
#include <stdlib.h>
#include <string.h>


int main(){
    scanf("%d",&n);
    char line[100];
    getchar();
    for (int i=0;i<n;i++){
       scanf("%s",line);
       int len=strlen(line); 
       for (int j=0;j<len;j++){
            char first = line[j];
        char second = line[j + 1];
       }
    }