import mysql.connector

DB = None
KnownBankCodes = []

def connect():
	global DB
	if (DB is None):
		DB = mysql.connector.connect(
		  host="localhost",
		  user="kosan",
		  passwd="kosansukses!"
		)
		
	return DB

def disconnect():
	global DB
	if (DB is not None):
		DB.close()
	DB = None

##
## Create database
##
def create():
	stm_drop = "DROP TABLE IF EXISTS `kosan_finance`.`banks`;"
	stm_create = """
	CREATE TABLE IF NOT EXISTS `kosan_finance`.`banks` (
		`code` VARCHAR(4) NULL,
		`name` VARCHAR(45) NULL,
	PRIMARY KEY (`code`))
	ENGINE = InnoDB;
	"""
	
	global DB
	cr = DB.cursor()
	cr.execute(stm_drop)
	cr.execute(stm_create)
	DB.commit()
	cr.close()

##
## Insert record to database
##
def insert(records):
	statements = "INSERT INTO `kosan_finance`.`banks` (`code`, `name`) VALUES ('{0}','{1}');"
	
	#we avoid duplicate bank code
	global KnownBankCodes
	global DB
	for item in records:
		if item[1] not in KnownBankCodes:
			cr = DB.cursor()
			KnownBankCodes.append(item[1])
			cr.execute(statements.format(item[1], item[0]))
			DB.commit()
			cr.close()
		
		
	
	