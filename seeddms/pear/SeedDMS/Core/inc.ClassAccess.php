<?php
/**
 * Implementation of user and group access object
 *
 * @category   DMS
 * @package    SeedDMS_Core
 * @license    GPL 2
 * @version    @version@
 * @author     Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal, 2006-2008 Malcolm Cowe,
 *             2010 Uwe Steinmann
 * @version    Release: 4.3.13
 */

/**
 * Class to represent a user access right.
 * This class cannot be used to modify access rights.
 *
 * @category   DMS
 * @package    SeedDMS_Core
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal, 2006-2008 Malcolm Cowe,
 *             2010 Uwe Steinmann
 * @version    Release: 4.3.13
 */
class SeedDMS_Core_UserAccess { /* {{{ */
	var $_user;
	var $_mode;

	function SeedDMS_Core_UserAccess($user, $mode) {
		$this->_user = $user;
		$this->_mode = $mode;
	}

	function getUserID() { return $this->_user->getID(); }

	function getMode() { return $this->_mode; }

	function isAdmin() {
		return ($this->_mode == SeedDMS_Core_User::role_admin);
	}

	function getUser() {
		return $this->_user;
	}
} /* }}} */


/**
 * Class to represent a group access right.
 * This class cannot be used to modify access rights.
 *
 * @category   DMS
 * @package    SeedDMS_Core
 * @author     Markus Westphal, Malcolm Cowe, Uwe Steinmann <uwe@steinmann.cx>
 * @copyright  Copyright (C) 2002-2005 Markus Westphal, 2006-2008 Malcolm Cowe, 2010 Uwe Steinmann
 * @version    Release: 4.3.13
 */
class SeedDMS_Core_GroupAccess { /* {{{ */
	var $_group;
	var $_mode;

	function SeedDMS_Core_GroupAccess($group, $mode) {
		$this->_group = $group;
		$this->_mode = $mode;
	}

	function getGroupID() { return $this->_group->getID(); }

	function getMode() { return $this->_mode; }

	function getGroup() {
		return $this->_group;
	}
} /* }}} */
?>
