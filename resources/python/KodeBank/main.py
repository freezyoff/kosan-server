import urllib as URL
import sys, getopt
import datetime as Time

##
## Database configurations
## file: ./database/DB_Mysql.py
##
import database.DB_Mysql as Database

##
## return current time
##
def now(): 
	return Time.datetime.utcnow()

##
## Time elapsed from given time to current time (now)
##
## @param recorded - given recorded time
## @return elapsed time in milli seconds
def elapsedTime(recorded):
	delta = now() - recorded
	return str(round(delta.total_seconds(), 2)) + " seconds"
			

##
## Configurations
## file: ./config.py
##
import config as Config

##
## fetch url
##
def openUrl(url):
	f = URL.urlopen(url)
	return f.read()

def createDB():
	Database.create()

def importToDB():
	bankData = None
	for DOMHandler in Config.handler:
		sys.stdout.write("Process URL " + DOMHandler["url"] + " :\n")
		
		#load url
		ctime = now()
		sys.stdout.write(">> Fetch URL ")
		html = openUrl(DOMHandler["url"])
		sys.stdout.write("- done in " + str(elapsedTime(ctime)) + "\n")
		
		#parse html
		if DOMHandler["parser"] and html:
			ctime = now()
			sys.stdout.write(">> Parse DOM ")
			bankData = DOMHandler["parser"].parse( html )
			sys.stdout.write("- done in " + str(elapsedTime(ctime)) + "\n")
	
		#import to database
		if Database and bankData:
			sys.stdout.write(">> Import ")
			Database.insert(bankData)
			sys.stdout.write("- done in " + str(elapsedTime(ctime)) + "\n")
		
		sys.stdout.write("\n")
	
def main(argumentList):
	try:
		
		arguments, values = getopt.getopt(
			argumentList, 
			Config.systemArguments["options"], 
			Config.systemArguments["long_options"]
		) 
		
		Database.connect()
		cmd_create = False
		cmd_import = False
		for currentArgument, currentValue in arguments: 
			if currentArgument in ("-c", "--CreateDatabase"): 
				cmd_create = True
				
			if currentArgument in ("-i", "--Import"):
				cmd_import = True
		
		#create database
		if cmd_create:
			createDB()
		
		#import to database table
		importToDB()
		
	except getopt.error as err:
		# output error, and return with an error code 
		print (str(err)) 
		
	finally:
		#close database connection
		Database.disconnect()
	
		
	
## 
##	MAIN
##
if __name__ == '__main__':
	main(sys.argv[1:])