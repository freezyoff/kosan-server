from DOMParser import parser as DOMParser
import ProgressCapturer as Progress
import DataProvider
import DBProvider

db_host = "localhost"
db_usr = "kosan"
db_pwd = "kosansukses!"
db_schema = "kosan_system"
db_table = "id_regions"

def main(keys, rebuild_db):
	# collect all data
	collections = []
	
	# start loop until keys empty
	while len(keys) > 0:

		# remove first index from keys
		key = keys.pop(0)
		if not key:
			continue
		
		# init read progress 
		Progress.updateReadProgress(0, 0, search_key=key)
		
		# get the data
		result = DataProvider.get(key, Progress.updateReadProgress)
		
		if len(result["collections"]) == int(result["count"]):
			collections.extend(result["collections"])
		else:
			#its failed, put back keys
			keys.append(key)
	
	#saving
	DBProvider.saveAndUpdate(
		db_host, 
		db_usr, 
		db_pwd, 
		db_schema, 
		db_table, 
		collections, 
		Progress.updateSaveProgress,
		rebuild_db
	)
	pass

##
## MAIN
##
if __name__ == '__main__':
	print "Generate Database"
	print "Provinsi, Kabupaten/Kota, Kecamatan, dan Kelurahan"
	print "Wilayah Pemerintahan Republik Indonesia"
	print "----------------------------"
	print "Data sumber berasal dari situs Pemutakhiran MFD dan MBS Badan Pusat Statistik"
	print "URL: http://mfdonline.bps.go.id/"
	print "----------------------------"
	print "Penggunaan: "
	print "1. Masukkan kata kunci sesuai keinginan"
	print "2. Pisahkan dengan spasi jika kata kunci lebih dari satu"
	print "3. Biarkan kosong apabila ingin generate seluruh data (menggunakan kata kunci 'a','i','u', 'e', dan 'o')"
	print "4. Tekan enter untuk memulai"
	print "----------------------------"
	keys = raw_input("Kata Kunci Pencarian Desa: ")
	keys = keys.split()
	print "----------------------------"
	rebuild = raw_input("Buat ulang database [y|n]: ")
	while (True):
		if rebuild == "y" or rebuild == "n":
			break
		else:
			rebuild = raw_input("Buat ulang database [y|n]: ")
			continue
	print "----------------------------"
	main(
		keys if len(keys)>0 else ["a","i","u","e","o"], 
		True if rebuild=="y" else False
	)