DROP TRIGGER IF EXISTS trgg_adh_adherent_insert;
DROP TRIGGER IF EXISTS trgg_adh_adherent_update;
DROP TRIGGER IF EXISTS trgg_adh_group_insert;
DROP TRIGGER IF EXISTS trgg_adh_group_update;
DROP TRIGGER IF EXISTS trgg_adh_tarif_insert;
DROP TRIGGER IF EXISTS trgg_adh_tarif_update;
DROP TRIGGER IF EXISTS trgg_adh_origine_insert;
DROP TRIGGER IF EXISTS trgg_adh_origine_update;
DROP TRIGGER IF EXISTS trgg_adh_profession_insert;
DROP TRIGGER IF EXISTS trgg_adh_profession_update;
DROP TRIGGER IF EXISTS trgg_adh_cotisations_insert;
DROP TRIGGER IF EXISTS trgg_adh_cotisations_update;
ALTER TABLE  `#__adh_cotisations` CHANGE  `adherent_id`  `adherent_id` DOUBLE UNSIGNED NOT NULL;
ALTER TABLE  `#__adh_cotisations` CHANGE  `id`  `id` DOUBLE UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE  `#__adh_cotisations` CHANGE  `mode_paiement`  `mode_paiement` VARCHAR( 16 ) NOT NULL;
ALTER TABLE  `#__adh_cotisations` CHANGE  `date_debut_cotiz`  `date_debut_cotiz` DATE NULL , CHANGE  `date_fin_cotiz`  `date_fin_cotiz` DATE NULL;
ALTER TABLE  `#__adh_cotisations` CHANGE  `mode_paiement`  `mode_paiement` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;