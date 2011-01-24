# TYPO3 does not see a difference between NULL and 0 - so we will use -1 as NULL


###
# Domain model "Event"
###
CREATE TABLE tx_czsimplecal_domain_model_event (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	
	title varchar(220),
	start_day int(11) DEFAULT '',
	start_time int(11) DEFAULT '-1',
	end_day int(11) DEFAULT '-1',
	end_time int(11) DEFAULT '-1',
	timezone varchar(20) DEFAULT 'GMT',
	teaser tinytext,
	description tinytext,
	recurrance_type varchar(30) DEFAULT 'none',
	recurrance_subtype varchar(30) DEFAULT '',
	recurrance_until int(11) DEFAULT '-1',
	location_name tinytext,
	location int(11) DEFAULT '0',
	organizer_name tinytext,
	organizer int(11) DEFAULT '0',
	categories int(11) unsigned DEFAULT '0' NOT NULL,
	exceptions int(11) unsigned DEFAULT '0' NOT NULL,
	slug varchar(250) DEFAULT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY slug (slug)
);

###
# Domain model "EventIndex"
###
CREATE TABLE tx_czsimplecal_domain_model_eventindex (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	start    int(11) NOT NULL DEFAULT '',
	end      int(11) NOT NULL DEFAULT '',	
	event    int(11) NOT NULL DEFAULT '',
	slug varchar(250) DEFAULT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY slug (slug)
);

###
# Domain model "Exception"
###
CREATE TABLE tx_czsimplecal_domain_model_exception (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	
	title tinytext,
	start_day int(11) DEFAULT '',
	start_time int(11) DEFAULT '-1',
	end_day int(11) DEFAULT '-1',
	end_time int(11) DEFAULT '-1',
	timezone varchar(20) DEFAULT 'GMT',
	recurrance_type varchar(30) DEFAULT 'none',
	recurrance_subtype varchar(30) DEFAULT '',
	recurrance_until int(11) DEFAULT '-1',

	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

###
# Domain model "ExceptionGroup"
###
CREATE TABLE tx_czsimplecal_domain_model_exceptiongroup (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	
	title tinytext,
	exceptions int(11) unsigned DEFAULT '0' NOT NULL,
	
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

###
# Relation Table "ExceptionGroup" to "Exception"
###
CREATE TABLE tx_czsimplecal_exceptiongroup_exception_mm (
	uid int(10) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	tstamp int(10) unsigned DEFAULT '0' NOT NULL,
	crdate int(10) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

###
# Relation Table "Event" to "Exception" and "ExceptionGroup"
###
CREATE TABLE tx_czsimplecal_event_exception_mm (
	uid int(10) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	tstamp int(10) unsigned DEFAULT '0' NOT NULL,
	crdate int(10) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);


###
# Domain model "Category"
###
CREATE TABLE tx_czsimplecal_domain_model_category (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	
	title tinytext,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

###
# Relation Table "Event" to "Category"
###
CREATE TABLE tx_czsimplecal_event_category_mm (
	uid int(10) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	tstamp int(10) unsigned DEFAULT '0' NOT NULL,
	crdate int(10) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tt_address (
	tx_cal_controller_isorganizer tinyint(4) DEFAULT '0' NOT NULL,
	tx_cal_controller_islocation tinyint(4) DEFAULT '0' NOT NULL,
);


