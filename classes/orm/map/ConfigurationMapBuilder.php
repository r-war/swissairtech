<?php


/**
 * This class adds structure of 'configuration' table to 'database' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    orm.map
 */
class ConfigurationMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.ConfigurationMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(ConfigurationPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ConfigurationPeer::TABLE_NAME);
		$tMap->setPhpName('Configuration');
		$tMap->setClassname('Configuration');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('CONFIGURATION_ID', 'ConfigurationId', 'INTEGER', true, 10);

		$tMap->addColumn('DOMAIN', 'Domain', 'VARCHAR', true, 255);

		$tMap->addColumn('KEY_NAME', 'KeyName', 'VARCHAR', true, 255);

		$tMap->addColumn('VALUE', 'Value', 'LONGVARCHAR', false, null);

		$tMap->addValidator('KEY_NAME', 'required', 'propel.validator.RequiredValidator', '', 'required-key_name');

	} // doBuild()

} // ConfigurationMapBuilder
