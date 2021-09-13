<?php


/**
 * This class adds structure of 'admin' table to 'database' DatabaseMap object.
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
class AdminMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.AdminMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AdminPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AdminPeer::TABLE_NAME);
		$tMap->setPhpName('Admin');
		$tMap->setClassname('Admin');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addForeignKey('TYPE_ID', 'TypeId', 'INTEGER', 'admin_type', 'ID', false, 10);

		$tMap->addColumn('DATE', 'Date', 'TIMESTAMP', false, null);

		$tMap->addColumn('USERNAME', 'Username', 'VARCHAR', true, 255);

		$tMap->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 255);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 255);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255);

		$tMap->addColumn('PHONE', 'Phone', 'VARCHAR', false, 255);

		$tMap->addColumn('ADDRESS', 'Address', 'LONGVARCHAR', false, null);

		$tMap->addColumn('EXTRA', 'Extra', 'LONGVARCHAR', false, null);

		$tMap->addValidator('USERNAME', 'required', 'propel.validator.RequiredValidator', '', 'required-username');

		$tMap->addValidator('USERNAME', 'unique', 'propel.validator.UniqueValidator', '', 'unique-username');

		$tMap->addValidator('PASSWORD', 'required', 'propel.validator.RequiredValidator', '', 'required-password');

	} // doBuild()

} // AdminMapBuilder
