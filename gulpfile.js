var gulp = require('gulp');
var concat = require('gulp-concat');                            //- 多个文件合并为一个；
var minifyCss = require('gulp-minify-css');                     //- 压缩CSS为一行；
var rev = require('gulp-rev');                                  //- 对文件名加MD5后缀
var revCollector = require('gulp-rev-collector');               //- 路径替换

//用gulp建立一个all_to_one任务
// gulp.task('all_to_one', function() {
//   return gulp.src('static/pear/**/*.js')
//     .pipe(concat('all.js'))
//     .pipe(gulp.dest('./static/pear'));
// });
// gulp.task('default', ['all_to_one']);

exports.default =  async function() {
  await gulp.src('static/pear/css/module/*.css')    //- 需要处理的css文件，放到一个字符串数组里
  .pipe(concat('all.min.css'))                            //- 合并后的文件名
  // .pipe(minifyCss())                                      //- 压缩处理成一行
  .pipe(gulp.dest('static/pear/css/module'))  
}


