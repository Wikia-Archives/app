define( 'ext.wikia.AffiliateService.templates', [], function() {
    'use strict';

    function unit(options) {
        var logos = '';
        var disclaimer = '';

        if (options.logoLight) {
            logos = '<img class="aff-unit__logo light" src="' + options.logoLight + '">'
                + '<img class="aff-unit__logo dark" src="' + options.logoDark + '">';
        }
        console.log('showDisclaimer', options.showDisclaimer);
        if (options.showDisclaimer) {
            disclaimer = '<p class="aff-unit__disclaimer-message">'
                + 'Fandom may earn an affiliate commission on sales made from links on this page.'
                + '</p>';
        }

        return '<div class="aff-unit__wrapper">'
            + '<a class="aff-unit__link" href="' + options.link + '" target="_blank">'
            + '<div class="aff-unit__image-wrapper" style="background-image: url(' + options.image + ')"></div>'
            + '<div class="aff-unit__info">'
            + '<p class="aff-unit__header">' + options.heading + '</p>'
            + '<button class="wds-button wds-is-secondary aff-unit__cta">' + options.buttonText + '</button>'
            + logos
            + '</div>'
            + '</a>'
            + '</div>' 
            + disclaimer;
    }

    return {
        unit: unit,
    };
});
