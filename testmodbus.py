#!/usr/bin/env python
import minimalmodbus
import time

instrument = minimalmodbus.Instrument('/dev/ttyAMA0', 1, mode='rtu') # port name, slave address (in decimal)
instrument.serial.baudrate=9600

#instrument.debug=True

while True:
	try:
		v1 = instrument.read_long(257,4,False)
	except IOError:
		print("Failed to read from instrument")
	v1=v1/10.0
	print  v1
	time.sleep(1)
	
	try:
		pf1 = instrument.read_register(0,0,4,True)
	except IOError:
		print("Failed to read from instrument")
	except ValueError:
		print("Checksum error")
	pf1=pf1/1000.0
	print pf1
	time.sleep(1)
