'use strict';

const gulp = require( 'gulp' ),
sass = require( 'gulp-sass' ),
autoprefixer = require( 'gulp-autoprefixer' ),
nano = require( 'gulp-cssnano' ),
uglify = require( 'gulp-uglify' ),
imagemin = require( 'gulp-imagemin' ),
rename = require( 'gulp-rename' ),
concat = require( 'gulp-concat' ),
sourcemaps = require( 'gulp-sourcemaps' ),
del = require( 'del' ),
notify = require( 'gulp-notify' ),
jshint = require('gulp-jshint'),
stylish = require('jshint-stylish'),
eslint = require('gulp-eslint'),
babel = require('gulp-babel'),
browserSync = require( 'browser-sync' ).create();

require( 'es6-promise' ).polyfill();

gulp.task( 'styles', function() {

	// List al your SASS files HERE
	let scss_files = [
	'assets/styles/main.scss'
	];

	gulp.src( scss_files )
	.pipe( sourcemaps.init() )
	.pipe( sass() ).on( 'error', notify.onError( function ( error ) {
		return "SASS Error: " + error.message;
	}))
	.pipe( autoprefixer( {
		browsers: [
		'last 2 versions',
		'android 4',
		'opera 12'
		]
	} ) )
	.pipe( sourcemaps.write() )
	.pipe( gulp.dest( 'dist/styles' ) )
	.pipe( browserSync.stream() )
	.pipe( notify( 'SCSS files compiled' ) );			// Output to notification
});

gulp.task( 'styles-min', function() {
	let scss_files = [
	'assets/styles/main.scss'
	];

	gulp.src( scss_files )
	.pipe( sass( {errLogToConsole: true} ) )
	.pipe( autoprefixer( {
		browsers: [
		'last 2 versions',
		'android 4',
		'opera 12'
		]
	} ) )
	.pipe( rename( {suffix: '.min'} ) )
	.pipe( nano( {
		discardComments: {
			removeAll: true
		}
	} ) )
	.pipe( gulp.dest( 'dist/styles' ) )
	.pipe( notify( 'SCSS files compiled and minified' ) );			// Output to notification
});

gulp.task( 'rtl-styles', function() {

	// List al your SASS files HERE
	let scss_files = [
	'assets/styles/rtl.scss'
	];

	gulp.src( scss_files )
	.pipe( sourcemaps.init() )
	.pipe( sass() ).on( 'error', notify.onError( function ( error ) {
		// return "SASS Error: " + error.message;
	}))
	.pipe( autoprefixer( {
		browsers: [
		'last 2 versions',
		'android 4',
		'opera 12'
		]
	} ) )
	.pipe( sourcemaps.write() )
	.pipe( gulp.dest( 'dist/styles' ) )
	.pipe( browserSync.stream() )
	.pipe( notify( 'RTL styles compiled' ) );
});

gulp.task( 'rtl-styles-min', function() {

	let scss_files = [
	'assets/styles/rtl.scss'
	];

	gulp.src( scss_files )
	.pipe( sass( {errLogToConsole: true} ) )
	.pipe( autoprefixer( {
		browsers: [
		'last 2 versions',
		'android 4',
		'opera 12'
		]
	} ) )
	.pipe( rename( {
		suffix: '.min'
	} ) )
	.pipe( nano( {
		discardComments: {
			removeAll: true
		}
	} ) )
	.pipe( gulp.dest('dist/styles') )
	.pipe( browserSync.stream() )
	.pipe( notify( 'RTL styles compiled and minified' ) );
});


gulp.task( 'custom-scripts', function() {

	return gulp.src( 'assets/scripts/**/*.js' )

	.pipe( jshint() )
	.pipe( jshint.reporter( 'jshint-stylish' ) )

	.pipe( eslint( {
		fix: true
	} ) )
	.pipe( eslint.format() )
	.pipe(babel({
		presets: ['es2015']
	}))
	.pipe( notify( 'Javascripts linted' ) );			// Output to notification
});


// List all your JS files HERE
let js_files = [
'bower_components/jquery/dist/jquery.js',
'bower_components/jquery.cookie/jquery.cookie.js',
'bower_components/jquery-placeholder/jquery-placeholder.js',
'bower_components/foundation-sites/dist/js/foundation.js',
'assets/scripts/**/*.js'
];

gulp.task( 'scripts', function() {

	return gulp.src( js_files )

	.pipe( sourcemaps.init() )
	.pipe( concat( 'main.js' ) )
	.pipe( sourcemaps.write() )
	.pipe( gulp.dest( 'dist/scripts' ) )
	.pipe( browserSync.stream() )
	.pipe( notify( 'Javascripts compiled' ) );			// Output to notification
});

gulp.task( 'scripts-min', function() {
	return gulp.src( js_files )
	.pipe( concat( 'main.min.js' ) )
	.pipe(babel({
		presets: ['es2015']
	}))
	.pipe( uglify() ).on( "error", notify.onError( function ( error ) {
		let filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "JavaScript error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe( gulp.dest( 'dist/scripts' ) )
	.pipe( notify( 'Javascripts compiled and minified' ) );			// Output to notification
});

let php_files = [
'{lib,template-parts}/**/*.php',
'*.php'
];

gulp.task( 'php', function() {
	return gulp.src( php_files )
	.pipe( browserSync.stream() );
});

let img_files = [
'assets/images/**/*'
];

gulp.task( 'images', function() {
	return gulp.src( img_files )
	.pipe( gulp.dest( 'dist/images' ) )
	.pipe( browserSync.stream() );
});

gulp.task( 'images-min', function() {

	return gulp.src( img_files )
	.pipe( imagemin( {
		optimizationLevel: 3,
		progressive: true,
		interlaced: true
	} ) )
	.pipe( gulp.dest( 'dist/images' ) );
});

let font_files = [
'bower_components/font-awesome/fonts/*',
'assets/fonts/**/*'
];

gulp.task( 'fonts', function() {

	return gulp.src( font_files )
	.pipe( gulp.dest( 'dist/fonts' ) )
	.pipe( browserSync.stream() );
});

gulp.task( 'fonts-min', function() {

	return gulp.src( font_files )
	.pipe( gulp.dest( 'dist/fonts' ) );
});

gulp.task( 'clean', function( cb ) {
	return del( ['dist/styles', 'dist/scripts', 'dist/images', 'dist/fonts'], cb )
});

gulp.task( 'default', ['clean'], function() {
	gulp.start( 'rtl-styles', 'styles', 'custom-scripts', 'scripts', 'php', 'images', 'fonts' );
});

gulp.task( 'production', ['clean'], function() {
	gulp.start( 'styles-min', 'rtl-styles-min', 'scripts-min', 'images-min', 'fonts-min' );
});

gulp.task('watch', function() {

	// Run the styles task first time gulp watch is run
	gulp.start( 'styles' );

	browserSync.init({
		files: ['{lib,template-parts}/**/*.php', '*.php'],
		proxy: 'http://localhost/DIRECTIRY/',
		snippetOptions: {
			whitelist: ['/wp-admin/admin-ajax.php'],
			blacklist: ['/wp-admin/**']
		}
	});
	gulp.watch( ['assets/styles/**/*'], ['rtl-styles' , 'styles'] );
	gulp.watch( ['assets/scripts/**/*'], ['scripts'] );
	gulp.watch( ['assets/scripts/**/*'], ['custom-scripts'] );
	gulp.watch( ['assets/fonts/**/*'], ['fonts'] );
	gulp.watch( ['assets/images/**/*'], ['images'] );
	gulp.watch( ['{lib,template-parts}/**/*.php', '*.php'], ['php'] );
});
