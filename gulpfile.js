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
	del = require('del');

gulp.task('styles', function() {

	// List al your SASS files HERE
	var scss_files = [
	'assets/styles/main.scss'
	];

	//return sass(scss_files, { style: 'expanded' })
	gulp.src(scss_files)
	.pipe(sourcemaps.init())
	.pipe(sass())
	.pipe(autoprefixer('last 3 version'))
	.pipe(gulp.dest('dist/styles'))
	.pipe(rename({suffix: '.min'}))
	.pipe(minifycss())
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/styles'))
	.pipe(livereload());
});

gulp.task('rtl-styles', function() {

	// List al your SASS files HERE
	var scss_files = [
	'assets/styles/rtl.scss'
	];

	//return sass(scss_files, { style: 'expanded' })
	gulp.src(scss_files)
	.pipe(sourcemaps.init())
	.pipe(sass())
	.pipe(autoprefixer('last 3 version'))
	.pipe(gulp.dest('dist/styles'))
	.pipe(rename({suffix: '.min'}))
	.pipe(minifycss())
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/styles'))
	.pipe(livereload());
});

gulp.task('scripts', function() {

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

	return gulp.src(js_files)
	.pipe(sourcemaps.init())
	.pipe(jshint('.jshintrc'))
	//.pipe(jshint.reporter('default'))
	.pipe(concat('main.js'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('dist/scripts'))
	.pipe(rename({suffix: '.min'}))
	.pipe(uglify())
	.pipe(gulp.dest('dist/scripts'))
	.pipe(livereload());
});

gulp.task('images', function() {
	
	var img_files = [
	'assets/images/**/*'
	];

	return gulp.src(img_files)
	.pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
	.pipe(gulp.dest('dist/images'))
	.pipe(livereload());
});

gulp.task('clean', function(cb) {
	del(['dist/css', 'dist/scripts', 'dist/images'], cb)
});

gulp.task('default', ['clean'], function() {
	gulp.start('styles', 'rtl-styles', 'scripts', 'images');
});

gulp.task('watch', function() {
  // Create LiveReload server
  livereload.listen();
  // Watch .scss files
  gulp.watch('assets/styles/**/*.scss', ['styles', 'rtl-styles']);
  // Watch .js files
  gulp.watch('assets/scripts/**/*.js', ['scripts']);
  // Watch image files
  gulp.watch('assets/images/**/*', ['images']);
  // Watch any files in dist/, reload on change
  gulp.watch(['dist/**', '**/*.php']).on('change', livereload.changed);
});
