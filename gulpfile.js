var gulp = require('gulp'),

   rimraf = require('rimraf'),
   jshint = require('gulp-jshint'),
   uglify = require('gulp-uglify'),
   compass = require('gulp-compass'),
   minifycss = require('gulp-minify-css'),
   imagemin = require('gulp-imagemin'),
   cache = require('gulp-cache'),
   plumber = require('gulp-plumber'),
   notify = require('gulp-notify'),

   config = {
       app: './src/Resources',
       dist: 'assets',
       port: 9000,
       scripts: function () {
           return this.app + '/js';
       },
       styles: function () {
           return this.app + '/sass';
       },
       images: function () {
           return this.app + '/img';
       }
   };

config.scripts.apply(config);
config.styles.apply(config);
config.images.apply(config);

gulp.task('clean', function(cb) {
   rimraf(config.dist, cb);
});

gulp.task('lint', function() {
   var path = config.scripts();

   return gulp.src(path + '/*.js')
       .pipe(plumber())
       .pipe(jshint())
       .pipe(jshint.reporter('default'))
       .pipe(gulp.dest(config.dist + '/js'));
});

gulp.task('js-vendors', function(){
   gulp.src(config.app + '/js/vendor/**/*')
   .pipe(gulp.dest(config.dist + '/js/vendor/'));
});


gulp.task('uglify', function () {
   var path = config.scripts();

   return gulp.src(path + '/**/*')
       .pipe(plumber())
       .pipe(uglify())
       .pipe(gulp.dest(config.dist + '/js'));
});

gulp.task('compass', function() {
    var path = config.styles();
    return gulp.src(path + '/**/*.scss')
        .pipe(plumber())
        .pipe(compass({
            config_file: './config.rb',
            css: config.dist + '/css',
            sass: config.app + '/sass'
        }))
        .pipe(gulp.dest(config.dist + '/css'));
});

gulp.task('minify-css', function () {
   return gulp.src(config.app + '/css')
       .pipe(plumber())
       .pipe(minifycss())
       .pipe(gulp.dest(config.dist + '/css'));
});

gulp.task('images', function(){
   var path = config.images();
   return gulp.src(path + '/**/*')
       .pipe(cache(imagemin({
           optimizationLevel: 5,
           progressive: true,
           interlaced: true
       })))
       .pipe(gulp.dest(path));
});

gulp.task('images-copy', function(){
   gulp.src(config.images() + '/**/*')
   .pipe(gulp.dest(config.dist + '/img'));
});


gulp.task('minify-end', function(){
    return gulp.src(config.app)
        .pipe(notify({ message: 'Build task complete' }));
})

gulp.task('watch', ['js-vendors'], function() {

   // Watch .scss files
   gulp.watch(config.styles() + '/**/*.scss', ['compass']);

   // Watch .js files
   gulp.watch(config.scripts() + '/*.js', ['lint']);

   // Watch vendors and move them
   gulp.watch(config.scripts() + '/vendor/**/*', ['js-vendors']);

   // Watch image files
   gulp.watch(config.images() + '/**/*', ['images', 'images-copy']);

});

// Default
gulp.task('default', function() {
   gulp.start('watch');
});

gulp.task('build', ['clean'], function(){
   gulp.start('images-copy', 'minify-css', 'uglify', 'minify-end');
});