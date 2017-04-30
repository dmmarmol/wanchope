var autoprefixer 	= require('gulp-autoprefixer');
var concat       	= require('gulp-concat');
var cleanCSS 	 	= require('gulp-clean-css');	// Min Css
var email 			= require('gulp-email');
var gulp			= require('gulp');
var gutil		 	= require('gulp-util');
// var iconfont 		= require('gulp-iconfont');
// var iconfontCss 	= require('gulp-iconfont-css');
var htmlreplace 	= require('gulp-html-replace');
var livereload	 	= require('gulp-livereload');
var merge 		 	= require('merge-stream'); // https://github.com/gulpjs/gulp/blob/master/docs/recipes/using-multiple-sources-in-one-task.md
var minhtml      	= require('gulp-htmlmin');		// Min Html
var notify 			= require("gulp-notify");
var nunjucksRender 	= require('gulp-nunjucks-render');
var preprocess 	 	= require('gulp-preprocess');
var rename 		 	= require("gulp-rename");
var runSequence  	= require('run-sequence');
var sass	 	 	= require('gulp-sass');
var sourcemaps 		= require('gulp-sourcemaps');
var zip 			= require('gulp-zip');


var node_path 	 	= 'node_modules';
var root 		 	= './';
var PORT 			= 35729;
var PROJECTNAME		= 'wanchope';

var today 	= new Date();
var dd 		= today.getDate();
var mm 		= today.getMonth()+1;
var yyyy 	= today.getFullYear();
var date 	= yyyy+'-'+mm+'-'+dd;

/**
 * Directorios de trabajo
 */
var DEV	= {
	FOLDER: 	'./',
	HTML: 		'./*.html',
	PHP: 		'./**/*.php',
	TEMPLATES:	{
		FOLDER: ['./templates', './pages'],
		HTML: 	['./templates/**/*.nunjucks', './pages/**/*.nunjucks'],
		PAGES: 	['./pages/**/*.nunjucks'],
	},
	ASSETS: 	'./src',
	CSS: 		'./src/css',
	VENDOR: 	'./src/vendor',
	FONTS: 		'./src/fonts',
	ICONS: 		'./src/icons/*.svg',
	EMAIL: 		['./templates/email.html'],
	ZIPFILE: 	date + '-' + PROJECTNAME.toLowerCase() + '.zip',
	SASS: {
		FOLDER: 	'./src/scss',
		FILES: 		'./src/scss/**/*.scss',
	}
}

var BOWER = {
	FOLDER: './bower_components',
	PACKAGES: {
		CSS:[
		],
		JS: [
		],
		SCSS: [
			'bootstrap-sass/assets/stylesheets/**/*.scss',
			// 'bodokecss/bodokecss/**/*.scss'
		]
	}
};

var AUTOPREFIXER_BROWSERS = [
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4.4',
	'bb >= 10'
];

var options = {
	user: 'api:key-9254400a6b6e416fe85e781762f5e003',
	url: 'https://api.mailgun.net/v3/sandboxfcaee27471dd4f31b548ea8ae257552f.mailgun.org/messages',
	form: {
		from: 'Diego Martín Mármol <diegomartinmarmol@gmail.com>',
		to: 'Francisco Siutti <diegomartinmarmol@gmail.com>',
		subject: date + ' - ' + PROJECTNAME.toLowerCase(),
        // text: 'text version',
		attachment: '@zip/' + DEV.ZIPFILE
    }
};


/**
 * ========================================
 * GULP TASK
 * ========================================
 */


// TASK
gulp.task('default', function(){
	runSequence( 'bower', ['style-css'], 'watch' );
});

// WATCH SCSS TASK
gulp.task('watch', function () {
	livereload.listen();
    // PHP Watch
    gulp.watch( DEV.PHP, function(event){
    	runSequence('reload');
    });
    // SCSS Watch
    gulp.watch( DEV.SASS.FILES, function(event){
    	runSequence('style-css', 'reload');
    });
    // Vendor Watch
    // gulp.watch( [path.templates], ['reload'] );

    // gulp.watch( ['./assets/scss/font-awesome/**/*.scss'], ['font-awesome'] );
});


/** RELOAD */
gulp.task('reload', function() {
	notify('Reloading...');
	return livereload.reload();
});




/**
 * SCSS/CSS Propio
 * ----------------------------------------
 */

/**
 * Compila el scss y guarda en DEV.CSS
 */
gulp.task('compile-sass', function () {
	return gulp.src( DEV.SASS.FILES )
		.pipe(sourcemaps.init())
		.pipe(sass({
			includePaths: DEV.SASS.FILES,
			sourceComments: false
		}).on('error', notify.onError(function (error) {
			return "Problem file : " + error.message;
		})))
		.pipe(autoprefixer({ browsers: AUTOPREFIXER_BROWSERS, cascade: false }))
		.pipe(preprocess({context: { NODE_PATH: node_path }}))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest( DEV.CSS + '/' ))
		.pipe(livereload());
});
/**
 * Minimiza y compila el CSS en un único "style.css"
 */
gulp.task('style-css', ['compile-sass'], function(){
	return gulp.src(  DEV.CSS + '/**/*.css' )
		.pipe( concat( 'style.css' ) )
		.pipe(cleanCSS({
			compatibility: 'ie8',
			keepSpecialComments: true,
		}))
		.pipe( gulp.dest( DEV.FOLDER ) );
});


