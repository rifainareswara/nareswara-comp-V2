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
                            def containerExists = sh(script: "docker ps -a --format '{{.Names}}' | grep -w 'nareswara_comp'", returnStatus: true) == 0
                            
                            if (containerExists) {
                                echo "Containers already exist. Restarting them..."
                                sh 'docker compose up -d'
                            } else {
                                echo "Building and starting containers..."
                                sh 'docker compose up -d --build'
                            }
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
