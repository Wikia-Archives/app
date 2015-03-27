/*global describe, it, modules, expect, spyOn*/
describe('iframeWriter module', function () {
	'use strict';

	var mocks, testIframeSettings;

	function noop() {
		return;
	}

	function getModule() {
		return modules['wikia.iframeWriter'](
			mocks.document, mocks.log
		);
	}

	mocks = {
		document: {
			createElement: function () {
				return {
					classList: {
						classes: [],
						add: function (className) {
							this.classes.push(className);
						}
					}
				};
			}
		},
		log: noop
	};

	testIframeSettings = {
		width: 123,
		height: 456,
		code: 'test'
	};

	it('Default functionality', function () {
		var iframe = getModule().getIframe(testIframeSettings);

		expect(iframe.width).toBe(123);
		expect(iframe.height).toBe(456);
		expect(iframe.frameborder).toBe('no');
		expect(iframe.scrolling).toBe('no');
		expect(iframe.onload).toBeDefined();
	});

	it('Custom classes', function () {
		var settings = testIframeSettings,
			iframe;

		settings.class = 'a-class';
		iframe = getModule().getIframe(settings);

		expect(iframe.classList.classes).toEqual(['a-class']);
	});
});
