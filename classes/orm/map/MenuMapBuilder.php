<?php


/**
 * This class adds structure of 'menu' table to 'database' DatabaseMap object.
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
class MenuMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.MenuMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(MenuPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MenuPeer::TABLE_NAME);
		$tMap->setPhpName('Menu');
		$tMap->setClassname('Menu');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('LANGUAGE', 'Language', 'VARCHAR', true, 2);

		$tMap->addForeignKey('PARENT_ID', 'ParentId', 'INTEGER', 'menu', 'ID', false, 10);

		$tMap->addColumn('GROUP', 'Group', 'VARCHAR', false, 255);

		$tMap->addColumn('INDEX', 'Index', 'INTEGER', false, 10);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addColumn('TYPE', 'Type', 'INTEGER', true, 1);

		$tMap->addColumn('VALUE', 'Value', 'VARCHAR', false, 255);

		$tMap->addColumn('NEW_TAB', 'NewTab', 'BOOLEAN', false, 1);

		$tMap->addValidator('NAME', 'required', 'propel.validator.RequiredValidator', '', 'required-name');

	} // doBuild()

} // MenuMapBuilder
