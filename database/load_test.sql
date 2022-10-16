SET GLOBAL local_infile=1;
-- LOAD DATA INFILE '/Users/jdlien/Downloads/gtfs/agency.txt'
LOAD DATA INFILE '/usr/local/var/mysql-files/gtfs/agency.txt'
INTO TABLE agencies
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY """"
IGNORE 1 LINES
(
	id,
	name,
	url,
	phone,
	fare_url,
	email,
	lang,
	timezone
)
SET updated_at = now()
;

-- SELECT * FROM agencies

-- SHOW VARIABLES LIKE "secure_file_priv"

SELECT * FROM agencies