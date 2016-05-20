/**
 * gulpfile.js
 * http://localhost:8000/bodokecss
 * livreload script: //localhost:35729/livereload.js?snipver=1
 */

// REQUIRES
var gulp 			    = require('gulp');
var sass 			    = require('gulp-sass');
var livereload		= require('gulp-livereload');
var autoprefixer 	= require('gulp-autoprefixer');
var preprocess 		= require('gulp-preprocess');
var iconfont 		  = require('gulp-iconfont');
var iconfontCss 	= require('gulp-iconfont-css');
var runSequence   = require('run-sequence');
var del           = require('del');
var fs            = require('fs');
var gutil 			  = require('gulp-util'); // https://www.npmjs.com/package/gulp-util/
var debug 			  = require('gulp-debug'); // https://www.npmjs.com/package/gulp-debug/



var NODE_PATH 		  = '../node_modules';
var ROOT 			      = './';
var SRC             = './src/';
var PUBLICFOLDER    = ROOT;
var LIVERELOAD_PORT = 35732;

// ROUTES
var paths = {
  sass: [ ROOT+'scss/**/*.scss' ],
  css: [ SRC+'css/**/*.css' ],
  compiledcss: SRC+'css/',
  scripts: [
    SRC+'js/**/*.js',
    '!'+SRC+'js/**/config.js'   /* exclude config.js: handled separately */
  ],
  html: [ROOT+'**/*.html'],
  php: [ROOT+'**/*.php']
}

var AUTOPREFIXER_BROWSERS = [
  'ie >= 8',
  'ie_mob >= 8',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 7',
  'android >= 4.4',
  'bb >= 10'
];


// gutil.log( paths.php );

// TASK
gulp.task('default', ['scss', 'watch'], function() {});
gulp.task('build', function(callback) {
  runSequence('iconfont', ['scss'], callback);
});

// WATCH SCSS TASK
gulp.task('watch', function () {
	livereload.listen( LIVERELOAD_PORT );
    gulp.watch( [paths.html, paths.php], ['reload']).on('change', function(file){
    	gulp.src(file.path)
    		.pipe(debug({title: 'Updated:'}));
    });	
    gulp.watch( [paths.sass], ['scss']).on('change', function(file){
    	gulp.src(file.path)
    		.pipe(debug({title: 'Updated:'}));
    });	
});

// Comple app.scss
gulp.task('scss', function () {
	gulp.src( paths.sass )
		.pipe(sass().on('error', sass.logError))
		.pipe(autoprefixer({
            browsers: AUTOPREFIXER_BROWSERS,
            cascade: false
        }))
        .pipe(preprocess({context: { NODE_PATH: NODE_PATH }}))
		.pipe(gulp.dest( paths.compiledcss ))
		.pipe(livereload());
});

/**
 * Icon fonts
 * @see https://github.com/nfroidure/gulp-iconfont
 * @see https://github.com/backflip/gulp-iconfont-css
 */
var fontName = 'alarunner';
var runTimestamp = Math.round(Date.now()/1000);
gulp.task('iconfont', function(){
  return gulp.src(['./src/icons/*.svg'])  
    .pipe(iconfontCss({
      fontName: fontName,
      path: 'scss/fonts/_template.scss',
      targetPath: '../../scss/fonts/_'+fontName+'.scss',
      fontPath: '../../../src/fonts/'+fontName+'/'
    }))
    .pipe(iconfont({
      fontName: fontName, // required
      prependUnicode: true, // recommended option (ex: appendUnicode)
      formats: ['ttf', 'eot', 'woff', 'svg'], // default, 'woff2' and 'svg' are available
      timestamp: runTimestamp, // recommended to get consistent builds when watching files
      normalize: true, // Normaliza el tamaño del canvas de todos los iconos svg
      fontHeight: 1001
    })).on('glyphs', function(glyphs, options) {
        // CSS templating, e.g. 
        console.log(glyphs);
      })
    .pipe(gulp.dest(PUBLICFOLDER+'/src/fonts'));
});


gulp.task('reload', function() {
	livereload.reload();
});