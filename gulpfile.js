'use strict';

var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var less = require('gulp-less');
var minify = require('gulp-minify');
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');
var phpcs = require('gulp-phpcs');
var shell = require('gulp-shell');

gulp.task('less-core', function () {
    return gulp.src(['./resources/assets/core/less/*','./resources/assets/vendors/css/*'])
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(concat('core.css'))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('javascript', function () {
    return gulp.src(['./resources/assets/core/js/*', './resources/assets/vendors/js/*'])
        .pipe(uglify({compress:true}))
        .pipe(concat('core.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('phpcs', function () {
    return gulp.src(['**/*.php', '!vendor/**/*.*', '!storage/**/*.*', '!node_modules/'])
        .pipe(phpcs({
            bin: 'vendor/bin/phpcs',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        .pipe(phpcs.reporter('log'));
});

gulp.task('phpcbf', shell.task(['vendor/bin/phpcbf --standard=PSR2 --ignore=vendor/,node_modules/,storage/ .']));

gulp.task('develop', ['less-core','javascript']);
gulp.task('develop-phpcs', ['less-core','javascript','phpcs','phpcbf']);

gulp.task('watch', function () {
    gulp.watch(['./resources/assets/**/*'], ['develop']);
});
