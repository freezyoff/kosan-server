from HTMLParser import HTMLParser

class DOMParser(HTMLParser):
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
	
	_progress_listener_ = None
	
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
			self.fireProgressChange()
		
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
	
	def setProgressListener(self, listener):
		self._progress_listener_ = listener
	
	def fireProgressChange(self):
		self._progress_listener_(len(self._collection_), self._row_count_)
		
parser = DOMParser()