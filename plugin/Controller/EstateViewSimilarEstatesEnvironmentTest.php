<?php

/**
 *
 *    Copyright (C) 2018 onOffice GmbH
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

namespace onOffice\WPlugin\Controller;

use onOffice\tests\EstateListMocker;
use onOffice\tests\TemplateMocker;
use onOffice\WPlugin\DataView\DataView;
use onOffice\WPlugin\Template;

/**
 *
 * @url http://www.onoffice.de
 * @copyright 2003-2018, onOffice(R) GmbH
 *
 */

class EstateViewSimilarEstatesEnvironmentTest
	implements EstateViewSimilarEstatesEnvironment
{
	/** @var EstateListMocker */
	private $_pEstateListMocker;

	/**
	 * @param DataView $pDataView
	 */
	public function __construct(DataView $pDataView)
	{
		$this->_pEstateListMocker = new EstateListMocker($pDataView);
	}

	/**
	 * @return EstateListMocker
	 */
	public function getEstateList(): EstateListBase
	{
		return $this->_pEstateListMocker;
	}

	/**
	 * @return Template
	 */
	public function getTemplate(): Template
	{
		return new TemplateMocker();
	}
}
