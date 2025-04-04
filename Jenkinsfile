pipeline {
    agent any

    environment {
        ENV_FILE_CONTENT = credentials('env-nareswara-comp') // Ambil sebagai secret text
    }

    options {
        timeout(time: 1, unit: 'HOURS')
        disableConcurrentBuilds()
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    stages {
        stage('Preparation') {
            steps {
                echo "Building: ${env.JOB_NAME} #${env.BUILD_NUMBER}"
                
                // Tulis Secret Text ke dalam file .env
                script {
                    writeFile file: '.env', text: env.ENV_FILE_CONTENT
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    try {
                        sh 'docker compose up -d --build'
                    } catch (Exception e) {
                        currentBuild.result = 'FAILURE'
                        error "Build failed: ${e.getMessage()}"
                    }
                }
            }
        }
    }

    post {
        always {
            def statusMessage = "Build Status: ${currentBuild.currentResult}"
            echo statusMessage
        }
    }
}
