#!/usr/bin/env python
import minimalmodbus
import time
import MySQLdb
import math
from datetime import datetime

instrument = minimalmodbus.Instrument('/dev/ttyAMA0', 1, mode='rtu') # port name, slave address (in decimal)
instrument.serial.baudrate=9600

db = MySQLdb.connect("localhost","root","password","km07") #Let's python handle MySQLdb
curs=db.cursor() #Cursor to execute MySQL Command

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
			#print ("Got some Amps read error")
			continue
		else:
			#print ("Received Amps Data")
			break
	return amp1
def readkW():
	while True:
		try:
			time.sleep(0.004)
			if (instrument.read_register(275,0,4,False))>=3:
				div=1000.0
			else:
				div=10000.0
			time.sleep(0.004)
			kw1 = (instrument.read_long(277,4,True))/div
		except:
			#print ("Got some Amps read error")
			continue
		else:
			#print ("Received Amps Data")
			break
	return kw1
def readkVar():
	while True:
		try:
			time.sleep(0.004)
			if (instrument.read_register(275,0,4,False))>=3:
				div=1000.0
			else:
				div=10000.0
			time.sleep(0.004)
			kvar1 = (instrument.read_long(283,4,True))/div
		except:
			#print ("Got some Amps read error")
			continue
		else:
			#print ("Received Amps Data")
			break
	return kvar1
def readkVA():
	while True:
		try:
			time.sleep(0.004)
			if (instrument.read_register(275,0,4,False))>=3:
				div=1000.0
			else:
				div=10000.0
			time.sleep(0.004)
			kva1 = (instrument.read_long(289,4,True))/div
		except:
			#print ("Got some Amps read error")
			continue
		else:
			#print ("Received Amps Data")
			break
	return kva1
def readTotalkWh():
	while True:
		try:
			time.sleep(0.004)
			if (instrument.read_register(537,0,4,False))<=1:
				mul=1.0
			else :
				mul=1000.0
			time.sleep(0.004)
			kexp = instrument.read_register(536,0,4,False)
			time.sleep(0.004)
			totalkwh = ((instrument.read_long(543,4,True))*mul)/math.pow(10,kexp)
		except:
			#print ("Got some Amps read error")
			continue
		else:
			#print ("Received Amps Data")
			break
	return totalkwh

lasttotalkwh=readTotalkWh()
while True:
	print datetime.now() #timestamp start
	volt=readvoltage()
	amp=readamp()
	pf=readpf()
	kw=readkW()
	kvar=readkVar()
	kva=readkVA()
	totalkwh=readTotalkWh()
	kwh=totalkwh-lasttotalkwh
	print "%s Voltage %s Amp PF=%s" %(volt,amp,pf)
	print "%s Kw %s KVar %s KVA" %(kw,kvar,kva)
	print "%s Total kWh" %(kwh)
	print "======================================="
	try:
		curs.execute ("""INSERT INTO rawdata values (CURRENT_DATE(),NOW(),%s,%s,%s,%s,%s,%s,%s)""", (volt,amp,pf,kw,kvar,kva,kwh))
		db.commit()
		print "Data committed"
	except:
		print "Error: the database is being rolled back"
		db.rollback()
	lasttotalkwh=totalkwh
	time.sleep(60)