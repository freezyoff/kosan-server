import sys, time, requests, json, random
import mysql.connector
from HTMLParser import HTMLParser

def showReadProgress(key="", iteration=0, maxIteration=0, size=30, file=sys.stdout):
	
	format = ""
	if iteration and maxIteration:
		iteration = int(iteration)
		size = int(size)
		maxIteration = int(maxIteration)
		x = int(size*iteration/maxIteration)
		percent = 100*(float(iteration)/float(maxIteration))
		format = "Read Key: '%s' -> [%s%s] %.0f%% %i/%i\r"
		format = format % (key, "#"*x, "."*(size-x), percent, iteration, maxIteration)
	else:
		format = "Read Key: '%s' -> load url, waiting ...\r" % (key)
	
	file.write(format)
	file.flush()
	
	if iteration and maxIteration and iteration == maxIteration:
		print ""
	
def showSaveProgress(iteration=0, maxIteration=0, size=30, file=sys.stdout):
	iteration = int(iteration)
	size = int(size)
	maxIteration = int(maxIteration)
	x = int(size*iteration/maxIteration)
	percent = 100*(float(iteration)/float(maxIteration))
	file.write("Saving -> [%s%s] %.0f%% %i/%i\r" % ("#"*x, "."*(size-x), percent, iteration, maxIteration))
	file.flush()
	if iteration == maxIteration:
		print ""
		
class HTMLReader(HTMLParser):
	_handle_tr_ = False
	_handle_td_ = False
	_collection_ = []
	_current_item_ = None
	
	_has_row_number_ = False
	_has_province_ = False	#propinsi
	_has_regency_ = False 	#kabupaten / kota
	_has_district_ = False 	#kecamatan
	_has_village_ = False	#kelurahan
	
	_code_ = None
	_row_count_ = 0
	_current_search_key_ = ""
	
	def flush(self):
		self._handle_tr_ = False
		self._handle_td_ = False
		self._collection_ = []
		self._current_item_ = None
		
		self._has_row_number_ = False
		self._has_province_ = False
		self._has_regency_ = False
		self._has_district_ = False
		self._has_village_ = False
		
		self._code_ = None
		self._row_count_ = 0
		self._current_search_key_ = ""
	
	def handle_starttag(self, tag, attrs):
		if tag == 'tr' and ("class","table_content") in attrs:
			self._handle_tr_ =  True
			
		if self._handle_tr_ and tag == 'td':
			self._handle_td_ = True
	
	def handle_endtag(self, tag):
		if self._handle_tr_ and tag == 'tr':
			self._handle_tr_ = False
			
			#restart data capture
			self._has_row_number_ = False
			self._has_province_ = False
			self._has_regency_ = False
			self._has_district_ = False
			self._has_village_ = False
			
			self._code_ = None
			self._string_ = None
	
		if self._handle_tr_ and self._handle_td_ and tag == 'td':
			self._handle_td_ = False
			
	def handle_data(self, data):
		if "desa/kelurahan di Indonesia dengan nama seperti" in data:
			for item in data.split():
				if item.isdigit():
					self._row_count_ = item
		
		if not self._handle_tr_ and not self._handle_td_:
			return;
		
		data = data.strip()
		if not data:
			return;
		
		#capture row number
		if data.isdigit() and not self._has_row_number_:
			self._has_row_number_ = True
			self._current_item_ = {"row":data}
			return;
			
		#capture province id & name
		elif self._has_row_number_ and not self._has_province_:
			self.capture_province(data)
		
		#capture kabupaten/kota id & name
		elif self._has_province_ and not self._has_regency_:
			self.capture_regency(data)
		
		#capture kecamatan id & name
		elif self._has_regency_ and not self._has_district_:
			self.capture_district(data)
			
		#capture kelurahan/desa id & name
		elif self._has_district_ and not self._has_village_:
			self.capture_village(data)
			
		capture_complete = self._has_row_number_ and \
							self._has_province_ and \
							self._has_regency_ and \
							self._has_district_ and \
							self._has_village_
		if capture_complete:
			self._collection_.append(self._current_item_)
		
		if self._row_count_:
			showReadProgress(self._current_search_key_, len(self._collection_), self._row_count_)
		
		pass
	
	def capture_province(self, data):
		if data.isdigit():
			self._code_ = data
		else:
			self._current_item_["p_id"] = self._code_
			self._current_item_["p_name"] = data
			
			self._code_ = None
			self._has_province_ = True
	
	def capture_regency(self, data):
		if data.isdigit():
			self._code_ = data
		else:
			self._current_item_["r_id"] = self._code_
			self._current_item_["r_name"] = data
			
			self._code_ = None
			self._has_regency_ = True
			
	def capture_district(self, data):
		if data.isdigit():
			self._code_ = data
		else:
			self._current_item_["d_id"] = self._code_
			self._current_item_["d_name"] = data
			
			self._code_ = None
			self._has_district_ = True
			
	def capture_village(self, data):
		if data.isdigit():
			self._code_ = data
		else:
			self._current_item_["v_id"] = self._code_
			self._current_item_["v_name"] = data
			
			self._code_ = None
			self._has_village_ = True

