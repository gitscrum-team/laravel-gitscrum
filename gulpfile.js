'use strict';

const gulp = require('gulp');
const del = require('del');

const paths = {
    cleanBeforeBuild: [
        './public/assets/*', 
        '!./public/assets/.gitignore'
    ],
    moveDistToPublic: [
        './resources/frontend/dist/*', 
        '!./resources/frontend/dist/index.html'
    ],
    destination: './public/assets/'
};

gulp.task('clean', function(cb){
    del(paths.cleanBeforeBuild).then(() => {
        cb();
    });
});

gulp.task('move-angular', ['clean'], function(){
    gulp.src(paths.moveDistToPublic).pipe(gulp.dest(paths.destination));
});

gulp.task('build', ['clean', 'move-angular']);