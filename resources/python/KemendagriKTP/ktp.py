import dbProvider as db
import options as setting
import sys
import json

def extractNIK(cursor, country, code):
	result = {"id_number": code, "country": country}
	result["birth_date"] = code[6:8] + "-" + code[8:10] + "-" + code[10:12]
	result["id_index"] = code[12:]
	
	# extract administrative code
	adminCode = code[0:2] + "." + code[2:4] + "." + code[4:6]
	
	sql = db.find(cursor, setting.database["table"], country, adminCode)
	sql = cursor.fetchone()
	result["district_code"] = sql[2]
	result["district_name"] = sql[3]
	
	sql = db.find(cursor, setting.database["table"], country, sql[4])
	sql = cursor.fetchone()
	result["regency_code"] = sql[2]
	result["regency_name"] = sql[3]
	
	sql = db.find(cursor, setting.database["table"], country, sql[4])
	sql = cursor.fetchone()
	result["province_code"] = sql[2]
	result["province_name"] = sql[3]
	
	return result
	
	
if __name__ == "__main__":
	idcard = "3578033105840001"

	# 1. open connection
	connection = db.connect(
		setting.database["host"], 
		setting.database["user"], 
		setting.database["pwd"], 
		setting.database["database"]
	)
	cursor = connection.cursor()
	
	pretty = json.dumps(extractNIK(cursor, "id", idcard), indent=4)
	print pretty
	
	cursor.close()
	connection.close()