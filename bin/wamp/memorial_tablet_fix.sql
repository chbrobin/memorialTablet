ALTER TABLE memorial_tablet DROP COLUMN com_port,DROP COLUMN com_module_id, DROP COLUMN com_module_address;
ALTER TABLE tablet_com ADD COLUMN com_port_id INT(10) DEFAULT 0 COMMENT 'COM端口ID';
ALTER TABLE tablet_com DROP COLUMN com_port;