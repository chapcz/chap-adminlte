module.exports = (grunt) ->
  grunt.initConfig

    clean:
      dist: [
        'src/AdminLTE/assets/*'
      ]

    copy:
      fonts:
        files: [
          expand: true
          cwd: 'bower_components/font-awesome/fonts'
          src: ['**']
          dest: 'assets/fonts'
        ]
      styles:
        files: [
          expand: true
          flatten: true
          cwd: 'bower_components'
          src: [
            'bootstrap/dist/css/bootstrap.min.css'
            'admin-lte/dist/css/AdminLTE.min.css'
            'admin-lte/dist/css/skins/_all-skins.min.css'
            'font-awesome/css/font-awesome.min.css'
          ]
          dest: 'src/AdminLTE/assets/styles'
        ]
      scripts:
        files: [
          expand: true
          flatten: true
          cwd: 'bower_components'
          src: [
            'jquery/dist/jquery.min.js'
            'bootstrap/dist/js/bootstrap.min.js'
            'nette.ajax.js/nette.ajax.js'
            'nette-forms/src/assets/netteForms.js'
            'select2/dist/js/select2.full.min.js'
            'admin-lte/dist/js/app.min.js'
          ]
          dest: 'src/AdminLTE/assets/scripts'
        ]

    concat:
      admin:
        dest: 'src/AdminLTE/assets/full-admin.css'
        src: [
          'src/AdminLTE/assets/styles/bootstrap.min.css'
          'src/AdminLTE/assets/styles/AdminLTE.min.css'
          'src/AdminLTE/assets/styles/_all-skins.min.css'
        ]
      adminjs:
        dest: 'src/AdminLTE/assets/full-admin.js'
        src: [
          'src/AdminLTE/assets/scripts/jquery.min.js'
          'src/AdminLTE/assets/scripts/bootstrap.min.js'
          'src/AdminLTE/assets/scripts/nette.ajax.js'
          'src/AdminLTE/assets/scripts/netteForms.js'
          'src/AdminLTE/assets/scripts/select2.full.min.js'
          'src/AdminLTE/assets/scripts/app.min.js'
        ]

  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-clean'
  grunt.loadNpmTasks 'grunt-contrib-copy'

  grunt.registerTask 'default', [
    'clean'
    'copy'
    'concat'
  ]
