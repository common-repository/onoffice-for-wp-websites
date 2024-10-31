<?php

/**
 *
 *    Copyright (C) 2020 onOffice GmbH
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

namespace onOffice\WPlugin\Field\Collection;

use onOffice\SDK\onOfficeSDK;
use onOffice\WPlugin\Field\UnknownFieldException;
use onOffice\WPlugin\Types\Field;
use onOffice\WPlugin\Types\FieldsCollection;

class FieldsCollectionFieldDuplicatorForGeoEstate
{
	/**
	 * @param FieldsCollection $pFieldsCollection
	 */
	public function duplicateFields(FieldsCollection $pFieldsCollection)
	{
		try {
			$pFieldLand = $pFieldsCollection->getFieldByModuleAndName
				(onOfficeSDK::MODULE_ESTATE, 'land');
			$row = $pFieldLand->getAsRow();
			$pFieldCountry = Field::createByRow('country', $row);
			$pFieldsCollection->addField($pFieldCountry);
		} catch (UnknownFieldException $e) {}
	}
}