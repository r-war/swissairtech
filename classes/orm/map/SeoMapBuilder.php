<?php


/**
 * This class adds structure of 'seo' table to 'database' DatabaseMap object.
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
class SeoMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'orm.map.SeoMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(SeoPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SeoPeer::TABLE_NAME);
		$tMap->setPhpName('Seo');
		$tMap->setClassname('Seo');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', true, 255);

		$tMap->addColumn('META_TITLE', 'MetaTitle', 'LONGVARCHAR', false, null);

		$tMap->addColumn('META_KEYWORDS', 'MetaKeywords', 'LONGVARCHAR', false, null);

		$tMap->addColumn('META_DESCRIPTION', 'MetaDescription', 'LONGVARCHAR', false, null);

		$tMap->addValidator('URL', 'required', 'propel.validator.RequiredValidator', '', 'required-url');

		$tMap->addValidator('URL', 'unique', 'propel.validator.UniqueValidator', '', 'existed-url');

	} // doBuild()

} // SeoMapBuilder
