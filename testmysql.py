#!/usr/bin/env python
import MySQLdb
db = MySQLdb.connect("localhost","root","password","km07") #Let's python handle MySQLdb
curs=db.cursor()
try:
	curs.execute ("""INSERT INTO rawdata values (CURRENT_DATE(),NOW(),1,2,3,4,5,6.0)""")

	db.commit()
	print "Data committed"
	
except:
	print "Error: the database is being rolled back"
	db.rollback()
