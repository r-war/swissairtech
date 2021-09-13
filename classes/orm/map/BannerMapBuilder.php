<?php


/**
 * This class adds structure of 'banner' table to 'database' DatabaseMap object.
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
class BannerMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.BannerMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(BannerPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(BannerPeer::TABLE_NAME);
		$tMap->setPhpName('Banner');
		$tMap->setClassname('Banner');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('LANGUAGE', 'Language', 'VARCHAR', true, 2);

		$tMap->addColumn('GROUP', 'Group', 'VARCHAR', false, 255);

		$tMap->addColumn('INDEX', 'Index', 'INTEGER', false, 10);

		$tMap->addColumn('PICTURE', 'Picture', 'VARCHAR', true, 255);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', false, 255);

		$tMap->addColumn('NEW_TAB', 'NewTab', 'BOOLEAN', false, 1);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255);

		$tMap->addValidator('PICTURE', 'required', 'propel.validator.RequiredValidator', '', 'required-picture');

	} // doBuild()

} // BannerMapBuilder
