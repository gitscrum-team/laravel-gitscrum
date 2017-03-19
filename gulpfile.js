'use strict';

var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var less = require('gulp-less');
var minify = require('gulp-minify');
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');
var shell = require('gulp-shell');

gulp.task('less-core', function () {
    return gulp.src(['./resources/assets/core/less/*'])
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(concat('core.css'))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('less-colors', function () {
    return gulp.src(['./resources/assets/core/less/colors/*'])
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(concat('colors.css'))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('javascript', function () {
    return gulp.src(['./resources/assets/core/js/*'])
        .pipe(uglify({compress:true}))
        .pipe(concat('core.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('develop', ['less-core', 'less-colors', 'javascript']);

gulp.task('watch', function () {
    gulp.watch(['./resources/assets/**/*'], ['develop']);
});
