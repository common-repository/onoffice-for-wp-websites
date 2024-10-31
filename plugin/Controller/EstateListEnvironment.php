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

namespace onOffice\WPlugin\Controller;

use DI\Container;
use onOffice\WPlugin\AddressList;
use onOffice\WPlugin\DataView\DataDetailViewHandler;
use onOffice\WPlugin\EstateFiles;
use onOffice\WPlugin\EstateUnits;
use onOffice\WPlugin\Field\Collection\FieldsCollectionBuilderShort;
use onOffice\WPlugin\Fieldnames;
use onOffice\WPlugin\Filter\DefaultFilterBuilder;
use onOffice\WPlugin\Filter\GeoSearchBuilder;
use onOffice\WPlugin\SDKWrapper;
use onOffice\WPlugin\Types\EstateStatusLabel;
use onOffice\WPlugin\ViewFieldModifier\ViewFieldModifierHandler;

/**
 *
 */
interface EstateListEnvironment
{
	/**
	 * @return SDKWrapper
	 */
	public function getSDKWrapper(): SDKWrapper;

	/**
	 * @return Fieldnames preconfigured with FieldModuleCollectionDecoratorGeoPosition
	 */
	public function getFieldnames(): Fieldnames;

	/**
	 * @return AddressList
	 */
	public function getAddressList(): AddressList;

	/**
	 * @return GeoSearchBuilder
	 */
	public function getGeoSearchBuilder(): GeoSearchBuilder;

	/**
	 * @return EstateFiles
	 */
	public function getEstateFiles(): EstateFiles;

	/**
	 * @return DefaultFilterBuilder
	 */
	public function getDefaultFilterBuilder(): DefaultFilterBuilder;

	/**
	 * @param DefaultFilterBuilder $pDefaultFilterBuilder
	 */
	public function setDefaultFilterBuilder(DefaultFilterBuilder $pDefaultFilterBuilder);

	/**
	 * @return DataDetailViewHandler
	 */
	public function getDataDetailViewHandler(): DataDetailViewHandler;

	/**
	 * @param string $name
	 * @return EstateUnits
	 */
	public function getEstateUnitsByName(string $name): EstateUnits;

	/**
	 * @param array $values
	 */
	public function shuffle(array &$values);

	/**
	 * @param array $fieldList
	 * @param string $modifier
	 * @return ViewFieldModifierHandler
	 */
	public function getViewFieldModifierHandler(array $fieldList, string $modifier): ViewFieldModifierHandler;

	/**
	 * @return EstateStatusLabel
	 */
	public function getEstateStatusLabel(): EstateStatusLabel;

	/**
	 * @return FieldsCollectionBuilderShort
	 */
	public function getFieldsCollectionBuilderShort(): FieldsCollectionBuilderShort;

	/**
	 * @return Container
	 */
	public function getContainer(): Container;
}
