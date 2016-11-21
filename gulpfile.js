var gulp = require('gulp');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var cleanCSS = require('gulp-clean-css');

gulp.task('less', function () {
    return gulp.src('./resources/assets/less/style.less')
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('js-vendors', function(){
    return gulp.src(['./resources/assets/vendor/**/*'])
        .pipe(gulp.dest('./public/js'));
});

gulp.task('default', ['less','js-vendors']);
