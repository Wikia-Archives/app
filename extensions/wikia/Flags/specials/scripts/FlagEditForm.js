define ('ext.wikia.Flags.FlagEditForm',
	['jquery', 'mw', 'wikia.loader', 'wikia.cache', 'wikia.nirvana', 'wikia.mustache', 'BannerNotification'],
	function ($, mw, loader, cache, nirvana, mustache, BannerNotification) {
		/* In order of appearance */
		var formData,
			modalConfig,
			resourcesCacheKey = 'flagEditFormResources',
			emptyFormCacheKey = 'flagEditFormEmpty',
			cacheVersion = '1.0',
			allFlagsNames = [];

		function init(prefillData) {
			$.when(getFormResources()).done(function (formResources) {
				getAllFlagNames();
				setupForm(formResources);

				/** Check prefillData for undefined or null **/
				if (prefillData == null) {
					modalConfig.vars.type = 'create';
					displayFormCreate();
				} else {
					modalConfig.vars.type = 'edit';
					displayFormEdit(prefillData);
				}
			});
		}

		function getFormResources() {
			var formResources = cache.get(getResourcesCacheKey());

			/** Check formResources and formResources.resources for undefined or null **/
			if (formResources == null || formResources.resources == null) {
				formResources = loader({
					type: loader.MULTI,
					resources: {
						messages: 'FlagsCreateForm',
						mustache: '/extensions/wikia/Flags/specials/templates/SpecialFlags_createFlagForm.mustache,/extensions/wikia/Flags/specials/templates/createFormParam.mustache',
						styles: '/extensions/wikia/Flags/specials/styles/CreateForm.scss'
					}
				});

				cache.set(getResourcesCacheKey(), formResources, cache.CACHE_LONG);
			}

			return formResources;
		}

		function setupForm(formResources) {
			loader.processStyle(formResources.styles);
			mw.messages.set(formResources.messages);

			formData = {
				/* TODO - Do something with the damn messages */
				messages: formResources.messages,
				template: formResources.mustache[0],
				partials: {
					createFormParam: formResources.mustache[1]
				}
			};

			modalConfig = {
				vars: {
					id: 'FlagEditForm',
					classes: ['flag-edit-form'],
					size: 'medium', // size of the modal
					buttons: getButtons(),
					content: '' // content
				}
			};
		}

		function getButtons() {
			return [
				{
					vars: {
						classes: ['normal', 'primary'],
						data: [
							{
								key: 'event',
								value: 'done'
							}
						]
					}
				},
				{
					vars: {
						data: [
							{
								key: 'event',
								value: 'close'
							}
						]
					}
				}
			];
		}

		function displayFormCreate() {
			/* TODO - We can get a half-rendered template to avoid escaping messages in front-end */
			var content = cache.get(getEmptyFormCacheKey());
			/** **/
			if (content == null) {
				var formParams = {
					messages: formData.messages,
					values: getDropdownOptions({})
				};
				content = mustache.to_html(formData.template, formParams, formData.partials);

				cache.set(getEmptyFormCacheKey(), content, cache.CACHE_LONG);
			}

			modalConfig.vars.content = content;

			modalConfig.vars.title = mw.message('flags-special-create-form-title-new').escaped();
			modalConfig.vars.buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			modalConfig.vars.buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

			displayModal();
		}

		function displayFormEdit(prefillData) {
			var formParams = {
				messages: formData.messages,
				values: getDropdownOptions(prefillData)
			};

			modalConfig.vars.content = mustache.to_html(formData.template, formParams, formData.partials);

			modalConfig.vars.title = mw.message('flags-special-create-form-title-edit').escaped();
			modalConfig.vars.buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			modalConfig.vars.buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

			displayModal();
		}

		function displayModal() {
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				uiFactory.init(['modal']).then(function (uiModal) {
					uiModal.createComponent(modalConfig, processInstance);
				});
			});
		}

		function processInstance(modalInstance) {
			modalInstance.show();
			modalInstance.bind('done', saveEditForm);
			$('.flags-special-form-params-new-link').on('click', addNewParameterInput);
		}

		function saveEditForm() {
			var data = collectFormData(),
				method;

			if (data === false) {
				return false;
			}

			if (modalConfig.vars.type === 'create') {
				method = 'addFlagType';
			} else if (modalConfig.vars.type === 'edit') {
				method = 'updateFlagType';

				data.flag_type_id = $('.flags-special-form').data('flag-type-id');
				if (data.flag_type_id <= 0) {
					return false;
				}
			}

			nirvana.sendRequest({
				controller: 'FlagsApiController',
				method: method,
				data: data,
				callback: function (json) {
					if (json.status === true) {
						location.reload(true);
					} else if (json.status === false && json.data === false) {
						showWarningNotification('flags-special-create-form-save-nochange');
					} else {
						showErrorNotification('flags-special-create-form-save-failure');
					}
				}
			});
		}

		function collectFormData() {
			var flagName,
				flagView,
				params = {};

			flagName = $('#flags-special-form-name').val();
			if (flagName.length === 0) {
				showErrorNotification('flags-special-create-form-invalid-name');
				return false;
			}

			var oldFlagName = $('#flags-special-form-name').data('flag-name');
			if (flagName !== oldFlagName && allFlagsNames.indexOf(flagName) > -1) {
				showErrorNotification('flags-special-create-form-invalid-name-exists');
				return false;
			}

			flagView = $('#flags-special-form-template').val();
			if (flagView.length === 0) {
				showErrorNotification('flags-special-create-form-invalid-template');
				return false;
			}

			var paramsStatus = true;
			$('.flags-special-form-param').each(function () {
				var name = $(this).find('.flags-special-form-param-name-input').val();
				if (name.length === 0) {
					paramsStatus = false;
					return false;
				} else {
					params[name] = $(this).find('.flags-special-form-param-description-input').val();
				}
			});

			if (!paramsStatus) {
				showErrorNotification('flags-special-create-form-invalid-param-name');
				return false;
			}

			return {
				edit_token: mw.user.tokens.get('editToken'),
				flag_name: flagName,
				flag_view: flagView,
				flag_group: $('#flags-special-form-group option:selected').val(),
				flag_targeting: $('#flags-special-form-targeting option:selected').val(),
				flag_params_names: JSON.stringify(params)
			}
		}

		function getAllFlagNames() {
			if (allFlagsNames.length === 0) {
				$('.flags-special-list-item-name').each( function() {
					allFlagsNames.push($(this).data('flag-name'));
				});
			}
		}

		function addNewParameterInput() {
			var tbody = $('.flags-special-form-params-tbody'),
				partial = mustache.to_html(formData.partials.createFormParam, {});

			tbody.append(partial);
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		function getEmptyFormCacheKey() {
			return emptyFormCacheKey + ':' + cacheVersion;
		}

		function getDropdownOptions(values) {
			/* TODO - i18n and move it from here right now! */
			values.groups = [
				{
					name: 'Spoiler',
					value: 1
				},
				{
					name: 'Disambiguation',
					value: 2
				},
				{
					name: 'Canon',
					value: 3
				},
				{
					name: 'Stub',
					value: 4
				},
				{
					name: 'Delete',
					value: 5
				},
				{
					name: 'Improvements',
					value: 6
				},
				{
					name: 'Status',
					value: 7
				},
				{
					name: 'Other',
					value: 8
				},
			];
			values.targeting = [
				{
					name: 'Readers',
					value: 1
				},
				{
					name: 'Contributors',
					value: 2
				},
			];

			if (values.selectedGroup != null) {
				for (var key in values.groups) {
					if (values.groups[key].value === values.selectedGroup) {
						values.groups[key].selected = true;
						break;
					}
				}
			}

			if (values.selectedTargeting != null) {
				for (var key in values.targeting) {
					if (values.targeting[key].value === values.selectedTargeting) {
						values.targeting[key].selected = true;
						break;
					}
				}
			}

			return values;
		}

		function showWarningNotification(msgKey) {
			new BannerNotification(
				mw.message(msgKey).escaped(),
				'warning'
			).show();
		}

		function showErrorNotification(msgKey) {
			new BannerNotification(
				mw.message(msgKey).escaped(),
				'error'
			).show();
		}

		return {
			init: init
		}
	}
);