def pull(keys):
	connection = None
	collections = []
	htmlReader = HTMLReader()
	
	while_iteration = 0
	while_max = len(keys)
	while len(keys) > 0:
	
		key = keys.pop(0)
		if not key:
			continue
		
		htmlReader.flush()
		htmlReader._current_search_key_ = key
		
		showReadProgress(htmlReader._current_search_key_, len(htmlReader._collection_), htmlReader._row_count_)
		
		headers = {'Accept-Charset': 'UTF-8'}
		response = requests.post(
			'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian',
			data={"pilihcari":"desa","kata_kunci":key,"submit":"cari"},
			headers=headers
		)
		
		htmlReader.feed(response.text)
		
		if len(htmlReader._collection_) == int(htmlReader._row_count_):
			collections.extend(htmlReader._collection_)
			
		else:
			#put back keys
			keys.append(key)
	
	#saving
	connection = connect("localhost", "kosan", "kosansukses!", "kosan_system")
	connection.autocommit = False
	cursor = connection.cursor()
	
	iteration = 0
	print "Save all readed data"
	for item in collections:
		iteration += 1
		showSaveProgress(iteration=iteration, maxIteration=len(collections))
		save(cursor, item)
		connection.commit()
	
	cursor.close()
	connection.close()
	pass

def connect(host, user, passwd, database):
	return mysql.connector.connect(
		host=host,
		user=user,
		passwd=passwd,
		database=database
	)

def save(cursor, data):
	
	#insert province
	id = toUtf8(data["p_id"])
	name = toUtf8(data["p_name"])
	sql_province = sqlString(id, name, "")
	cursor.execute(sql_province)
	
	#insert regency
	id = toUtf8(data["p_id"] + data["r_id"])
	name = toUtf8(data["r_name"])
	parent = toUtf8(data["p_id"])
	sql_regency = sqlString(id, name, parent)
	cursor.execute(sql_regency)
	
	#insert district
	id = toUtf8(data["p_id"] + data["r_id"] + data["d_id"])
	name = toUtf8(data["d_name"])
	parent = toUtf8(data["p_id"] + data["r_id"])
	sql_district = sqlString(id, name, parent)
	cursor.execute(sql_district)
	
	#insert village
	id = toUtf8(data["p_id"] + data["r_id"] + data["d_id"] + data["v_id"])
	name = toUtf8(data["v_name"])
	parent = toUtf8(data["p_id"] + data["r_id"] + data["d_id"])
	sql_village = sqlString(id, name, parent)
	cursor.execute(sql_village)
	
	pass

def sqlString(id, name, parent):
	return """
		INSERT INTO id_regions (code, name, parent)
		SELECT * FROM (SELECT "%s", "%s", "%s") AS tmp 
		WHERE NOT EXISTS ( SELECT code FROM id_regions WHERE code = "%s" ) LIMIT 1;""" % (id, name, parent, id)
	
					
def toUtf8(str):
	try:
		text = unicode(str, 'utf-8')
	except TypeError:
		return str
	
##
## MAIN
##

print "Pilih salah karakter berikut [a,i,u,e,o]"
keys = raw_input("Huruf Vocal Kunci: ")
keys = keys.split() if keys else ["a","i","u","e","o"]
pull( keys )