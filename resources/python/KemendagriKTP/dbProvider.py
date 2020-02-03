## DBProvider.py
## Class untuk menyimpan data provinsi, Kabupaten/Kota, Kecamatan, dan Keluarahan
##

import mysql.connector

def connect(host, user, passwd, database):
	return mysql.connector.connect(
		host=host,
		user=user,
		passwd=passwd,
		database=database
	)

def create(cursor, name, fresh=True):
	cursor.execute(
		"""
			CREATE TABLE IF NOT EXISTS `%s` (
			  `id` bigint(20) NOT NULL,
			  `country` char(3) COLLATE utf8_unicode_ci NOT NULL,
			  `code` char(20) COLLATE utf8_unicode_ci NOT NULL,
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
	
def drop(cursor, name):
	cursor.execute("DROP TABLE IF EXISTS `%s`;" % (name))

# sql untuk menyimpan data
# sesuaikan dengan colom database 
#
# PENTING: gunakan double quoute '"' untuk value pada sql
#
def save(cursor, table, country, code, name, parent=""):
	_sql_insert_ = """
		INSERT INTO `{0}` (`country`, `code`, `name`, `parent`) 
		VALUES("{1}", "{2}", "{3}", "{4}") 
		ON DUPLICATE KEY UPDATE 
			`country` = "{1}", 
			`code` = "{2}", 
			`name` = "{3}", 
			`parent`= "{4}"
	""" 
	cursor.execute(_sql_insert_.format(table, country, code, name, parent))
	
def find(cursor, table, country, code):
	_sql_ = """
		SELECT * FROM `{0}`
		WHERE
			`country` = "{1}" AND
			`code` = "{2}"
	"""
	cursor.execute(_sql_.format(table, country, code))
	