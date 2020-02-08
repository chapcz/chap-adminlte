module.exports = (grunt) ->
  grunt.initConfig

    clean:
      dist: [
        'src/AdminLTE/assets/full-*'
      ]

    concat:
      admin_css:
        dest: 'src/AdminLTE/assets/full-admin.css'
        src: [
          'node_modules/bootstrap/dist/css/bootstrap.css'
          'node_modules/admin-lte/dist/css/adminlte.min.css'
          'node_modules/admin-lte/dist/css/skins/_all-skins.min.css'
        ]
      admin_js:
        dest: 'src/AdminLTE/assets/full-admin.js'
        src: [
          'node_modules/jquery/dist/jquery.min.js'
          'node_modules/nette.ajax.js/nette.ajax.js'
          'node_modules/nette-forms/src/assets/netteForms.js'
          'node_modules/select2/dist/js/select2.full.min.js'
          'node_modules/popper.js/dist/umd/popper.js'
          'node_modules/admin-lte/dist/js/adminlte.min.js'
          'node_modules/bootstrap/dist/js/bootstrap.min.js'
          'src/AdminLTE/assets/custom/nette.init.js'
          'src/AdminLTE/assets/custom/modal.js'
          'src/AdminLTE/assets/custom/toggle-menu.js'
        ]

    uglify:
      admin_js:
        files:
          'src/AdminLTE/assets/full-admin.min.js': ['src/AdminLTE/assets/full-admin.js']

    cssmin:
      admin_css:
        files:
          'src/AdminLTE/assets/full-admin.min.css': ['src/AdminLTE/assets/full-admin.css']


  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-clean'
  grunt.loadNpmTasks 'grunt-contrib-uglify'
  grunt.loadNpmTasks 'grunt-contrib-cssmin'
  grunt.loadNpmTasks 'grunt-contrib-copy'

  grunt.registerTask 'default', [
    'clean'
    'concat'
    'cssmin'
    'uglify'
  ]
