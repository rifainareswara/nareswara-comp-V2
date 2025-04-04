pipeline {
    agent any

    environment {
        ENV_FILE_CONTENT = credentials('env-nareswara-comp') // Secret text
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
                    if (fileExists('nareswara-comp-V2')) {
                        echo "Repository already exists. Pulling latest changes..."
                        sh 'cd nareswara-comp-V2 && git reset --hard && git pull origin main'
                    } else {
                        echo "Cloning repository..."
                        sh 'git clone https://github.com/rifainareswara/nareswara-comp-V2.git'
                    }
                }
            }
        }

        stage('Load Configuration') {
            steps {
                configFileProvider([
                    configFile(fileId: 'Laravel_Env_Nareswara', variable: 'LARAVEL_ENV')
                ]) {
                    script {
                        echo "Copying .env file from Manage Files..."
                        sh 'cp $LARAVEL_ENV nareswara-comp-V2/.env'
                    }
                }
            }
        }

        stage('Build') {
            steps {
                dir('nareswara-comp-V2') {
                    script {
                        try {
                            // List of expected container names
                            def containers = ['nareswara-db', 'nareswara-comp']

                            containers.each { name ->
                                def exists = sh(script: "docker ps -a --format '{{.Names}}' | grep -w '${name}'", returnStatus: true) == 0
                                if (exists) {
                                    echo "Stopping and removing existing container: ${name}"
                                    sh "docker stop ${name} || true"
                                    sh "docker rm ${name} || true"
                                }
                            }

                            echo "Starting containers..."
                            sh 'docker compose up -d --build'

                        } catch (Exception e) {
                            currentBuild.result = 'FAILURE'
                            error "Build failed: ${e.getMessage()}"
                        }
                    }
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