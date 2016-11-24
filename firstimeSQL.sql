
/* for sent status */
	ALTER TABLE tb_event_log ADD COLUMN status SMALLINT(2) DEFAULT '0' NOT NULL AFTER nType;

/* for own log table */
	CREATE TABLE IF NOT EXISTS tb_zz_send_receive_log (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  datetime int(11) NOT NULL,
	  comment varchar(250) NOT NULL,
	  status int(11) NOT NULL COMMENT '0=send, 1=receive',
	  PRIMARY KEY (id)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;