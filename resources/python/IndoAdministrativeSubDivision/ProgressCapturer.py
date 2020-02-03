import sys, time, requests, json, random

def printReadProgress(key="", iteration=0, maxIteration=0, size=30, file=sys.stdout):
	if iteration and maxIteration:
		iteration = int(iteration)
		size = int(size)
		maxIteration = int(maxIteration)
		x = int(size*iteration/maxIteration)
		percent = 100*(float(iteration)/float(maxIteration))
		format = "Kata kunci: '%s' -> mengambil data: [%s%s] %.0f%% %i/%i\r"
		format = format % (key, "#"*x, "."*(size-x), percent, iteration, maxIteration)
	else:
		format = "Kata kunci: '%s' -> koneksi ke BPS ...\r" % (key)
	
	file.write(format)
	file.flush()
	
	if iteration and maxIteration and iteration == maxIteration:
		print ""
	
def printSaveProgress(iteration=0, maxIteration=0, size=30, file=sys.stdout):
	iteration = int(iteration)
	size = int(size)
	maxIteration = int(maxIteration)
	x = int(size*iteration/maxIteration)
	percent = 100*(float(iteration)/float(maxIteration))
	file.write("Menyimpan: [%s%s] %.0f%% %i/%i\r" % ("#"*x, "."*(size-x), percent, iteration, maxIteration))
	file.flush()
	if iteration == maxIteration:
		print ""

current_search_key = ""
def updateReadProgress(currentValue, maxValue, search_key=""):
	global current_search_key
	if search_key:
		 current_search_key = search_key
		
	printReadProgress(
		current_search_key, 
		iteration=currentValue, 
		maxIteration=maxValue)
	pass
	
def updateSaveProgress(currentValue, maxValue):
	printSaveProgress(iteration=currentValue, maxIteration=maxValue)
	pass