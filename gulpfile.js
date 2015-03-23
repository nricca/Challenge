/**
 * Created by riccanicola on 08.03.15.
 */
var gulp = require('gulp'),
    compass = require('gulp-compass'),
    livereload = require('gulp-livereload');

livereload({ start: true });

gulp.task('compass', function () {
    gulp.src('assets/sass/*.scss')
        .pipe(compass({
            css: 'assets/css',
            sass: 'assets/sass'
        }))
        .pipe(gulp.dest('assets/css'))
        .pipe(livereload());
});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch('assets/sass/*.scss', ['compass']);
});