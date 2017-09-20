const gulp = require('gulp');
const stylus = require('gulp-stylus');
const pug = require('gulp-pug');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');
const bootstrap = require('bootstrap-styl');

const srcFiles = {
  html: [
    './_src/pug/*.pug'
  ],
  htmlWatch: [
    './_src/pug/**/*.pug'
  ],
  jsMain: [
    'node_modules/vue/dist/vue.js',
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    './_src/js/main.js',
  ],
  js: [
    './_src/js/packages/**/*.js'
  ],
  css: [
    './_src/stylus/main.styl'
  ],
  cssWatch: [
    './_src/stylus/**/*.styl'
  ]
};

gulp.task('default', [
  'build',
  'watch'
]);

gulp.task('build', () => {
  return gulp.start(
    'html',
    'css',
    'js:main',
    'js',
  );
});

gulp.task('js:main', () => {
  return gulp.src(srcFiles.jsMain)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/js'));
});

gulp.task('js', () => {
  return gulp.src(srcFiles.js)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(babel({ compact: false }))
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/js'));
});

gulp.task('html', () => {
  return gulp.src(srcFiles.html)
    .pipe(plumber())
    .pipe(pug())
    .pipe(gulp.dest('./_views'));
});

gulp.task('css', () => {
  return gulp.src(srcFiles.css)
    .pipe(stylus({
      use: [bootstrap()],
      compress: true
    }))
    .pipe(gulp.dest('./assets/css'));
});

gulp.task('watch', ['build'], () => {
  gulp.watch(srcFiles.htmlWatch, ['html']);
  gulp.watch(srcFiles.cssWatch, ['css']);
  gulp.watch(srcFiles.jsMain, ['js:app']);
  gulp.watch(srcFiles.js, ['js']);
});