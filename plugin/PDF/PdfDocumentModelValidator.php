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

namespace onOffice\WPlugin\PDF;

use DI\DependencyException;
use DI\NotFoundException;
use onOffice\SDK\onOfficeSDK;
use onOffice\WPlugin\API\APIClientActionGeneric;
use onOffice\WPlugin\API\ApiClientException;
use onOffice\WPlugin\DataView\DataDetailViewHandler;
use onOffice\WPlugin\DataView\DataListView;
use onOffice\WPlugin\DataView\DataListViewFactory;
use onOffice\WPlugin\DataView\UnknownViewException;
use onOffice\WPlugin\Filter\DefaultFilterBuilderDetailView;
use onOffice\WPlugin\Filter\DefaultFilterBuilderFactory;

/**
 *
 * Validates a PdfDocumentModel by checking if the contained estate ID is visible in
 * the list with the name provided in PdfDocumentModel.
 *
 */

class PdfDocumentModelValidator
{
	/** @var APIClientActionGeneric */
	private $_pAPIClientActionGeneric;

	/** @var DataDetailViewHandler */
	private $_pDataDetailViewHandler;

	/** @var DataListViewFactory */
	private $_pDataListViewFactory;

	/** @var DefaultFilterBuilderFactory */
	private $_pDefaultFilterBuilderFactory;

	/**
	 * @param APIClientActionGeneric $pAPIClientActionGeneric
	 * @param DataDetailViewHandler $pDataDetailViewHandler
	 * @param DataListViewFactory $pDataListViewFactory
	 * @param DefaultFilterBuilderFactory $pDefaultFilterBuilderFactory
	 */
	public function __construct(
		APIClientActionGeneric $pAPIClientActionGeneric,
		DataDetailViewHandler $pDataDetailViewHandler,
		DataListViewFactory $pDataListViewFactory,
		DefaultFilterBuilderFactory $pDefaultFilterBuilderFactory)
	{
		$this->_pAPIClientActionGeneric = $pAPIClientActionGeneric;
		$this->_pDataDetailViewHandler = $pDataDetailViewHandler;
		$this->_pDataListViewFactory = $pDataListViewFactory;
		$this->_pDefaultFilterBuilderFactory = $pDefaultFilterBuilderFactory;
	}

	/**
	 * @param PdfDocumentModel $pModel
	 * @return PdfDocumentModel
	 * @throws ApiClientException
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws PdfDocumentModelValidationException
	 */
	public function validate(PdfDocumentModel $pModel): PdfDocumentModel
	{
		$pModelClone = clone $pModel;
		try {
			$parametersGetEstate = $this->buildParameters($pModelClone);
		} catch (UnknownViewException $pEx) {
			throw new PdfDocumentModelValidationException('', 0, $pEx);
		}

		$pApiClientAction = $this->_pAPIClientActionGeneric
			->withActionIdAndResourceType(onOfficeSDK::ACTION_ID_READ, 'estate');
		$pApiClientAction->setParameters($parametersGetEstate);
		$pApiClientAction->addRequestToQueue()->sendRequests();

		if ($pModelClone->getTemplate() === '' ||
			!$pApiClientAction->getResultStatus() ||
			count($pApiClientAction->getResultRecords()) !== 1) {
			throw new PdfDocumentModelValidationException();
		}
		$pModelClone->setEstateIdExternal
			($pApiClientAction->getResultRecords()[0]['elements']['objektnr_extern']);
		return $pModelClone;
	}

	/**
	 * @param PdfDocumentModel $pModel
	 * @return array
	 * @throws UnknownViewException
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	private function buildParameters(PdfDocumentModel $pModel): array
	{
		$parametersGetEstate = [
			'data' => ['Id', 'objektnr_extern'],
			'estatelanguage' => $pModel->getLanguage(),
			'formatoutput' => 0,
		];

		$pView = $this->_pDataDetailViewHandler->getDetailView();
		$isDetailView = $pModel->getViewName() === $pView->getName();

		if ($isDetailView) {
			$pModel->setTemplate($pView->getExpose());
			$pDefaultFilterBuilder = new DefaultFilterBuilderDetailView();
			$pDefaultFilterBuilder->setEstateId($pModel->getEstateId());
			$filter = $pDefaultFilterBuilder->buildFilter();
		} else {
			 /* @var $pView DataListView */
			$pView = $this->_pDataListViewFactory->getListViewByName($pModel->getViewName());
			$pModel->setTemplate($pView->getExpose());
			$pDefaultFilterBuilder = $this->_pDefaultFilterBuilderFactory->buildDefaultListViewFilter($pView);
			$filter = $pDefaultFilterBuilder->buildFilter();
			$filter['Id'][] = ['op' => '=', 'val' => $pModel->getEstateId()];
			$parametersGetEstate['filterid'] = $pView->getFilterId();
		}

		$parametersGetEstate['filter'] = $filter;
		return $parametersGetEstate;
	}
}
