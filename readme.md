# MySensors Php API

This class implements methods to directly send messages (and get answers) to a [MySensors](http://www.mysensors.org) Ethernet gateway.


### Files
- **example.php** : Basic usage example
- **src/mysensors.class.php** : main class
- **src/mysensors_bin.php** : excecutable script to send/receive message from the command line


### Command Line
Here is the *mysensors_bin.php* help.

	soif@server:~# ./mysensors_bin.php -h
	Usage: 
		mysensors_bin.php [-p port] [-avh] IP COMMAND
	
		-p port 	: set the gateway port if not 5003
		-a		: send an ACK
		-v 		: verbose (show message sent to gateway)
		-h 		: show this help
	
		IP		: (required) Gateway IP address

		COMMAND		: (required) is one of the following commands:
			- present NODE CHILD TYPE
			- set NODE CHILD TYPE PAYLOAD
			 -req NODE CHILD TYPE
			 -internal NODE CHILD TYPE
			 -internal_get NODE CHILD TYPE

			Using the following parameters :
			- NODE 		: Node ID
			- CHILD		: Child Sensor ID
			- TYPE		: Sub Type
			- PAYLOAD	: value to send
	Examples:
		mysensors_bin.php 192.168.0.240 set 12 0 V_STATUS 0	
		mysensors_bin.php -a 192.168.0.240 present 12 0 V_STATUS 1
		mysensors_bin.php -a -p 5002 192.168.0.240 present 12 0 V_TEMP

## Disclaimer
Missing some documentation about the MySensors messages protocol, some features may not work as expected (ie the *req* command was not tested). So I won't be responsible if you'd burn your house or kill a cat by using this software! ;-)

## Contributions
Contributions are welcome ! Please fork this at GitHub and submit PR to the **develop** branch.