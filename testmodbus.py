#!/usr/bin/env python
import minimalmodbus
import time

instrument = minimalmodbus.Instrument('/dev/ttyAMA0', 1, mode='rtu') # port name, slave address (in decimal)
instrument.serial.baudrate=9600

#instrument.debug=True
#v1=0.0
pf1=0.0

def readvoltage():
	while True:
		try:
			v1 = (instrument.read_long(257,4,False))/10.0
			#time.sleep(0.5)
		except:
			print ("Got some readvoltage read error")
			continue
		else:
			print ("Received Voltage Data")
			break
	return v1
def readpf():
	while True:
		try:
			pf1 = (instrument.read_register(0,0,4,True))/1000.0
			#time.sleep(0.5)
		except:
			print ("Got some Power Factor read error")
			continue
		else:
			print ("Received Power Factor Data")
			break
	return pf1

while True:
	volt=readvoltage()
	pf=readpf()
	"""try:
		#v1 = (instrument.read_long(257,4,False))/10.0
		#time.sleep(0.5)
		#pf1 = (instrument.read_register(0,0,4,True))/1000.0
		#time.sleep(0.5)
	except IOError:
		print("Failed to read from instrument")
	except ValueError:
		print("Checksum error")"""
	print volt
	print pf
	time.sleep(10)