// gulp.task('copy-dev-css-to-dist', function() {
// 	gulp.src( DEV.CSS + '/**/*.css' )
//    		.pipe( gulp.dest( PUBLIC.CSS + '/' ) );
// 	gutil.log('----- Copied all '+DEV.CSS+' to –-> '+PUBLIC.CSS);
// });

// gulp.task('generate-public-css', function(callback) {
// 	runSequence( 'compile-sass', 'copy-dev-css-to-dist', callback);
// });


/**
 * BOWER
 * ----------------------------------------
 */

function getPackageName( package ) {
	var a = package.split('/');
	var l = a.length;
	return a[l - 1];
}
function getPackageFolder( package ) {
	var a = package.split('/');
	var l = a.length;
	return a[0];
}
// Testing Prupouses
gulp.task('log', function(){
	BOWER.PACKAGES.CSS.forEach(function(package, i, array){
		gutil.log();
	});
});

/**
 * Copia el css de bower a DEV.CSS (para luego ser minimizado y llevado a PUBLIC.VENDOR)
 */
gulp.task('copy-vendor-css-to-dev', function() {
	BOWER.PACKAGES.CSS.forEach(function(package, i, array){
		gulp.src( BOWER.FOLDER + '/' + package )
			.pipe( gulp.dest( DEV.VENDOR + '/css/' ) );
		gutil.log('--- Copied '+ getPackageName( package ) +' to –-> '+DEV.VENDOR);
	});
});
/**
 * Copia el JS de bower a DEV.CSS (para luego ser minimizado y llevado a PUBLIC.VENDOR)
 */
gulp.task('copy-vendor-js-to-dev', function() {
	BOWER.PACKAGES.JS.forEach(function(package, i, array){
		gulp.src( BOWER.FOLDER + '/' + package )
			.pipe( gulp.dest( DEV.VENDOR + '/js/' ) );
		gutil.log('--- Copied '+ getPackageName( package ) +' to –-> '+DEV.VENDOR);
	});
});
/**
 * Copia el SCSS de bower a DEV.SASS.FOLDER
 */
gulp.task('copy-vendor-scss-to-sass', function() {
	BOWER.PACKAGES.SCSS.forEach(function(package, i, array){
		gulp.src( BOWER.FOLDER + '/' + package )
			.pipe( gulp.dest( DEV.SASS.FOLDER + '/' + getPackageFolder(package) +'/' ) );
		gutil.log('--- Copied '+ getPackageName( package ) +' to –-> '+DEV.VENDOR);
	});
});

gulp.task('bower', function(callback) {
	runSequence( 'copy-vendor-css-to-dev', 'copy-vendor-js-to-dev', 'copy-vendor-scss-to-sass', callback);
});



/**
 * HTML COMPILING
 * ----------------------------------------
 */
/**
 * Compila los templates de nunjucks y los lleva a PUBLIC.DIST
 */
// gulp.task('compile-dev-html', function() {
// 	return gulp.src( DEV.TEMPLATES.PAGES )
// 		.pipe(nunjucksRender({
// 			path: DEV.TEMPLATES.FOLDER // array
// 		}))
// 		.pipe( rename({ extname: ".html" }) )
// 		.pipe( gulp.dest( DEV.FOLDER + '/' ) );
// });
// gulp.task('set-livereload-port', function(){
// 	// <!-- build:livereload --><!-- endbuild -->
// 	return gulp.src( DEV.HTML, { base: DEV.FOLDER } )
// 		.pipe(htmlreplace({
// 			livereload: {
// 				src: PORT,
// 				tpl: '<script src="//localhost:%s/livereload.js?snipver=1" type="text/javascript"></script>'
// 			}
// 		}))
// 		.pipe( gulp.dest( './' ) );
// });




/**
 * MY MATERIAL ICONS
 * ----------------------------------------
 */
// var fontName = PROJECTNAME.toLowerCase();
// var runTimestamp = Math.round(Date.now()/1000);
// gulp.task('my-material-icons', function(){
//   return gulp.src( DEV.ICONS )
//     .pipe(iconfontCss({
//       	fontName: fontName,
//       	path: DEV.SASS.FOLDER + '/'+ fontName +'/_template.scss', // 'scss/app/fonts/_template.scss',
//       	targetPath: '../../.'+ DEV.SASS.FOLDER +'/'+fontName+'/_'+fontName+'.scss', // '../../../scss/app/fonts/'+fontName+'.scss',
//       	fontPath: DEV.FONTS + '/' // '../../../src/fonts/'+fontName+'/'
//     }))
//     .pipe(iconfont({
//       	fontName: fontName, // required
//       	prependUnicode: true, // recommended option
//       	formats: ['ttf', 'eot', 'woff', 'svg'], // default, 'woff2' and 'svg' are available
//       	timestamp: runTimestamp, // recommended to get consistent builds when watching files
// 	    normalize: true, // Normaliza el tamaño del canvas de todos los iconos svg
// 	    fontHeight: 1001
//     }))
//     .pipe(gulp.dest( DEV.FONTS ));
// });

