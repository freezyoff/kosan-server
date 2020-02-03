import options as opt
import re
import glob

def isValidCodeWithDot(str):
	dot = str.split(".")
		
	for item in dot:
		if not item.isdigit():
			return False
	
	# check province code, we need exactly 2 digit
	lenDot = len(dot)
	
	if len(dot[0]) != 2:
		return False
	
	# check if has regency code
	if (lenDot > 1):
		# we need exactly 2 digit
		if (len(dot[1]) != 2):
			return False
			
	# check if has district code
	if (lenDot > 2):
		# we need exactly 2 digit
		if (len(dot[2]) != 2):
			return False
	
	# check if has village code
	if (lenDot > 3):
		# we need exactly 4 digit
		if (len(dot[3]) != 4):
			return False
	
	return True
		
# check if given line start with administrative code number			
def isStartWithCode(list):
	# check if start with code number
	if ("." in list[0]):
		return isValidCodeWithDot(list[0])
		
	return list[0].isdigit() and len(list[0]) == 2

# we determine the line string is page number if no string in line
# @param list (list)
def isPageNumber(list):
	return ("".join(list)).strip().isdigit()

def extractName(list, prefix=["provinsi", "kabupaten", "kota", "kecamatan", "desa", "keluarahan"]):
	code = ""
	prefixIndex = -1
	
	for i in range(len(list)):
		
		# check code
		if i == 0:
			code = list[i].strip()
			code = code.split(".")
			if len(code) == 1:
				prefixIndex = 0
			elif len(code) == 2:
				code = code[1]
				prefixIndex = 1 if int(code[0:1]) < 7 else 2
			elif len(code) == 3:
				prefixIndex = 3
			elif len(code) == 4:
				code = code[3]
				prefixIndex = 4 if int(code[0:1]) == 2 else 5
			else:
				prefixIndex = -1
			
			continue
		
		if not list[i].isdigit() and len(list[i])>0:
			list[i] = re.sub("[0-9]","",list[i]).strip().lower()
			list[i] = re.sub("\s+"," ",list[i]).strip().lower()
			
			# IMPORTANT: 
			# fix wrong convert name due to bad pdf to xls conversion
			# we found that sometimes name don't convert perfectly from pdf to excel
			#
			# check provinsi name
			if prefixIndex == 0:
				split = list[i].split(" ")
				finds = ["prov.", "provinsi"]
				for str in finds:
					loop = 0
					maxLoop = len(str)
					while (loop <= maxLoop):
						loop += 1
						if split[0] == str[0:loop]:
							list[i] = " ".join(split[1:])
			
			# check for regency name
			elif prefixIndex == 1 or prefixIndex  == 2:
				split = list[i].split(" ")
				finds = ["kabupaten", "kab.", "kota"]
				for str in finds:
					loop = 0
					maxLoop = len(str)
					while (loop <= maxLoop):
						loop += 1
						if split[0] == str[0:loop]:
							list[i] = " ".join(split[1:])
			
			# check for district
			elif prefixIndex == 3:
				split = list[i].split(" ")
				finds = ["kec.", "kecamatan"]
				for str in finds:
					loop = 0
					maxLoop = len(str)
					while (loop < maxLoop):
						loop += 1
						if split[0] == str[0:loop]:
							list[i] = " ".join(split[1:])
			
			# check for villages
			elif prefixIndex == 4 or prefixIndex == 5:
				split = list[i].split(" ")
				finds = ["desa", "ds.", "kel.", "kelurahan"]
				for str in finds:
					loop = 0
					maxLoop = len(str)
					while (loop <= maxLoop):
						loop += 1
						if split[0] == str[0:loop]:
							list[i] = " ".join(split[1:])
				
			return prefix[prefixIndex] + " " + list[i] if prefixIndex > -1 else list[i]
				
	return None

def parseLine(line, callback):
	# 1. replace comma between quotes
	str = re.sub(r',(?=\d+")', '.', line)
	split = str.split(",")
	
	# 2. check if page number
	if isPageNumber(split):
		return None
	
	# 3. check is valid line (start with code)
	if isStartWithCode(split):
		if callback:
			callback(split[0], extractName(split), line.strip())

def parseFile(file, parseCallback, progressCallback):
	
	iteration = 0
	maxIteration = len(open(file).readlines())
	progressCallback(iteration, maxIteration)
		
	# parse per line
	with open(file) as f:
		for line in f:
			parseLine(line, parseCallback)
			iteration += 1
			progressCallback(iteration, maxIteration)
	pass	

	
if __name__ == "__main__":
	print extractName("22.72,ko test saja,,,,,,".split(","))