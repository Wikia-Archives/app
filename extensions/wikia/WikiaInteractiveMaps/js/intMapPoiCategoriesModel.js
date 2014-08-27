define('wikia.intMap.poiCategoriesModel',
	[
		'jquery',
		'wikia.intMap.utils'
	],
	function($, utils) {
		'use strict';

		var poiCategoriesOriginalData;

		function setPoiCategoriesOriginalData(data) {
			poiCategoriesOriginalData = data;
		}

		/**
		 * @desc gets parent POI categories list from backend
		 * @returns {object} - promise
		 */
		function getParentPoiCategories() {
			return $.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsPoiCategory',
				method: 'getParentPoiCategories',
				format: 'json'
			});
		}

		/**
		 * @desc returns true if POI category is invalid
		 * @param {object} poiCategory
		 * @returns {boolean} - is valid
		 */
		function isPoiCategoryInvalid(poiCategory) {
			return utils.isEmpty(poiCategory.name);
		}

		/**
		 * @desc checks if POI category data was changed by user
		 * @param {object} poiCategoryOriginal
		 * @param {object} poiCategory
		 * @returns {boolean} - is POI category changed
		 */
		function isPoiCategoryChanged(poiCategoryOriginal, poiCategory) {
			if (poiCategory.name !== poiCategoryOriginal.name) {
				return true;
			}

			if (poiCategory.parent_poi_category_id !== poiCategoryOriginal.parent_poi_category_id) {
				return true;
			}

			// if marker property is not empty it means there was a new image uploaded
			if (poiCategory.marker) {
				return true;
			}

			return false;
		}

		/**
		 * @desc finds POI category in array by looking at ids
		 * @param id - POI category id
		 * @param poiCategories - array of POI categories
		 * @returns {object|null} - POI category with given id or null if not found
		 */
		function findPoiCategoryById(id, poiCategories) {
			return $.grep(poiCategories, function (item) {
				return item.id === id;
			})[0] || null;
		}

		/**
		 * @desc organizes form data to object that will be sent to backend
		 * @param {object} formSerialized
		 * @returns {object} - organized POI categories data
		 */
		function organizePoiCategories(formSerialized) {
			var poiCategories = {
				mapId: parseInt(formSerialized.mapId, 10),
				poiCategoriesToCreate: [],
				poiCategoriesToUpdate: [],
				poiCategoriesToDelete: []
			};

			if (formSerialized.poiCategories) {
				formSerialized.poiCategories.forEach(function (poiCategory) {
					var poiCategoryOriginal;

					if (poiCategory.parent_poi_category_id) {
						poiCategory.parent_poi_category_id = parseInt(poiCategory.parent_poi_category_id, 10);
					}

					if (poiCategory.id) {
						poiCategory.id = parseInt(poiCategory.id, 10);

						poiCategoryOriginal = findPoiCategoryById(poiCategory.id, poiCategoriesOriginalData);

						if (poiCategoryOriginal && isPoiCategoryChanged(poiCategoryOriginal, poiCategory)) {
							poiCategories.poiCategoriesToUpdate.push(poiCategory);
						}
					} else {
						delete poiCategory.id;
						poiCategories.poiCategoriesToCreate.push(poiCategory);
					}
				});
			}

			if (formSerialized.poiCategoriesToDelete) {
				poiCategories.poiCategoriesToDelete = formSerialized.poiCategoriesToDelete.split(',').map(Number);
			}

			return poiCategories;
		}

		/**
		 * @desc sends POI categories data to PHP controller
		 * @param {object} data - object with serialized and validated form
		 */
		function sendPoiCategories(data) {
			return $.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsPoiCategory',
				method: 'editPoiCategories',
				format: 'json',
				data: data
			});
		}

		/**
		 * @desc cleans up POI category data after updating it, copies what's needed from the original data
		 * @param {object} poiCategoryUpdated
		 * @param {object} poiCategoryOriginal
		 * @returns {object} - POI category with current data
		 */
		function setPoiCategoryUpdatedData(poiCategoryUpdated, poiCategoryOriginal) {
			poiCategoryUpdated.map_id = poiCategoryOriginal.map_id;
			poiCategoryUpdated.status = poiCategoryOriginal.status;
			poiCategoryUpdated.marker = (!poiCategoryOriginal.no_marker && !poiCategoryUpdated.marker) ?
				poiCategoryOriginal.marker :
				poiCategoryUpdated.marker;

			if (poiCategoryOriginal.no_marker && !poiCategoryUpdated.marker) {
				poiCategoryUpdated.no_marker = true;
			}

			return poiCategoryUpdated;
		}

		/**
		 * @desc gets POI category that was updated, returns null if it wasn't
		 * @param {object} poiCategoryOriginal
		 * @param {object} dataSent - POI categories sent to backend
		 * @param {object} dataReceived - response from backend, array of actions done and categories affected
		 * @returns {object|null} - updated POI category or null
		 */
		function getPoiCategoryUpdated(poiCategoryOriginal, dataSent, dataReceived) {
			var poiCategoryUpdated;

			if (
				dataReceived.poiCategoriesUpdated &&
				dataReceived.poiCategoriesUpdated.indexOf(poiCategoryOriginal.id) > -1
			) {
				poiCategoryUpdated = findPoiCategoryById(poiCategoryOriginal.id, dataSent.poiCategoriesToUpdate);
				if (poiCategoryUpdated) {
					poiCategoryUpdated = setPoiCategoryUpdatedData(poiCategoryUpdated, poiCategoryOriginal);
				}
			}

			return poiCategoryUpdated;
		}

		/**
		 * @desc checks if POI category was deleted
		 * @param poiCategory
		 * @param dataReceived
		 * @returns {boolean}
		 */
		function isPoiCategoryDeleted(poiCategory, dataReceived) {
			return dataReceived.poiCategoriesDeleted &&
			dataReceived.poiCategoriesDeleted.indexOf(poiCategory.id) > -1;
		}

		/**
		 * @desc cleans up POI categories data after edit
		 * @param {object} dataSent - POI categories sent to backend
		 * @param {object} dataReceived - response from backend, array of actions done and categories affected
		 * @returns {Array} - current POI categories list
		 */
		function updatePoiCategoriesData(dataSent, dataReceived) {
			var currentPoiCategories = [];

			poiCategoriesOriginalData.forEach(function (poiCategoryOriginal) {
				var poiCategoryUpdated = getPoiCategoryUpdated(poiCategoryOriginal, dataSent, dataReceived);

				// POI category updated
				if (poiCategoryUpdated) {
					currentPoiCategories.push(poiCategoryUpdated);
					return;
				}

				// POI category not changed
				if (!isPoiCategoryDeleted(poiCategoryOriginal, dataReceived)) {
					currentPoiCategories.push(poiCategoryOriginal);
				}

				// POI category deleted
			});

			if (dataReceived.poiCategoriesCreated) {
				dataReceived.poiCategoriesCreated.forEach(function (poiCategory) {
					// POI category created
					currentPoiCategories.push(poiCategory);
				});
			}

			return currentPoiCategories;
		}

		return {
			setPoiCategoriesOriginalData: setPoiCategoriesOriginalData,
			getParentPoiCategories: getParentPoiCategories,
			isPoiCategoryInvalid: isPoiCategoryInvalid,
			isPoiCategoryChanged: isPoiCategoryChanged,
			isPoiCategoryDeleted: isPoiCategoryDeleted,
			findPoiCategoryById: findPoiCategoryById,
			organizePoiCategories: organizePoiCategories,
			sendPoiCategories: sendPoiCategories,
			setPoiCategoryUpdatedData: setPoiCategoryUpdatedData,
			updatePoiCategoriesData: updatePoiCategoriesData
		};
	}
);
