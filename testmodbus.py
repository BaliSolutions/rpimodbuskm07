#!/usr/bin/env python
import minimalmodbus
import time

instrument = minimalmodbus.Instrument('/dev/ttyAMA0', 1, mode='rtu') # port name, slave address (in decimal)
instrument.serial.baudrate=19200

#instrument.debug=True
v1=0.0
pf1=0.0

while True:
	try:
		v1 = (instrument.read_long(257,4,False))/10.0
		time.sleep(0.5)
		pf1 = (instrument.read_register(0,0,4,True))/1000.0
		time.sleep(0.5)
	except IOError:
		print("Failed to read from instrument")
	except ValueError:
		print("Checksum error")
	print v1
	print pf1
