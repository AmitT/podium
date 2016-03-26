'use strict';

var gulp = require('gulp'),
sass = require('gulp-sass'),
autoprefixer = require('gulp-autoprefixer'),
nano = require('gulp-cssnano'),
jshint = require('gulp-jshint'),
uglify = require('gulp-uglify'),
imagemin = require('gulp-imagemin'),
rename = require('gulp-rename'),
concat = require('gulp-concat'),
cache = require('gulp-cache'),
sourcemaps = require('gulp-sourcemaps'),
del = require('del'),
notify = require('gulp-notify'),
phpcs = require('gulp-phpcs'),
scsslint = require('gulp-scss-lint'),
browserSync = require('browser-sync').create();


require('es6-promise').polyfill();

gulp.task('styles', function() {

	// List al your SASS files HERE
	var scss_files = [
		'assets/styles/main.scss'
	];

	//return sass(scss_files, { style: 'expanded' })
	gulp.src(scss_files)
	.pipe(sourcemaps.init())
	.pipe(sass({errLogToConsole: true}))
	.pipe(autoprefixer('last 3 version'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/styles'))
	.pipe(browserSync.stream())
	.pipe(notify('SCSS files compiled'));			// Output to notification
});

gulp.task('styles-min', function() {
	var scss_files = [
		'assets/styles/main.scss'
	];

	gulp.src(scss_files)
	.pipe(sass({errLogToConsole: true}))
	.pipe(autoprefixer('last 3 version'))
	.pipe(rename({suffix: '.min'}))
	.pipe(nano({discardComments: {removeAll: true}}))
	.pipe(gulp.dest('dist/styles'))
	.pipe(notify('SCSS files compiled and minified'));			// Output to notification
});

gulp.task('rtl-styles', function() {

	// List al your SASS files HERE
	var scss_files = [
		'assets/styles/rtl.scss'
	];

	//return sass(scss_files, { style: 'expanded' })
	gulp.src(scss_files)
	.pipe(sourcemaps.init())
	.pipe(scsslint())
	.pipe(sass()).on("error", notify.onError(function (error) {
		var filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "SASS error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe(autoprefixer('last 3 version'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/styles'))
	.pipe(browserSync.stream())
	.pipe(notify('RTL styles compiled'));
});

gulp.task('rtl-styles-min', function() {

	var scss_files = [
		'assets/styles/rtl.scss'
	];

	gulp.src(scss_files)
	.pipe(sass({errLogToConsole: true}))
	.pipe(autoprefixer('last 3 version'))
	.pipe(rename({suffix: '.min'}))
	.pipe(nano({discardComments: {removeAll: true}}))
	.pipe(gulp.dest('dist/styles'))
	.pipe(browserSync.stream())
	.pipe(notify('RTL styles compiled and minified'));
});

// List all your JS files HERE
var js_files = [
	'bower_components/jquery/dist/jquery.js',
	'bower_components/jquery.cookie/jquery.cookie.js',
	'bower_components/jquery-placeholder/jquery-placeholder.js',
	'bower_components/foundation-sites/dist/foundation.js',
	'bower_components/angular/angular.js',
	'assets/scripts/**/*.js'
];

gulp.task('scripts', function() {

	return gulp.src(js_files)

	.pipe(jshint('.jshintrc')).on("error", notify.onError(function (error) {
		var filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "JavaScript error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe(sourcemaps.init())
	.pipe(concat('main.js'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/scripts'))
	.pipe(browserSync.stream())
	.pipe(notify('Javascripts compiled'));			// Output to notification
});

gulp.task('scripts-min', function() {
	return gulp.src(js_files)
	.pipe(concat('main.min.js'))
	.pipe(jshint('.jshintrc')).on("error", notify.onError(function (error) {
		var filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "JavaScript error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe(uglify()).on("error", notify.onError(function (error) {
		var filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "JavaScript error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe(gulp.dest('dist/scripts'))
	.pipe(notify('Javascripts compiled and minified'));			// Output to notification
});

var php_files = [
	'**/*.php'
]

gulp.task('php', function() {
	return gulp.src(php_files)
	//.pipe(phpcs({
	//	standard: 'WordPress',
	//	warningSeverity: 0
	//}))
	//.pipe(phpcs.reporter('log'))
	.pipe(browserSync.stream());
});

var img_files = [
	'assets/images/**/*'
];

gulp.task('images', function() {
	return gulp.src(img_files)
	.pipe(gulp.dest('dist/images'))
	.pipe(browserSync.stream());
});

gulp.task('images-min', function() {

	return gulp.src(img_files)
	.pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
	.pipe(gulp.dest('dist/images'));
});

var font_files = [
	'bower_components/font-awesome/fonts/*',
	'assets/fonts/**/*'
];

gulp.task('fonts', function() {

	return gulp.src(font_files)
	.pipe(gulp.dest('dist/fonts'))
	.pipe(browserSync.stream());
});

gulp.task('fonts-min', function() {

	return gulp.src(font_files)
	.pipe(gulp.dest('dist/fonts'));
});

gulp.task('clean', function(cb) {
	return del(['dist/styles', 'dist/scripts', 'dist/images', 'dist/fonts'], cb)
});

gulp.task('default', ['clean'], function() {
	gulp.start('rtl-styles', 'styles', 'scripts', 'php', 'images', 'fonts');
});

gulp.task('production', ['clean'], function() {
	gulp.start('styles-min', 'rtl-styles-min', 'scripts-min', 'images-min', 'fonts-min');
});

gulp.task('watch', function() {
	// run the styles task first time gulp watch is run
	gulp.start('styles');

	browserSync.init({
		files: ['{lib,directives}/**/*.php', '*.php'],
		proxy: 'http://localhost/DIRECTORY/',
		snippetOptions: {
			whitelist: ['/wp-admin/admin-ajax.php'],
			blacklist: ['/wp-admin/**']
		}
	});
	gulp.watch(['assets/styles/**/*'], ['rtl-styles' , 'styles']);
	gulp.watch(['assets/scripts/**/*'], ['scripts']);
	gulp.watch(['assets/fonts/**/*'], ['fonts']);
	gulp.watch(['assets/images/**/*'], ['images']);
});
