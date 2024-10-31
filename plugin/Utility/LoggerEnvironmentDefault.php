<?php

/**
 *
 *    Copyright (C) 2019 onOffice GmbH
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Affero General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace onOffice\WPlugin\Utility;

use onOffice\WPlugin\Controller\UserCapabilities;

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2003-2019, onOffice(R) GmbH
 *
 */

class LoggerEnvironmentDefault
	implements LoggerEnvironment
{
	/** @var UserCapabilities */
	private $_pUserCapabilities = null;


	/**
	 *
	 * @param UserCapabilities $pUserCapabilities
	 *
	 */

	public function __construct(UserCapabilities $pUserCapabilities = null)
	{
		$this->_pUserCapabilities = $pUserCapabilities ?? new UserCapabilities();
	}


	/**
	 *
	 * @return UserCapabilities
	 *
	 */

	public function getUserCapabilities(): UserCapabilities
	{
		return $this->_pUserCapabilities;
	}


	/**
	 *
	 * @param string $string
	 *
	 */

	public function log(string $string)
	{
		// @codeCoverageIgnoreStart
		error_log($string);
	} // @codeCoverageIgnoreEnd
}
