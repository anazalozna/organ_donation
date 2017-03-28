const config = {
    'sass': './www/assets/sass/',
    'css': './www/static/css/',
    'img': './www/static/img/',
    'js': './www/assets/js/',
    'js_compiled': './www/static/js/',
};

const
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require("gulp-autoprefixer"),
    babel = require('gulp-babel');

gulp.task('styles', () => {
    gulp.src(config.sass + '**/*.{sass,scss}')
        .pipe(sass({outputStyle: "compact"}).on('error', sass.logError))
        .pipe(autoprefixer(["last 15 versions", "> 1%", "ie 8", "ie 7"]))
        .pipe(gulp.dest(config.css));
});

//make js compatible
gulp.task('js', () => {
    gulp.src(config.js  + '**/*.js')
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(gulp.dest(config.js_compiled));
});

//Watch task
gulp.task('default', ['styles', 'js'], () => {
    gulp.watch(config.sass + '**/*.{sass,scss}', ['styles']);
    gulp.watch(config.js  + '**/*.js', ['js']);
});