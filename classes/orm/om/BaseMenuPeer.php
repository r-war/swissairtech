<?php

/**
 * Base static class for performing query and update operations on the 'menu' table.
 *
 * Menu Table
 *
 * @package    orm.om
 */
abstract class BaseMenuPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'database';

	/** the table name for this class */
	const TABLE_NAME = 'menu';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'orm.Menu';

	/** The total number of columns. */
	const NUM_COLUMNS = 9;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the Primary Key field */
	const PRIMARY_KEY = 'menu.ID';

	/** the column name for the ID field */
	const ID = 'menu.ID';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'menu.LANGUAGE';

	/** the column name for the PARENT_ID field */
	const PARENT_ID = 'menu.PARENT_ID';

	/** the column name for the GROUP field */
	const GROUP = 'menu.GROUP';

	/** the column name for the INDEX field */
	const INDEX = 'menu.INDEX';

	/** the column name for the NAME field */
	const NAME = 'menu.NAME';

	/** the column name for the TYPE field */
	const TYPE = 'menu.TYPE';

	/** the column name for the VALUE field */
	const VALUE = 'menu.VALUE';

	/** the column name for the NEW_TAB field */
	const NEW_TAB = 'menu.NEW_TAB';

	/**
	 * An identiy map to hold any loaded instances of Menu objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array Menu[]
	 */
	public static $instances = array();

	/**
	 * The MapBuilder instance for this peer.
	 * @var        MapBuilder
	 */
	private static $mapBuilder = null;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Language', 'ParentId', 'Group', 'Index', 'Name', 'Type', 'Value', 'NewTab', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'language', 'parentId', 'group', 'index', 'name', 'type', 'value', 'newTab', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::LANGUAGE, self::PARENT_ID, self::GROUP, self::INDEX, self::NAME, self::TYPE, self::VALUE, self::NEW_TAB, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'language', 'parent_id', 'group', 'index', 'name', 'type', 'value', 'new_tab', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Language' => 1, 'ParentId' => 2, 'Group' => 3, 'Index' => 4, 'Name' => 5, 'Type' => 6, 'Value' => 7, 'NewTab' => 8, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'language' => 1, 'parentId' => 2, 'group' => 3, 'index' => 4, 'name' => 5, 'type' => 6, 'value' => 7, 'newTab' => 8, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::LANGUAGE => 1, self::PARENT_ID => 2, self::GROUP => 3, self::INDEX => 4, self::NAME => 5, self::TYPE => 6, self::VALUE => 7, self::NEW_TAB => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'language' => 1, 'parent_id' => 2, 'group' => 3, 'index' => 4, 'name' => 5, 'type' => 6, 'value' => 7, 'new_tab' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new MenuMapBuilder();
		}
		return self::$mapBuilder;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. MenuPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(MenuPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MenuPeer::ID);

		$criteria->addSelectColumn(MenuPeer::LANGUAGE);

		$criteria->addSelectColumn(MenuPeer::PARENT_ID);

		$criteria->addSelectColumn(MenuPeer::GROUP);

		$criteria->addSelectColumn(MenuPeer::INDEX);

		$criteria->addSelectColumn(MenuPeer::NAME);

		$criteria->addSelectColumn(MenuPeer::TYPE);

		$criteria->addSelectColumn(MenuPeer::VALUE);

		$criteria->addSelectColumn(MenuPeer::NEW_TAB);

	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(MenuPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MenuPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     Menu
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = MenuPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return MenuPeer::populateObjects(MenuPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			MenuPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      Menu $value A Menu object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(Menu $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A Menu object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof Menu) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Menu object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     Menu Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = MenuPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = MenuPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = MenuPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				MenuPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(MenuPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MenuPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}

	/**
	 * Selects a collection of Menu objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $c
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Menu objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MenuPeer::addSelectColumns($c);
		$startcol2 = (MenuPeer::NUM_COLUMNS - MenuPeer::NUM_LAZY_LOAD_COLUMNS);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MenuPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MenuPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$omClass = MenuPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MenuPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return MenuPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Menu or Criteria object.
	 *
	 * @param      mixed $values Criteria or Menu object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Menu object
		}

		if ($criteria->containsKey(MenuPeer::ID) && $criteria->keyContainsValue(MenuPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.MenuPeer::ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Menu or Criteria object.
	 *
	 * @param      mixed $values Criteria or Menu object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(MenuPeer::ID);
			$selectCriteria->add(MenuPeer::ID, $criteria->remove(MenuPeer::ID), $comparison);

		} else { // $values is Menu object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the menu table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(MenuPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Menu or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Menu object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			MenuPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof Menu) {
			// invalidate the cache for this single object
			MenuPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key



			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MenuPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
				// we can invalidate the cache for this single object
				MenuPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given Menu object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Menu $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Menu $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MenuPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MenuPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		if ($obj->isNew() || $obj->isColumnModified(MenuPeer::NAME))
			$columns[MenuPeer::NAME] = $obj->getName();

		}

		return BasePeer::doValidate(MenuPeer::DATABASE_NAME, MenuPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     Menu
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{
		if($pk != null)
		{
			if (null !== ($obj = MenuPeer::getInstanceFromPool((string) $pk))) {
				return $obj;
			}
	
			if ($con === null) {
				$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
			}
	
			$criteria = new Criteria(MenuPeer::DATABASE_NAME);
			$criteria->add(MenuPeer::ID, $pk);
	
			$v = MenuPeer::doSelect($criteria, $con);
	
			return !empty($v) > 0 ? $v[0] : null;
		}
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(MenuPeer::DATABASE_NAME);
			$criteria->add(MenuPeer::ID, $pks, Criteria::IN);
			$objs = MenuPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

	static function getList(Criteria $_oCrit = null, Sortable $_oSortable = null,$_iPage = -1, &$_oPager = null,$_iRows = null, PropelPDO $con=null )
	{
		if($_oSortable instanceof Sortable)
		{
			if($_oSortable->isAscending())
			{
				$_oCrit->clearOrderByColumns();
				$_oCrit->addAscendingOrderByColumn($_oSortable->getSortField());
			}
			else if($_oSortable->isDescending())
			{
				$_oCrit->clearOrderByColumns();
				$_oCrit->addDescendingOrderByColumn($_oSortable->getSortField());
			}
		}
	
		if($_iPage != -1)
		{
			$_oPager = new PropelPager(
				$_oCrit, 
				'MenuPeer', 
				'doSelect', 
				$_iPage, 
				$_iRows,
				$con
			);
			
			return $_oPager->getResult();
		}
		else
		{
			return self::doSelect($_oCrit, $con);
		}
	}
	static function extList(Criteria $oCrit, $iStart=0, $iLimit=-1, $sSort=null, $sDir=null, PropelPDO $con=null )
	{
		$iCount = self::doCount($oCrit,$con);
		$aFieldName = self::getFieldNames();
		if($iLimit > 0)
		{
			$oCrit->setOffset($iStart);
			$oCrit->setLimit($iLimit);
		}
		
		if($sSort != null && $sDir != null)
		{
			$sOrderBy = array_search($sSort, $aFieldName);
			
			if($sOrderBy != null)
			{
				$aColName = self::getFieldNames(BasePeer::TYPE_COLNAME);
				$sOrderBy = $aColName[$sOrderBy];
				
				switch($sDir)
				{
					case 'ASC':
						$oCrit->addAscendingOrderByColumn($sOrderBy);
						break;
					case 'DESC':
						$oCrit->addDescendingOrderByColumn($sOrderBy);
						break;
				}
			}
		}
		
		$oStmt = self::doSelectStmt($oCrit, $con);
		
		$aData = $oStmt->fetchAll();
		
		$aColName = self::getFieldNames(BasePeer::TYPE_FIELDNAME);
		
		$aResult = array();
		if(is_array($aData))
		{
			foreach($aData as $aRow)
			{
				$aKey = array_keys($aRow);
				$aNewRow = array();
				
				foreach($aKey as $sKey)
				{
					if(is_string($sKey))
					{
						$sSearchKey = array_search(strtolower($sKey), $aColName);
						if($sSearchKey !== false)
						{
							$sFieldKey = $aFieldName[$sSearchKey];
						}
						else
						{
							$sFieldKey = ucwords($sKey);
						}
						$aNewRow[$sFieldKey] = $aRow[$sKey];
					}
				}
				
				array_push($aResult,MenuPeer::extAddRow($aNewRow));
			}
		}
		
		return array('total' => $iCount, 'result' => $aResult);
	}
	
	static protected function extAddRow($aRow)
	{
		return $aRow;
	}
	
	static function extConvertObject(Menu $oMenu)
	{
		$aResult['Id'] = $oMenu->getId();
		$aResult['Language'] = $oMenu->getLanguage();
		$aResult['ParentId'] = $oMenu->getParentId();
		$aResult['Group'] = $oMenu->getGroup();
		$aResult['Index'] = $oMenu->getIndex();
		$aResult['Name'] = $oMenu->getName();
		$aResult['Type'] = $oMenu->getType();
		$aResult['Value'] = $oMenu->getValue();
		$aResult['NewTab'] = $oMenu->getNewTab();
		return $aResult;
	}
} // BaseMenuPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the MenuPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the MenuPeer class:
//
// Propel::getDatabaseMap(MenuPeer::DATABASE_NAME)->addTableBuilder(MenuPeer::TABLE_NAME, MenuPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(BaseMenuPeer::DATABASE_NAME)->addTableBuilder(BaseMenuPeer::TABLE_NAME, BaseMenuPeer::getMapBuilder());

