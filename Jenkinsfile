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
        stage('Checkout') {
            steps {
                script {
                    sh 'git clone https://github.com/rifainareswara/nareswara-comp-V2.git'
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

    post {
        always {
            script {
                def statusMessage = "Build Status: ${currentBuild.currentResult}"
                echo statusMessage
            }
        }
    }
}
