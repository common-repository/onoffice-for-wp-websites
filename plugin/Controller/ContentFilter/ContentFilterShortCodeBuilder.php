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

declare (strict_types=1);

namespace onOffice\WPlugin\Controller\ContentFilter;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Generator;

/**
 *
 */

class ContentFilterShortCodeBuilder
{
	/** @var Container */
	private $_pContainer;

	/** @var array */
	private $_classes = [
		ContentFilterShortCodeEstate::class,
		ContentFilterShortCodeAddress::class,
		ContentFilterShortCodeForm::class,
		ContentFilterShortCodeImprint::class,
		ContentFilterShortCodeLink::class,
	];


	/**
	 *
	 * @param Container $pContainer
	 *
	 */

	public function __construct(Container $pContainer)
	{
		$this->_pContainer = $pContainer;
	}

	/**
	 *
	 * @return Generator
	 * @throws DependencyException
	 * @throws NotFoundException
	 */

	public function buildAllContentFilterShortCodes(): Generator
	{
		foreach ($this->_classes as $classname) {
			yield $this->_pContainer->get($classname);
		}
	}


	/**
	 *
	 * @return array
	 *
	 */

	public function getClasses(): array
	{
		return $this->_classes;
	}
}
