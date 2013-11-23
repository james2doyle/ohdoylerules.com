module.exports = function(grunt) {
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: '\n'
      },
      scripts: {
        src: ['src/scripts/*.js'],
        dest: 'js/main.js'
      },
      styles: {
        src: ['css/*.css', '!css/main.css'],
        dest: 'css/main.css'
      }
    },
    sass: {
      dist: {
        files: {
          'css/style.ready.css': 'src/styles/z_site.scss'
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 4 versions']
      },
      your_target: {
        src: 'css/main.css',
        dest: 'css/main.css'
      }
    },
    watch: {
      options: {
        livereload: true
      },
      templates: {
        files: ['**/*.html', 'partial/**/*.html'],
        tasks: []
      },
      styles: {
        files: ['src/styles/*.scss'],
        tasks: ['sass', 'concat:styles']
      },
      scripts: {
        files: ['src/scripts/*.js'],
        tasks: ['concat:scripts']
      }
    }
  });

grunt.loadNpmTasks('grunt-sass');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-autoprefixer');

grunt.registerTask('default', ['sass', 'concat', 'autoprefixer']);
};
