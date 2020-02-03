from DOMParser import parser as DOMParser
import requests

# mengambil data dari 'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian'
# @param filter (string) - kunci pencarian
# @progressListener (void) - listener untuk DOMParser
def get(filter, progressListener):
	DOMParser.setProgressListener(progressListener)
	DOMParser.flush()
		
	response = requests.post(
		'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian',
		data={"pilihcari":"desa","kata_kunci":filter,"submit":"cari"},
		headers={'Accept-Charset': 'UTF-8'}
	)
	
	DOMParser.feed(response.text)
	
	return {
		"collections": DOMParser._collection_,
		"count": DOMParser._row_count_
	}
	