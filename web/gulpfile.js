var gulp = require('gulp');
var minifycss = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');
var browserify = require('gulp-browserify');
var rename = require('gulp-rename');

var jsDir = 'app/assets/js/lib';
var targetJsDir = '/public/js';
var cssDir = 'app/assets/css';
var targetCssDir = 'public/css/min';

gulp.task('css', function(){
        return gulp.src(cssDir + '/*.css')
            .pipe(autoprefixer('last 1 version'))
            .pipe(minifycss())
            .pipe(gulp.dest(targetCssDir))
            .pipe(notify({ message : targetCssDir + "/main.css compiled" }));
});

gulp.task('js', function(){
        gulp.src(jsDir + '/*.js')
        .pipe(browserify( { debug : true } ))
        .pipe(rename(targetJsDir + '/bundle.js'))
        .pipe(gulp.dest('./'))
        .pipe(notify({ message : targetJsDir + "/bundle.js compiled" }));
});

gulp.task('watch', function(){
    gulp.watch(cssDir + '/*.css', ['css']);
    gulp.watch(jsDir + '/*.js', ['js']);
});

gulp.task('default', ['watch']);
