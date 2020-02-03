import pandas as exporter
import glob

def convert(src, dest):
	read_file = exporter.read_excel(src)
	read_file.to_csv(dest, index = None, header=True)
	
# convert all files in directory
# @param srcDir (list) - source dir path 
# @param srcExt (string) - source file extension
# @param destDir (string) - destination path
def convertAll(srcDir, srcExt, destDir):
	for item in glob.glob(srcDir+"/*."+str(srcExt)):
		list = item.split("/")
		filename = list[len(list)-1]
		exportToCsv(item, destDir+"/"+filename.replace("."+srcExt,".csv"))
