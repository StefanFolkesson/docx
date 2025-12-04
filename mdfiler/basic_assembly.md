### Basic Assembly
This is an abbreviated version of Assembly but the gist of it is in this code. 

## Parts of the CPU
The CPU is made up of two parts. 

# The Control Unit (CU)
The control unit is responsible for handlig the the instructions and sending data where it should be. 
# The Arithmetic Logic Unit (ALU)
The ALU isresponsible for ecery calculation and stores the result in th Accumulator (AC)

## The registers
We have a couple of registers where the processor stores the commands.

# Instruction Register (IR)
Here you store the actove instruction. o you know what to do.
# Program Counter (PC)
Here you store where in the memory yher program is right now. 
# Memory Address Register (MAR)
This register provides you with the address where the instruction can read data from or write data to. 
# Memory Data Register (MDR)
This holds the data that has been fetched or isabout to be written to the memory address (MAR)
# Accumulator (AC)
This stores the logical results produced by the ALU


## Instructions 
Every instruction is has two parts. The first number is the instruction in it self and the second part is the address where the data is stored. 

There are several instructions:
* 1xx -  ADD - Add the value from the specified memory address to the AC
* 2xx -  SUB - Subtract the value from the specified memory address in the AC
* 3xx - STA - Store the value in AC to the specified memory address
* 5xx - LDA -Load the value from the specified address toe the AC
* 6xx - BRA - Branch (Jump) to the specified memory adress (not the value in the adress)
* 7xx - BRZ - If AC is zero then jump to the specified memory address
* 8xx - BRP - If AC is positive then jump to specified  memory address
* 901 - INP - Input a value and store in the AC
* 902 - OUT - Output the value from the AC
* 000 - HLT - Halt the program

## The Memory
Every memory slot has an address so we know where it is in the RAM. In our abbreviated world the memory adress is two digits witch means that we only have 00 to 99 memory slots. in the real computer the address i much longer and therefore there are a lot more slots. After the addres there is an instruction and in our example the instruction consist of three digits but in a read computer the instruction is a lot longer.
Our example: 

```
00 505   ; Fetch from address 05 to AC 
01 104   ; Add value in address 04 to AC
02 305   ; Store AC to address 05
03 000   ; Halt
04 034
05 103
```

Real computer example (16 bits):
```
A0 34 12    ; fetch from address 1234 to AC
04 05       ; add 5 to AC
A2 34 12    ; save AC to address 1234
```

In our example we use decimal system since its the system we are used to work with but in the other example we use hexadecimal system since that is tha system the computer allways use. 

## Assignment
1.
Use our system and write the code for adding five numbers with input and then output the result

2.
Expand assignment 1 to also calculate the average using integer division of theese five numbers. 