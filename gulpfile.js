'use strict';

const GULP = require( 'gulp' ),
    SASS = require( 'gulp-sass' ),
    AUTOPREFIXER = require( 'gulp-autoprefixer' ),
    NANO = require( 'gulp-cssnano' ),
    BABEL = require( 'gulp-babel' ),
    UGLIFY = require( 'gulp-uglify' ),
    IMAGEMIN = require( 'gulp-imagemin' ),
    RENAME = require( 'gulp-rename' ),
    CONCAT = require( 'gulp-concat' ),
    SOURCEMAPS = require( 'gulp-sourcemaps' ),
    DEL = require( 'del' ),
    ESLINT = require( 'gulp-eslint' ),
    BROWSERSYNC = require( 'browser-sync' ).create( );

GULP.task( 'styles', function ( ) {

    // List al your SASS files HERE
    const SCSS_FILES = [
        'assets/styles/main.scss'
    ];

    GULP.src( SCSS_FILES )
        .pipe( SOURCEMAPS.init( ) )
        .pipe( SASS( )
            .on( 'error', function ( err ) {
                console.error(
                    'Error found:\n\x07' + err.message
                );
            } )
        )
        .pipe( AUTOPREFIXER( ) )
        .pipe( SOURCEMAPS.write( ) )
        .pipe( GULP.dest( 'dist/styles' ) )
        .pipe( BROWSERSYNC.stream( ) )
} );

GULP.task( 'styles-min', function ( ) {
    const SCSS_FILES = [
        'assets/styles/main.scss'
    ];

    GULP.src( SCSS_FILES )
        .pipe( SASS( )
            .on( 'error', function ( err ) {
                console.error(
                    'Error found:\n\x07' + err.message
                );
            } )
        )
        .pipe( AUTOPREFIXER( ) )
        .pipe( RENAME( {
            suffix: '.min'
        } ) )
        .pipe( NANO( {
            discardComments: {
                removeAll: true
            }
        } ) )
        .pipe( GULP.dest( 'dist/styles' ) )
} );

const CUSTOMJS_FILES = [
    'assets/scripts/**/*.js'
];

GULP.task( 'custom-scripts', function ( ) {

    return GULP.src( CUSTOMJS_FILES )
        .pipe( ESLINT( {
            fix: true
        } ) )
        .pipe( ESLINT.format( ) )
} );


// List all your JS files HERE
const JS_FILES = [
    'node_modules/jquery/dist/jquery.js',
    'node_modules/foundation-sites/dist/js/foundation.js',
    'assets/scripts/**/*.js'
];

GULP.task( 'scripts', function ( ) {

    return GULP.src( JS_FILES )

        .pipe( SOURCEMAPS.init( ) )
        .pipe( CONCAT( 'main.js' ) )
        .pipe( SOURCEMAPS.write( ) )
        .pipe( GULP.dest( 'dist/scripts' ) )
        .pipe( BROWSERSYNC.stream( ) )
} );

GULP.task( 'scripts-min', function ( ) {
    return GULP.src( JS_FILES )

        .pipe( BABEL( ) )
        .pipe( CONCAT( 'main.min.js' ) )
        .pipe( UGLIFY( )
            .on( 'error', function ( err ) {
                console.error(
                    err.toString( )
                );
                this.emit( 'end' );
            } ) )
        .pipe( GULP.dest( 'dist/scripts' ) )
} );

const RESOURCES_FILES = [
    'assets/resources/**/*.js'
];

GULP.task( 'resources', function ( ) {

    return GULP.src( RESOURCES_FILES )

        .pipe( SOURCEMAPS.init( ) )
        .pipe( SOURCEMAPS.write( ) )
        .pipe( BABEL( ) )
        .pipe( ESLINT( {
            fix: true
        } ) )
        .pipe( ESLINT.format( ) )
        .pipe( UGLIFY( )
            .on( 'error', function ( err ) {
                console.error(
                    err.toString( )
                );
                this.emit( 'end' );
            } ) )
        .pipe( GULP.dest( 'dist/scripts' ) )
        .pipe( BROWSERSYNC.stream( ) )
} );

const PHP_FILES = [
    '{inc,template-parts}/**/*.php',
    '*.php'
];

GULP.task( 'php', function ( ) {
    BROWSERSYNC.reload;
    return;
} );

const IMG_FILES = [
    'assets/images/**/*'
];

GULP.task( 'images', function ( ) {
    return GULP.src( IMG_FILES )
        .pipe( GULP.dest( 'dist/images' ) )
        .pipe( BROWSERSYNC.stream( ) );
} );

GULP.task( 'images-min', function ( ) {

    return GULP.src( IMG_FILES )
        .pipe( IMAGEMIN( {
            optimizationLevel: 3,
            progressive: true,
            INTERLACED: true,
            use: [ IMAGEMIN.gifsicle( ), IMAGEMIN.jpegtran( ), IMAGEMIN.optipng( ), IMAGEMIN.svgo( ) ]
        } ) )
        .pipe( GULP.dest( 'dist/images' ) );
} );

const FONT_FILES = [
    'node_modules/@fortawesome/fontawesome-free-webfonts/webfonts/*',
    'assets/fonts/**/*'
];

GULP.task( 'fonts', function ( ) {

    return GULP.src( FONT_FILES )
        .pipe( GULP.dest( 'dist/fonts' ) )
        .pipe( BROWSERSYNC.stream( ) );
} );

GULP.task( 'fonts-min', function ( ) {

    return GULP.src( FONT_FILES )
        .pipe( GULP.dest( 'dist/fonts' ) );
} );

GULP.task( 'clean', function ( cb ) {
    return DEL( [ 'dist/styles', 'dist/scripts', 'dist/resources', 'dist/images', 'dist/fonts' ], cb )
} );

GULP.task( 'default', [ 'clean' ], function ( ) {
    GULP.start( 'styles', 'custom-scripts', 'scripts', 'resources', 'php', 'images', 'fonts' );
} );

GULP.task( 'production', [ 'clean' ], function ( ) {
    GULP.start( 'styles-min', 'scripts-min', 'resources', 'images-min', 'fonts-min' );
} );

GULP.task( 'watch', function ( ) {

    // Run the styles task first time gulp watch is run
    GULP.start( 'styles' );

    BROWSERSYNC.init( {
        files: [ '{inc,template-parts}/**/*.php', '*.php' ],
        proxy: 'http://localhost/podium/',
        snippetOptions: {
            whitelist: [ '/wp-admin/admin-ajax.php' ],
            blacklist: [ '/wp-admin/**' ]
        }
    } );
    GULP.watch( [ 'assets/styles/**/*' ], [ 'styles' ] );
    GULP.watch( [ 'assets/scripts/**/*' ], [ 'scripts', 'custom-scripts' ] );
    GULP.watch( [ 'assets/fonts/**/*' ], [ 'fonts' ] );
    GULP.watch( [ 'assets/images/**/*' ], [ 'images' ] );
    GULP.watch( [ 'assets/resources/**/*' ], [ 'resources' ] );
    GULP.watch( [ '{inc,template-parts}/**/*.php', '*.php' ], [ 'php' ] );
} );
