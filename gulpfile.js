const gulp = require("gulp"),
  autoprefixer = require("autoprefixer"),
  browserSync = require("browser-sync").create(),
  cssnano = require("cssnano"),
  hashsrc = require("gulp-hash-src"),
  postcss = require("gulp-postcss"),
  sass = require("gulp-sass"),
  sourcemaps = require("gulp-sourcemaps"),
  cache = require("gulp-cached");


const paths = {
  images: {
    src: "src/images/*.{gif,jpg,jpeg,png}",
    dest: "dist/images/"
  },
  scripts: {
    src: "src/scripts/*.js",
    dest: "dist/scripts/"
  },
  styles: {
    src: "src/styles/*.{css,scss}",
    dest: "dist/styles/"
  },
  templates: {
    src: ["src/**/*.{htm,html,php}", "!src/vendor/**/*.*"],
    dest: "dist/"
  },
  vendor: {
    src: "src/vendor/**/*.*",
    dest: "dist/vendor/"
  }
};



function images() {
  return gulp
  .src(paths.images.src)
  .pipe(gulp.dest(paths.images.dest))
  .pipe(browserSync.stream());
}



function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(hashsrc({build_dir: paths.scripts.dest, src_path: paths.scripts.src}))
    .pipe(gulp.dest(paths.scripts.dest))
    .pipe(browserSync.stream());
}



function styles() {
  return gulp
  .src(paths.styles.src)
  .pipe(sourcemaps.init())
  .pipe(sass())
  .on("error", sass.logError)
  .pipe(postcss([autoprefixer(), cssnano()]))
  .pipe(sourcemaps.write())
  .pipe(hashsrc({build_dir: paths.styles.dest, src_path: paths.styles.src}))
  .pipe(gulp.dest(paths.styles.dest))
  .pipe(browserSync.stream());
}



function templates() {
  return gulp
  .src(paths.templates.src)
  .pipe(cache())
  .pipe(gulp.dest(paths.templates.dest))
  .pipe(browserSync.stream());
}



function vendor() {
  return gulp
  .src(paths.vendor.src)
  .pipe(gulp.dest(paths.vendor.dest))
  .pipe(browserSync.stream());
}



function reload(done) {
  browserSync.reload();
  done();
}

function connect(done) {
  browserSync.init(null, {
    browser: ['chrome'],
    proxy: '127.0.0.1:8888',
    port: 8080,
    open: 'external',
    reloadOnRestart: true,
    notify: true
  });
  done();
}

function watcher() {
  gulp.watch(paths.styles.src, styles);
  gulp.watch(paths.templates.src, templates);
  gulp.watch(paths.scripts.src, scripts);
}


// to build again: const build = gulp.series(styles, templates, scripts, vendor); 
const build = gulp.series(styles, templates, scripts, vendor);
const watch = gulp.parallel(watcher, connect);

exports.images = images;
exports.scripts = scripts;
exports.styles = styles;
exports.templates = templates;
exports.vendor = vendor;

exports.build = build;
exports.watcher = watcher;

exports.default = gulp.parallel(build, watch);

