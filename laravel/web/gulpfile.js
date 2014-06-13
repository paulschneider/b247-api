var gulp = require('gulp');
var minifycss = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');

var jsDir = 'app/assets/js';
var targetCssDir = 'public/js';
var cssDir = 'app/assets/css';
var targetCssDir = 'public/css/min';

gulp.task('css', function(){
        return gulp.src(cssDir + '/*.css')
            .pipe(autoprefixer('last 1 version'))
            .pipe(minifycss())
            .pipe(gulp.dest(targetCssDir))
            .pipe(notify({ message : "public/css/min/main.css compiled" }));
});

gulp.task('watch', function(){
    gulp.watch(cssDir + '/*.css', ['css']);
});

gulp.task('default', ['watch']);
