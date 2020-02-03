## DBProvider.py
## Class untuk menyimpan data provinsi, Kabupaten/Kota, Kecamatan, dan Keluarahan
##

import mysql.connector

# sql untuk menyimpan data
# sesuaikan dengan colom database 
#
# PENTING: gunakan double quoute '"' untuk value pada sql
#
def saveStatement(table, id, name, parent=""):
	_sql_insert_ = """
		INSERT INTO `{0}` (code, name, parent)
		SELECT * FROM (SELECT "{1}", "{2}", "{3}") AS tmp 
		WHERE NOT EXISTS ( SELECT code FROM id_regions WHERE code = "{1}" ) LIMIT 1;
	""" 
	return _sql_insert_.format(table, id, name, parent)


def connect(host, user, passwd, database):
	return mysql.connector.connect(
		host=host,
		user=user,
		passwd=passwd,
		database=database
	)

def drop(cursor, name):
	cursor.execute("DROP TABLE IF EXISTS `%s`;" % (name))
	
def create(cursor, name, fresh=True):
	cursor.execute(
		"""
			CREATE TABLE IF NOT EXISTS `%s` (
			  `id` bigint(20) NOT NULL,
			  `code` char(12) COLLATE utf8_unicode_ci NOT NULL,
			  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			  `parent` char(12) COLLATE utf8_unicode_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		""" % (name)
	)
	
	if fresh: 
		cursor.execute(
			"""
				ALTER TABLE `%s`
				ADD PRIMARY KEY (`id`),
				ADD UNIQUE KEY `code` (`code`);
			""" % (name)
		)
		
		cursor.execute(
			"""
				ALTER TABLE `%s`
				MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
			""" % (name)
		)
	pass

# void save
# @param cursor (Mysql Cursor) - database cursor
# @param data (Dictionary) - data array
#
# data berupa dictionary array 1 dimensi, dengan index:
# {
#	"p_id" 		-> id provinsi
#	"p_name" 	-> nama provinsi
#	"r_id" 		-> id kabupaten/kota (regency)
#	"r_name" 	-> nama kabupaten/kota (regency)
#	"d_id" 		-> id Kecamatan (district)
#	"d_id" 		-> nama Kecamatan (district)
#	"v_id" 		-> id Desa/Kelurahan (village)
#	"v_name" 	-> nama Desa/Kelurahan (village)
# }
def save(cursor, table, data):	
	
	#insert province
	id = data["p_id"]
	name = data["p_name"]
	sql_province = saveStatement(table, id, name, "")
	cursor.execute(sql_province)
	
	#insert regency
	id = data["p_id"] + data["r_id"]
	name = data["r_name"]
	parent = data["p_id"]
	sql_regency = saveStatement(table, id, name, parent)
	cursor.execute(sql_regency)
	
	#insert district
	id = data["p_id"] + data["r_id"] + data["d_id"]
	name = data["d_name"]
	parent = data["p_id"] + data["r_id"]
	sql_district = saveStatement(table, id, name, parent)
	cursor.execute(sql_district)
	
	#insert village
	id = data["p_id"] + data["r_id"] + data["d_id"] + data["v_id"]
	name = data["v_name"]
	parent = data["p_id"] + data["r_id"] + data["d_id"]
	sql_village = saveStatement(table, id, name, parent)
	cursor.execute(sql_village)
	
	pass
	
def saveAndUpdate(db_host, db_usr, db_pwd, db_schema, db_table, collections, progressListener, rebuild_database=False):
	connection = connect(db_host, db_usr, db_pwd, db_schema)
	connection.autocommit = False
	cursor = connection.cursor()
	
	#create table
	if rebuild_database:
		drop(cursor, db_table)
	
	create(cursor, db_table, rebuild_database)
	connection.commit()
	
	iteration = 0
	for item in collections:
		iteration += 1
		progressListener(iteration, len(collections))
		save(cursor, db_table, item)
		connection.commit()
	
	cursor.close()
	connection.close()
	
## test main
if __name__ == '__main__':
	connection = connect("localhost", "kosan", "kosansukses!", "kosan_system")
	connection.autocommit = False
	cursor = connection.cursor()
	create("id_regions")