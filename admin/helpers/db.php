<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * db component helper.
 * 
 * host all queries/access to database outside of the model
 * when we need only the data
 * If wee need to build a control, please see ADHcontrols
 */
abstract class ADHdb {
	/**
	 * @brief	connect to OldDb
	 * @since	0.0.14
	 */
	function getOldDbo() {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT params FROM #__extensions WHERE name = "com_adh"');
		$params = json_decode( $db->loadResult(), true );
		$options = array(   "driver"    => "mysql",
				"database"  => $params['database'],
				"select"    => true,
				"host"      => $params['db_host'],
				"user"      => $params['db_username'],
				"password"  => $params['db_passwd']
		);
		$old_db = JDatabaseMySQL::getInstance($options);
		if ($old_db->getErrorNum()>0) { JFactory::getApplication()->enqueueMessage(JText::_('COM_ADH_IMPORT_DATABASE_CONNEXION_ERROR'), 'error'); }
		
		return $old_db;
	}

	/**
	 * extract default latlng from #__adh_chantiers_categories
	 */
	function getDefaultChantiersCategorie($catid = 10) {
		$db = JFactory::getDbo();
		//$query = $db->getQuery(true);
		//$query = "SELECT * FROM `#__adh_chantiers_categories` WHERE published = 1 ORDER BY id ASC LIMIT 1";
		$query = "SELECT * FROM `#__adh_chantiers_categories` WHERE id=".$catid;
		//$result = mysql_query($query) or die('Query failed: ' . mysql_error().'<br />QUERY = '.nl2br($query));
		$db->setQuery($query);
		$db->execute();
		$row = $db->loadObject();
		return $row;
	}

	/**
	 * @brief	get the default mapType of the categorie choosen
	 * 
	 * @return type
	 */
	function getDefaultMapType($catid = 0) {
		$db = JFactory::getDbo();
		//$query = $db->getQuery(true);
		$query = "SELECT * FROM `#__adh_chantiers_categories` WHERE published = 1 ORDER BY id ASC LIMIT 1";
		//$result = mysql_query($query) or die('Query failed: ' . mysql_error().'<br />QUERY = '.nl2br($query));
		$db->setQuery($query);
		$db->execute();
		$row = $db->loadObject();
		return $row;
	}
	
}
?>
