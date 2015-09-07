'use strict';

var gulp = require('gulp'),
sass = require('gulp-sass'),
autoprefixer = require('gulp-autoprefixer'),
minifycss = require('gulp-minify-css'),
jshint = require('gulp-jshint'),
uglify = require('gulp-uglify'),
imagemin = require('gulp-imagemin'),
rename = require('gulp-rename'),
concat = require('gulp-concat'),
cache = require('gulp-cache'),
livereload = require('gulp-livereload'),
sourcemaps = require('gulp-sourcemaps'),
del = require('del'),
notify = require('gulp-notify');

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
	.pipe(livereload())
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
	.pipe(minifycss())
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
	.pipe(sass()).on("error", notify.onError(function (error) {
		var filename = error.fileName.replace(/^.*[\\\/]/, '')
		return "SASS error:\n" + filename + "\nLine " +  error.lineNumber;
	}))
	.pipe(autoprefixer('last 3 version'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/styles'))
	.pipe(livereload())
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
	.pipe(minifycss())
	.pipe(gulp.dest('dist/styles'))
	.pipe(livereload())
	.pipe(notify('RTL styles compiled and minified'));
});

// List all your JS files HERE
var js_files = [
	'bower_components/jquery/dist/jquery.js',
	'bower_components/jquery.cookie/jquery.cookie.js',
	'bower_components/jquery-placeholder/jquery-placeholder.js',
	'bower_components/fastclick/lib/fastclick.js',
	'bower_components/foundation/js/foundation.js',
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
	.pipe(livereload())
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

var img_files = [
	'assets/images/**/*'
];

gulp.task('images', function() {

	return gulp.src(img_files)
	.pipe(gulp.dest('dist/images'))
	.pipe(livereload());
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
	.pipe(livereload());
});

gulp.task('fonts-min', function() {

	return gulp.src(font_files)
	.pipe(gulp.dest('dist/fonts'));
});

gulp.task('clean', function(cb) {
	del(['dist/styles', 'dist/scripts', 'dist/images', 'dist/fonts'], cb)
});

gulp.task('default', ['clean'], function() {
	gulp.start('rtl-styles', 'styles', 'scripts', 'images', 'fonts');
});

gulp.task('production', ['clean'], function() {
	gulp.start('styles-min', 'rtl-styles-min', 'scripts-min', 'images-min', 'fonts-min');
});

gulp.task('watch', function() {
	// Create LiveReload server
	livereload.listen();
	// Watch .scss files
	gulp.watch('assets/styles/**/*.scss', ['rtl-styles' , 'styles']);
	// Watch .js files
	gulp.watch('assets/scripts/**/*.js', ['scripts']);
	// Watch image files
	gulp.watch('assets/images/**/*', ['images']);
	// Watch fonts files
	gulp.watch('assets/fonts/**/*', ['fonts']);
	// Watch any files in dist/, reload on change
	gulp.watch(['dist/**', '**/*.php']).on('change', livereload.changed);
});
