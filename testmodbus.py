#!/usr/bin/env python
import minimalmodbus
import time
from datetime import datetime

instrument = minimalmodbus.Instrument('/dev/ttyAMA0', 1, mode='rtu') # port name, slave address (in decimal)
instrument.serial.baudrate=9600

#instrument.debug=True
#v1=0.0
pf1=0.0

def readvoltage():
	while True:
		try:
			time.sleep(0.004)
			v1 = (instrument.read_long(257,4,False))/10.0
		except:
			#print ("Got some readvoltage read error")
			continue
		else:
			#print ("Received Voltage Data")
			break
	return v1
def readpf():
	while True:
		try:
			time.sleep(0.004)
			pf1 = (instrument.read_register(0,0,4,True))/1000.0
		except:
			#print ("Got some Power Factor read error")
			continue
		else:
			#print ("Received Power Factor Data")
			break
	return pf1
def readamp():
	while True:
		try:
			time.sleep(0.004)
			amp1 = (instrument.read_long(269,4,False))/1000.0
		except:
			print ("Got some Amps read error")
			continue
		else:
			print ("Received Amps Data")
			break
	return amp1

while True:
	print datetime.now() #timestamp start
	volt=readvoltage()
	amp=readamp()
	pf=readpf()
	print "%s Voltage %s Amp PF=%s" %(volt,amp,pf)
	print datetime.now() #timestamp stop
	time.sleep(10)
