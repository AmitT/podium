'use strict';

const gulp = require( 'gulp' ),
    sass = require( 'gulp-sass' ),
    autoprefixer = require( 'gulp-autoprefixer' ),
    nano = require( 'gulp-cssnano' ),
    babel = require( 'gulp-babel' ),
    uglify = require( 'gulp-uglify' ),
    imagemin = require( 'gulp-imagemin' ),
    rename = require( 'gulp-rename' ),
    concat = require( 'gulp-concat' ),
    sourcemaps = require( 'gulp-sourcemaps' ),
    del = require( 'del' ),
    eslint = require( 'gulp-eslint' ),
    browserSync = require( 'browser-sync' ).create( );

gulp.task( 'styles', function ( ) {

    // List al your SASS files HERE
    const scss_files = [
        'assets/styles/main.scss'
    ];

    gulp.src( scss_files )
        .pipe( sourcemaps.init( ) )
        .pipe( sass( )
            .on( 'error', function ( err ) {
                console.error(
                    'Error found:\n\x07' + err.message
                );
            } )
        )
        .pipe( autoprefixer( ) )
        .pipe( sourcemaps.write( ) )
        .pipe( gulp.dest( 'dist/styles' ) )
        .pipe( browserSync.stream( ) )
} );

gulp.task( 'styles-min', function ( ) {
    const scss_files = [
        'assets/styles/main.scss'
    ];

    gulp.src( scss_files )
        .pipe( sass( )
            .on( 'error', function ( err ) {
                console.error(
                    'Error found:\n\x07' + err.message
                );
            } )
        )
        .pipe( autoprefixer( ) )
        .pipe( rename( {
            suffix: '.min'
        } ) )
        .pipe( nano( {
            discardComments: {
                removeAll: true
            }
        } ) )
        .pipe( gulp.dest( 'dist/styles' ) )
} );

const customjs_files = [
    'assets/scripts/**/*.js'
];

gulp.task( 'custom-scripts', function ( ) {

    return gulp.src( customjs_files )
        .pipe( eslint( {
            fix: true
        } ) )
        .pipe( eslint.format( ) )
} );


// List all your JS files HERE
const js_files = [
    'node_modules/jquery/dist/jquery.js',
    'node_modules/foundation-sites/dist/js/foundation.js',
    'assets/scripts/**/*.js'
];

gulp.task( 'scripts', function ( ) {

    return gulp.src( js_files )

        .pipe( sourcemaps.init( ) )
        .pipe( concat( 'main.js' ) )
        .pipe( sourcemaps.write( ) )
        .pipe( gulp.dest( 'dist/scripts' ) )
        .pipe( browserSync.stream( ) )
} );

gulp.task( 'scripts-min', function ( ) {
    return gulp.src( js_files )

        .pipe( babel( ) )
        .pipe( concat( 'main.min.js' ) )
        .pipe( uglify( )
            .on( 'error', function ( err ) {
                console.error(
                    err.toString( )
                );
                this.emit( 'end' );
            } ) )
        .pipe( gulp.dest( 'dist/scripts' ) )
} );

const resources_files = [
    'assets/resources/**/*.js'
];

gulp.task( 'resources', function ( ) {

    return gulp.src( resources_files )

        .pipe( sourcemaps.init( ) )
        .pipe( sourcemaps.write( ) )
        .pipe( babel( ) )
        .pipe( eslint( {
            fix: true
        } ) )
        .pipe( eslint.format( ) )
        .pipe( uglify( )
            .on( 'error', function ( err ) {
                console.error(
                    err.toString( )
                );
                this.emit( 'end' );
            } ) )
        .pipe( gulp.dest( 'dist/scripts' ) )
        .pipe( browserSync.stream( ) )
} );

const php_files = [
    '{inc,template-parts}/**/*.php',
    '*.php'
];

gulp.task( 'php', function ( ) {
    browserSync.reload;
    return;
} );

const img_files = [
    'assets/images/**/*'
];

gulp.task( 'images', function ( ) {
    return gulp.src( img_files )
        .pipe( gulp.dest( 'dist/images' ) )
        .pipe( browserSync.stream( ) );
} );

gulp.task( 'images-min', function ( ) {

    return gulp.src( img_files )
        .pipe( imagemin( {
            optimizationLevel: 3,
            progressive: true,
            interlaced: true,
            use: [ imagemin.gifsicle( ), imagemin.jpegtran( ), imagemin.optipng( ), imagemin.svgo( ) ]
        } ) )
        .pipe( gulp.dest( 'dist/images' ) );
} );

const font_files = [
    'node_modules/font-awesome/fonts/*',
    'assets/fonts/**/*'
];

gulp.task( 'fonts', function ( ) {

    return gulp.src( font_files )
        .pipe( gulp.dest( 'dist/fonts' ) )
        .pipe( browserSync.stream( ) );
} );

gulp.task( 'fonts-min', function ( ) {

    return gulp.src( font_files )
        .pipe( gulp.dest( 'dist/fonts' ) );
} );

gulp.task( 'clean', function ( cb ) {
    return del( [ 'dist/styles', 'dist/scripts', 'dist/resources', 'dist/images', 'dist/fonts' ], cb )
} );

gulp.task( 'default', [ 'clean' ], function ( ) {
    gulp.start( 'styles', 'custom-scripts', 'scripts', 'resources', 'php', 'images', 'fonts' );
} );

gulp.task( 'production', [ 'clean' ], function ( ) {
    gulp.start( 'styles-min', 'scripts-min', 'resources', 'images-min', 'fonts-min' );
} );

gulp.task( 'watch', function ( ) {

    // Run the styles task first time gulp watch is run
    gulp.start( 'styles' );

    browserSync.init( {
        files: [ '{inc,template-parts}/**/*.php', '*.php' ],
        proxy: 'http://localhost/podium/',
        snippetOptions: {
            whitelist: [ '/wp-admin/admin-ajax.php' ],
            blacklist: [ '/wp-admin/**' ]
        }
    } );
    gulp.watch( [ 'assets/styles/**/*' ], [ 'styles' ] );
    gulp.watch( [ 'assets/scripts/**/*' ], [ 'scripts', 'custom-scripts' ] );
    gulp.watch( [ 'assets/fonts/**/*' ], [ 'fonts' ] );
    gulp.watch( [ 'assets/images/**/*' ], [ 'images' ] );
    gulp.watch( [ 'assets/resources/**/*' ], [ 'resources' ] );
    gulp.watch( [ '{inc,template-parts}/**/*.php', '*.php' ], [ 'php' ] );
} );
