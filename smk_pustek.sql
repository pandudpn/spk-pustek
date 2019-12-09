# Host: localhost  (Version 5.5.5-10.1.37-MariaDB)
# Date: 2019-07-18 18:49:15
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "guru"
#

DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
  `kode_guru` int(5) NOT NULL DEFAULT '0',
  `nama_guru` varchar(150) NOT NULL DEFAULT '',
  `no_telp` char(15) NOT NULL DEFAULT '',
  `alamat` varchar(200) NOT NULL DEFAULT '',
  `jenis` varchar(150) NOT NULL DEFAULT '',
  `tempat_lahir` varchar(100) NOT NULL DEFAULT '',
  `tgl_lahir` date NOT NULL DEFAULT '0000-00-00',
  `jk` enum('Laki-laki','Perempuan') NOT NULL DEFAULT 'Laki-laki',
  `ts_guru` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "guru"
#


#
# Structure for table "hasil"
#

DROP TABLE IF EXISTS `hasil`;
CREATE TABLE `hasil` (
  `kode_guru` int(5) NOT NULL DEFAULT '0',
  `id_periode` int(11) DEFAULT NULL,
  `nilai_akhir` decimal(10,4) DEFAULT NULL,
  `status` enum('Tidak Terpilih','Terpilih') NOT NULL DEFAULT 'Tidak Terpilih',
  KEY `FK_guru` (`kode_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "hasil"
#


#
# Structure for table "kriteria"
#

DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE `kriteria` (
  `id_kriteria` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(150) NOT NULL DEFAULT '',
  `bobot` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `cb` enum('cost','benefit') NOT NULL DEFAULT 'cost',
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "kriteria"
#


#
# Structure for table "nilai"
#

DROP TABLE IF EXISTS `nilai`;
CREATE TABLE `nilai` (
  `kode_guru` int(5) NOT NULL DEFAULT '0',
  `id_kriteria` int(5) NOT NULL DEFAULT '0',
  `id_periode` int(11) NOT NULL DEFAULT '0',
  `nilai` decimal(10,4) NOT NULL DEFAULT '0.0000',
  KEY `FK_guru` (`kode_guru`),
  KEY `FK_kriteria` (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "nilai"
#


#
# Structure for table "periode"
#

DROP TABLE IF EXISTS `periode`;
CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "periode"
#


#
# Structure for table "subkriteria"
#

DROP TABLE IF EXISTS `subkriteria`;
CREATE TABLE `subkriteria` (
  `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(5) NOT NULL DEFAULT '0',
  `nama_subkriteria` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_subkriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# Data for table "subkriteria"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `akses` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=admin, 2=kepala sekolah',
  `ts_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Administrator','admin','7b2e9f54cdff413fcde01f330af6896c3cd7e6cd',1,'2019-03-12 14:21:36');

#
# View "evaluasi_1"
#

DROP VIEW IF EXISTS `evaluasi_1`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `evaluasi_1`
  AS
  SELECT
    `a`.`kode_guru`,
    `a`.`nama_guru`,
    `c`.`id_periode`,
    `b`.`nilai` AS 'k1',
    `d`.`cb` AS 'cb_1',
    `d`.`bobot` AS 'bobot_1'
  FROM
    (((`guru` a
      JOIN `nilai` b)
      JOIN `periode` c)
      JOIN `kriteria` d)
  WHERE
    ((`a`.`kode_guru` = `b`.`kode_guru`)
      AND (`b`.`id_periode` = `c`.`id_periode`)
      AND (`b`.`id_kriteria` = `d`.`id_kriteria`)
      AND (`b`.`id_kriteria` = 1));

#
# View "evaluasi_2"
#

DROP VIEW IF EXISTS `evaluasi_2`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `evaluasi_2`
  AS
  SELECT
    `a`.`kode_guru`,
    `a`.`nama_guru`,
    `c`.`id_periode`,
    `b`.`nilai` AS 'k2',
    `d`.`cb` AS 'cb_2',
    `d`.`bobot` AS 'bobot_2'
  FROM
    (((`guru` a
      JOIN `nilai` b)
      JOIN `periode` c)
      JOIN `kriteria` d)
  WHERE
    ((`a`.`kode_guru` = `b`.`kode_guru`)
      AND (`b`.`id_periode` = `c`.`id_periode`)
      AND (`b`.`id_kriteria` = `d`.`id_kriteria`)
      AND (`b`.`id_kriteria` = 2));

#
# View "evaluasi_3"
#

DROP VIEW IF EXISTS `evaluasi_3`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `evaluasi_3`
  AS
  SELECT
    `a`.`kode_guru`,
    `a`.`nama_guru`,
    `c`.`id_periode`,
    `b`.`nilai` AS 'k3',
    `d`.`cb` AS 'cb_3',
    `d`.`bobot` AS 'bobot_3'
  FROM
    (((`guru` a
      JOIN `nilai` b)
      JOIN `periode` c)
      JOIN `kriteria` d)
  WHERE
    ((`a`.`kode_guru` = `b`.`kode_guru`)
      AND (`b`.`id_periode` = `c`.`id_periode`)
      AND (`b`.`id_kriteria` = `d`.`id_kriteria`)
      AND (`b`.`id_kriteria` = 3));

#
# View "evaluasi_4"
#

DROP VIEW IF EXISTS `evaluasi_4`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `evaluasi_4`
  AS
  SELECT
    `a`.`kode_guru`,
    `a`.`nama_guru`,
    `c`.`id_periode`,
    `b`.`nilai` AS 'k4',
    `d`.`cb` AS 'cb_4',
    `d`.`bobot` AS 'bobot_4'
  FROM
    (((`guru` a
      JOIN `nilai` b)
      JOIN `periode` c)
      JOIN `kriteria` d)
  WHERE
    ((`a`.`kode_guru` = `b`.`kode_guru`)
      AND (`b`.`id_periode` = `c`.`id_periode`)
      AND (`b`.`id_kriteria` = `d`.`id_kriteria`)
      AND (`b`.`id_kriteria` = 4));

#
# View "nilai_evaluasi"
#

DROP VIEW IF EXISTS `nilai_evaluasi`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `nilai_evaluasi`
  AS
  SELECT
    `a`.`kode_guru`,
    `a`.`nama_guru` AS 'nama',
    `a`.`id_periode` AS 'periode',
    `a`.`k1`,
    `a`.`cb_1`,
    `a`.`bobot_1`,
    `b`.`k2`,
    `b`.`cb_2`,
    `b`.`bobot_2`,
    `c`.`k3`,
    `c`.`cb_3`,
    `c`.`bobot_3`,
    `d`.`k4`,
    `d`.`cb_4`,
    `d`.`bobot_4`
  FROM
    (((`evaluasi_1` a
      LEFT JOIN `evaluasi_2` b ON ((`a`.`kode_guru` = `b`.`kode_guru`)))
      LEFT JOIN `evaluasi_3` c ON ((`a`.`kode_guru` = `c`.`kode_guru`)))
      LEFT JOIN `evaluasi_4` d ON ((`a`.`kode_guru` = `d`.`kode_guru`)))
  GROUP BY
    `a`.`kode_guru`, `a`.`id_periode`;
