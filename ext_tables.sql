#
# Table structure for table 'tx_calltoactions_domain_model_calltoactions'
#
CREATE TABLE tx_calltoactions_domain_model_calltoactions (
	label varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	button varchar(255) DEFAULT '' NOT NULL,
	content text,
	url varchar(255) DEFAULT '' NOT NULL,
	theme varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	image int(11) DEFAULT '0' NOT NULL,
);
