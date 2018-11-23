var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    .addEntry('wizard', './public/scripts/wizard.js')

    .enableBuildNotifications()
;

module.exports = Encore.getWebpackConfig();
