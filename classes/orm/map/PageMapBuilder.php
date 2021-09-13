<?php


/**
 * This class adds structure of 'page' table to 'database' DatabaseMap object.
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
class PageMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.PageMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PagePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PagePeer::TABLE_NAME);
		$tMap->setPhpName('Page');
		$tMap->setClassname('Page');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'INTEGER', false, 10);

		$tMap->addColumn('LANGUAGE', 'Language', 'VARCHAR', true, 2);

		$tMap->addColumn('TYPE', 'Type', 'VARCHAR', true, 20);

		$tMap->addColumn('DATE', 'Date', 'TIMESTAMP', false, null);

		$tMap->addColumn('CODE', 'Code', 'VARCHAR', true, 255);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addColumn('PICTURE', 'Picture', 'VARCHAR', false, 255);

		$tMap->addColumn('SHORT_DESC', 'ShortDesc', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null);

		$tMap->addValidator('NAME', 'required', 'propel.validator.RequiredValidator', '', 'required-name');

	} // doBuild()

} // PageMapBuilder
