#include<stdio.h>
#include<string.h>
int main()
{
char str[100];
int state=0;
printf("Enter a string:");
scnf("%s",str);
for(int i=0;str[i]!='\0';i++)
{
    char ch=str[i];
    switch(ch)
    { 
        case 0:
        if (ch=="a")
        {
            state=1;
        }
        else if (ch=="b")
        {
            state=0;
        }
        else{
            break;
        }
        case 1:
        if (ch=="a")
        {
            state=1;
        }
        else if (ch=="b")
        {
            state=2;
        }
        else{
            break;
        }
        case 2:
        if (ch=="a")
        {
            state=1;
        }
        else if (ch=="b")
        {
            state=2;
        }
        else{
            break;
        }

    }
}
if(state==2)
{
    printf("the string is accepted by dfa");
}
else
{
    printf("the string is not accepted");
}
return 0;
}