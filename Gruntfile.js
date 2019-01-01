module.exports = function (grunt) {
    var pkg = grunt.file.readJSON('package.json');
    var bannerTemplate = '/**\n' +
        ' * <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
        ' * <%= pkg.homepage %>\n' +
        ' *\n' +
        ' * Copyright (c) <%= grunt.template.today("yyyy") %>;\n' +
        ' * Licensed GPLv2+\n' +
        ' */\n';

    var compactBannerTemplate = '/**\n' +
        ' * <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %> | <%= pkg.homepage %> | Copyright (c) <%= grunt.template.today("yyyy") %>; | Licensed GPLv2+\n' +
        ' */\n';

    // Project configuration
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),
        // jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                reporter: require('jshint-stylish')
            },
            main: [
                'assets/js/src/*.js',
            ]
        },

        uglify: {
            dev:{
                options: {
                    banner: bannerTemplate,
                    preserveComments: 'some',
                    options: {
                        beautify: true,
                        sourceMap: true,
                    }
                },
                files: [{
                    expand: true,
                    cwd: 'assets/public/js/src/',
                    src: ['*.js'],
                    dest: 'assets/public/js/',
                    ext: '.js'
                }, {
                    expand: true,
                    cwd: 'assets/admin/js/src/',
                    src: ['*.js'],
                    dest: 'assets/admin/js/',
                    ext: '.js'
                }]
            },
            dist: {
                options: {
                    banner: compactBannerTemplate,
                    preserveComments: 'some',
                    report: 'min',
                    compress: {
                        drop_console: true
                    }
                },
                files: [
                    {
                        expand: true,
                        cwd: 'assets/public/js/src/',
                        src: ['*.js'],
                        dest: 'assets/public/js/',
                        ext: '.min.js'
                    }, {
                        expand: true,
                        cwd: 'assets/admin/js/src/',
                        src: ['*.js'],
                        dest: 'assets/admin/js/',
                        ext: '.min.js'
                    }
                ]
            }
        },

        sass: { // Task
            dist: {
                options: {
                    // banner: bannerTemplate
                },
                files: [{
                    expand: true,
                    cwd: 'assets/public/css/sass/',
                    src: ['*.scss'],
                    dest: 'assets/public/css/',
                    ext: '.css'
                }, {
                    expand: true,
                    cwd: 'assets/admin/css/sass/',
                    src: ['*.scss'],
                    dest: 'assets/admin/css/',
                    ext: '.css'
                }]
            }
        },
        cssmin: {
            dist: {
                options: {
                    banner: compactBannerTemplate
                },
                files: [{
                    expand: true,
                    cwd: 'assets/public/css/',
                    src: ['*.css'],
                    dest: 'assets/public/css/',
                    ext: '.min.css'
                }, {
                    expand: true,
                    cwd: 'assets/admin/css/',
                    src: ['*.css'],
                    dest: 'assets/admin/css/',
                    ext: '.min.css'
                }]
            }
        },
        imagemin: {
            static: {
                options: {
                    progressive: true,
                    optimizationLevel: 3,
                    svgoPlugins: [{removeViewBox: false}],
                    use: [] // Example plugin usage
                },
            },
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'assets/public/images/src/',
                    src: ['**/*.{png,jpg,gif,svg}'],
                    dest: 'assets/public/images/'
                }, {
                    expand: true,
                    cwd: 'assets/admin/images/src/',
                    src: ['**/*.{png,jpg,gif,svg}'],
                    dest: 'assets/admin/images/'
                }]
            }
        },

        watch: {
            options: {
                livereload: true,
            },
            sass: {
                files: ['assets/public/css/sass/**/*.scss', 'assets/admin/css/sass/**/*.scss'],
                tasks: ['sass', 'cssmin'],
                options: {
                    debounceDelay: 500
                }
            },
            scripts: {
                files: ['!*.min.js', 'assets/public/js/src/*.js', 'assets/admin/js/src/*.js'],
                tasks: ['jshint', 'uglify'],
                options: {
                    debounceDelay: 500
                }
            }
        },

        /**
         * check WP Coding standards
         * https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
         */
        phpcs: {
            application: {
                dir: [
                    '**/*.php',
                    '!**/node_modules/**'
                ]
            },
            options: {
                bin: '~/phpcs/scripts/phpcs',
                standard: 'WordPress'
            }
        },
        // Generate POT files.
        makepot: {
            target: {
                options: {
                    exclude: ['build/.*', 'node_modules/*', 'assets/*'],
                    domainPath: '/i18n/languages/', // Where to save the POT file.
                    potFilename: 'wc-category-slider.pot', // Name of the POT file.
                    type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
                    potHeaders: {
                        'report-msgid-bugs-to': 'http://pluginever.com/support/',
                        'language-team': 'LANGUAGE <support@pluginever.com>'
                    }
                }
            }
        },
        // Clean up build directory
        clean: {
            main: ['build/']
        },
        copy: {
            main: {
                src: [
                    '**',
                    '!node_modules/**',
                    '!**/js/src/**',
                    '!**/css/src/**',
                    '!**/js/vendor/**',
                    '!**/css/vendor/**',
                    '!**/images/src/**',
                    '!**/sass/**',
                    '!build/**',
                    '!**/*.md',
                    '!**/*.map',
                    '!**/*.sh',
                    '!.idea/**',
                    '!bin/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!composer.json',
                    '!composer.lock',
                    '!debug.log',
                    '!.gitignore',
                    '!.gitmodules',
                    '!phpcs.xml.dist',
                    '!npm-debug.log',
                    '!plugin-deploy.sh',
                    '!export.sh',
                    '!config.codekit',
                    '!nbproject/*',
                    '!tests/**',
                    '!.csscomb.json',
                    '!.editorconfig',
                    '!.jshintrc',
                    '!.tmp'
                ],
                dest: 'build/'
            }
        },
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './build/woo-category-slider-pro-' + pkg.version + '.zip'
                },
                expand: true,
                cwd: 'build/',
                src: ['**/*'],
                dest: ''
            }
        },
        server: {
            options: {
                message: 'Server is ready!'
            }
        }


    });

// Load other tasks
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-notify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpcs');

    // Default task.
    grunt.registerTask('default', ['jshint', 'uglify', 'sass', 'cssmin', 'imagemin']);
    grunt.registerTask('release', ['default', 'makepot']);
    grunt.registerTask('build', ['clean', 'copy']);
    grunt.registerTask('zip', ['clean', 'copy', 'compress']);
    grunt.util.linefeed = '\n';
};
