import os
import sys
import glob

import options as setting
import xlsToCsv as csvConverter
import csvParser as parser
import dbProvider as db

def printProgress(prefix="", iteration=1, maxIteration=1, size=30, file=sys.stdout):
	iteration = int(iteration)
	size = int(size)
	maxIteration = int(maxIteration)
	x = int(size*iteration/maxIteration)
	percent = 100*(float(iteration)/float(maxIteration))
	format = "%s [%s%s] %.0f%% %i/%i\r"
	format = format % (prefix, "#"*x, "."*(size-x), percent, iteration, maxIteration)
		
	file.write(format)
	file.flush()
	
	if iteration and maxIteration and iteration == maxIteration:
		print ""
	
if __name__ == "__main__":
	searchExt = "xlsx"
	convertExt = "csv"
	country = "id"

	# Clean csv file in src/csv directory
	array = glob.glob(setting.paths["csv"]+"/*")
	for item in array:
		os.remove(item)

	# 1. convert all xls files to csv
	array = glob.glob(setting.paths["xls"]+"/*."+str(searchExt))
	
	print "Start Convert .{0} to .{1}".format(searchExt, convertExt)
	print "Found .{0}: {1} file(s)".format(searchExt, len(array))
	
	if len(array) <= 0:
		sys.exit()
	
	iteration = 0
	printProgress("Convert file(s) to ."+convertExt, iteration, len(array))
	for item in array:
		list = item.split("/")
		filename = list[len(list)-1]
		filename = setting.paths["csv"]+"/"+filename.replace("."+searchExt,"."+convertExt)
		csvConverter.convert(item, filename)
		
		iteration+=1
		printProgress("Convert file(s) to ."+convertExt, iteration, len(array))
		
	# 2. create table
	connection = db.connect(
		setting.database["host"], 
		setting.database["user"], 
		setting.database["pwd"], 
		setting.database["database"]
	)
	connection.autocommit = False
	cursor = connection.cursor()
	
	db.drop(cursor, setting.database["table"])
	db.create(cursor, setting.database["table"])
	connection.commit()
	
	# 3. insert to table
	maxFilenameLength = 0
	for item in glob.glob(setting.paths["csv"]+"/*."+convertExt):
		filename = item.split("/")
		filename = filename[len(filename)-1].strip()
		maxFilenameLength = max([maxFilenameLength, len(filename)])
	
	def progressCallback(iteration, maxIteration):
		printProgress("Import file: %s " % filename, iteration, maxIteration)
		pass
	
	def parseCallback(code, name, line):
		# determin parent, with split its code
		split = code.split(".")
		parent = ""
		if (len(split) > 1):
			for index in range(len(split)-1):
				parent += "."+split[index] if len(parent)>0 else split[index]
		
		name = name.replace('"', '')
		db.save(cursor, setting.database["table"], country, code, name, parent)
		
		pass
		
	print "Import data to Database `"+ setting.database["database"] +"`.`"+ setting.database["table"] + "`"
	files = glob.glob(setting.paths["csv"]+"/*."+convertExt)
	files.sort()
	for item in files:
		filename = item.split("/")
		filename = filename[len(filename)-1].strip()
		
		if maxFilenameLength-len(filename) > 0:
			filename = filename + ( " " * (maxFilenameLength-len(filename)) )
			
		parser.parseFile(item, parseCallback, progressCallback)
		connection.commit()
	
	cursor.close()
	connection.close()