<?php
//To know if a year is a leap year, it must obey 3 conditions:
// divisible by 4, not by 100 or divisible by 400

function isLeapYear($year) {
    if (($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0)){
        return true;
    } else {
        return false;
    }
}

//Ideas :

/* 
25/04/2025:
Store the days of the week in a array (or object), mon to sunday, associate it with a number (1 to 7),
get the current day from DateTimeImmutable, match it to the number with a comparison:

To compare:
The values from DateTimeImmutable(l) = string "Monday"

Could try looping thro an array comparing the strings (make sure to turn everything to lowercase to avoid
problems case day comes in with capital 1st letter). Associate it with a number so it knows which int of
week we're currently on.

For the month and it's days data : Could create an array or object that contains the name of month along with it's days
add extra "13th" month case for february case it's a leap year and it has 29 days instead of 28

Use DateTimeImmutable to get the year : check if it's a leap year with the formula, return a bool,
if true : use february 29 days
else : february 28 days

Get the current month name with DateTimeImmutable re do the same concept for the week days to turn
string name into an int.

overall output should look like :

Year leap : 2025 false - current month : april so 30 days - current day : 25 - Friday (5)

Now we might be abble to create a loop to construct the calendar :

-if day = 7 , we start over from 1
-if monthday = month.days(int), we start from -1 from current month.day ?

Problems : when to stop the loop to render days that have passed ? instead of going to the next month...

TOCHECK : other values from DateTimeImmutable() for better logic
*/