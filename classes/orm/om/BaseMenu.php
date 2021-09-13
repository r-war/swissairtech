<?php

/**
 * Base class that represents a row from the 'menu' table.
 *
 * Menu Table
 *
 * @package    orm.om
 */
abstract class BaseMenu extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MenuPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;

	/**
	 * The value for the parent_id field.
	 * @var        int
	 */
	protected $parent_id;

	/**
	 * The value for the group field.
	 * @var        string
	 */
	protected $group;

	/**
	 * The value for the index field.
	 * @var        int
	 */
	protected $index;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the type field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $type;

	/**
	 * The value for the value field.
	 * @var        string
	 */
	protected $value;

	/**
	 * The value for the new_tab field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $new_tab;

	/**
	 * @var        Menu
	 */
	protected $aMenuRelatedByParentId;

	/**
	 * @var        array Menu[] Collection to store aggregation of Menu objects.
	 */
	protected $collMenusRelatedByParentId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMenusRelatedByParentId.
	 */
	private $lastMenuRelatedByParentIdCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BaseMenu object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->type = 1;
		$this->new_tab = false;
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [language] column value.
	 * 
	 * @return     string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Get the [parent_id] column value.
	 * 
	 * @return     int
	 */
	public function getParentId()
	{
		return $this->parent_id;
	}

	/**
	 * Get the [group] column value.
	 * 
	 * @return     string
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * Get the [index] column value.
	 * 
	 * @return     int
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [type] column value.
	 * 
	 * @return     int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Get the [value] column value.
	 * 
	 * @return     string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Get the [new_tab] column value.
	 * 
	 * @return     boolean
	 */
	public function getNewTab()
	{
		return $this->new_tab;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MenuPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      string $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setLanguage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language !== $v) {
			$this->language = $v;
			$this->modifiedColumns[] = MenuPeer::LANGUAGE;
		}

		return $this;
	} // setLanguage()

	/**
	 * Set the value of [parent_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setParentId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->parent_id !== $v) {
			$this->parent_id = $v;
			$this->modifiedColumns[] = MenuPeer::PARENT_ID;
		}

		if ($this->aMenuRelatedByParentId !== null && $this->aMenuRelatedByParentId->getId() !== $v) {
			$this->aMenuRelatedByParentId = null;
		}

		return $this;
	} // setParentId()

	/**
	 * Set the value of [group] column.
	 * 
	 * @param      string $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setGroup($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->group !== $v) {
			$this->group = $v;
			$this->modifiedColumns[] = MenuPeer::GROUP;
		}

		return $this;
	} // setGroup()

	/**
	 * Set the value of [index] column.
	 * 
	 * @param      int $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setIndex($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->index !== $v) {
			$this->index = $v;
			$this->modifiedColumns[] = MenuPeer::INDEX;
		}

		return $this;
	} // setIndex()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = MenuPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      int $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setType($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->type !== $v || $v === 1) {
			$this->type = $v;
			$this->modifiedColumns[] = MenuPeer::TYPE;
		}

		return $this;
	} // setType()

	/**
	 * Set the value of [value] column.
	 * 
	 * @param      string $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setValue($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->value !== $v) {
			$this->value = $v;
			$this->modifiedColumns[] = MenuPeer::VALUE;
		}

		return $this;
	} // setValue()

	/**
	 * Set the value of [new_tab] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Menu The current object (for fluent API support)
	 */
	public function setNewTab($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->new_tab !== $v || $v === false) {
			$this->new_tab = $v;
			$this->modifiedColumns[] = MenuPeer::NEW_TAB;
		}

		return $this;
	} // setNewTab()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array(MenuPeer::TYPE,MenuPeer::NEW_TAB))) {
				return false;
			}

			if ($this->type !== 1) {
				return false;
			}

			if ($this->new_tab !== false) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->language = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->parent_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->group = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->index = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->type = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->value = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->new_tab = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 9; // 9 = MenuPeer::NUM_COLUMNS - MenuPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Menu object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aMenuRelatedByParentId !== null && $this->parent_id !== $this->aMenuRelatedByParentId->getId()) {
			$this->aMenuRelatedByParentId = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = MenuPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aMenuRelatedByParentId = null;
			$this->collMenusRelatedByParentId = null;
			$this->lastMenuRelatedByParentIdCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			MenuPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MenuPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			MenuPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aMenuRelatedByParentId !== null) {
				if ($this->aMenuRelatedByParentId->isModified() || $this->aMenuRelatedByParentId->isNew()) {
					$affectedRows += $this->aMenuRelatedByParentId->save($con);
				}
				$this->setMenuRelatedByParentId($this->aMenuRelatedByParentId);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = MenuPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MenuPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MenuPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collMenusRelatedByParentId !== null) {
				foreach ($this->collMenusRelatedByParentId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aMenuRelatedByParentId !== null) {
				if (!$this->aMenuRelatedByParentId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMenuRelatedByParentId->getValidationFailures());
				}
			}


			if (($retval = MenuPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMenusRelatedByParentId !== null) {
					foreach ($this->collMenusRelatedByParentId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MenuPeer::DATABASE_NAME);

		if ($this->isColumnModified(MenuPeer::ID)) $criteria->add(MenuPeer::ID, $this->id);
		if ($this->isColumnModified(MenuPeer::LANGUAGE)) $criteria->add(MenuPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(MenuPeer::PARENT_ID)) $criteria->add(MenuPeer::PARENT_ID, $this->parent_id);
		if ($this->isColumnModified(MenuPeer::GROUP)) $criteria->add(MenuPeer::GROUP, $this->group);
		if ($this->isColumnModified(MenuPeer::INDEX)) $criteria->add(MenuPeer::INDEX, $this->index);
		if ($this->isColumnModified(MenuPeer::NAME)) $criteria->add(MenuPeer::NAME, $this->name);
		if ($this->isColumnModified(MenuPeer::TYPE)) $criteria->add(MenuPeer::TYPE, $this->type);
		if ($this->isColumnModified(MenuPeer::VALUE)) $criteria->add(MenuPeer::VALUE, $this->value);
		if ($this->isColumnModified(MenuPeer::NEW_TAB)) $criteria->add(MenuPeer::NEW_TAB, $this->new_tab);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MenuPeer::DATABASE_NAME);

		$criteria->add(MenuPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Menu (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setLanguage($this->language);

		$copyObj->setParentId($this->parent_id);

		$copyObj->setGroup($this->group);

		$copyObj->setIndex($this->index);

		$copyObj->setName($this->name);

		$copyObj->setType($this->type);

		$copyObj->setValue($this->value);

		$copyObj->setNewTab($this->new_tab);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getMenusRelatedByParentId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addMenuRelatedByParentId($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Menu Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     MenuPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MenuPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Menu object.
	 *
	 * @param      Menu $v
	 * @return     Menu The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setMenuRelatedByParentId(Menu $v = null)
	{
		if ($v === null) {
			$this->setParentId(NULL);
		} else {
			$this->setParentId($v->getId());
		}

		$this->aMenuRelatedByParentId = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Menu object, it will not be re-added.
		if ($v !== null) {
			$v->addMenuRelatedByParentId($this);
		}

		return $this;
	}


	/**
	 * Get the associated Menu object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Menu The associated Menu object.
	 * @throws     PropelException
	 */
	public function getMenuRelatedByParentId(PropelPDO $con = null)
	{
		if ($this->aMenuRelatedByParentId === null && ($this->parent_id !== null)) {
			$this->aMenuRelatedByParentId = MenuPeer::retrieveByPK($this->parent_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aMenuRelatedByParentId->addMenusRelatedByParentId($this);
			 */
		}
		return $this->aMenuRelatedByParentId;
	}

	/**
	 * Clears out the collMenusRelatedByParentId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addMenusRelatedByParentId()
	 */
	public function clearMenusRelatedByParentId()
	{
		$this->collMenusRelatedByParentId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collMenusRelatedByParentId collection (array).
	 *
	 * By default this just sets the collMenusRelatedByParentId collection to an empty array (like clearcollMenusRelatedByParentId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initMenusRelatedByParentId()
	{
		$this->collMenusRelatedByParentId = array();
	}

	/**
	 * Gets an array of Menu objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Menu has previously been saved, it will retrieve
	 * related MenusRelatedByParentId from storage. If this Menu is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Menu[]
	 * @throws     PropelException
	 */
	public function getMenusRelatedByParentId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MenuPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMenusRelatedByParentId === null) {
			if ($this->isNew()) {
			   $this->collMenusRelatedByParentId = array();
			} else {

				$criteria->add(MenuPeer::PARENT_ID, $this->id);

				MenuPeer::addSelectColumns($criteria);
				$this->collMenusRelatedByParentId = MenuPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(MenuPeer::PARENT_ID, $this->id);

				MenuPeer::addSelectColumns($criteria);
				if (!isset($this->lastMenuRelatedByParentIdCriteria) || !$this->lastMenuRelatedByParentIdCriteria->equals($criteria)) {
					$this->collMenusRelatedByParentId = MenuPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMenuRelatedByParentIdCriteria = $criteria;
		return $this->collMenusRelatedByParentId;
	}

	/**
	 * Returns the number of related Menu objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Menu objects.
	 * @throws     PropelException
	 */
	public function countMenusRelatedByParentId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MenuPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collMenusRelatedByParentId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(MenuPeer::PARENT_ID, $this->id);

				$count = MenuPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(MenuPeer::PARENT_ID, $this->id);

				if (!isset($this->lastMenuRelatedByParentIdCriteria) || !$this->lastMenuRelatedByParentIdCriteria->equals($criteria)) {
					$count = MenuPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collMenusRelatedByParentId);
				}
			} else {
				$count = count($this->collMenusRelatedByParentId);
			}
		}
		$this->lastMenuRelatedByParentIdCriteria = $criteria;
		return $count;
	}

	/**
	 * Method called to associate a Menu object to this object
	 * through the Menu foreign key attribute.
	 *
	 * @param      Menu $l Menu
	 * @return     void
	 * @throws     PropelException
	 */
	public function addMenuRelatedByParentId(Menu $l)
	{
		if ($this->collMenusRelatedByParentId === null) {
			$this->initMenusRelatedByParentId();
		}
		if (!in_array($l, $this->collMenusRelatedByParentId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collMenusRelatedByParentId, $l);
			$l->setMenuRelatedByParentId($this);
		}
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collMenusRelatedByParentId) {
				foreach ((array) $this->collMenusRelatedByParentId as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collMenusRelatedByParentId = null;
			$this->aMenuRelatedByParentId = null;
	}

} // BaseMenu
