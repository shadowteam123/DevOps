pipeline {
    agent any

    // Docker credentails
    environment {
		DOCKERHUB_CREDENTIALS=credentials('Shadowteam-dockerhub')
	}

    stages {
        stage("Build de l'image de l'application") {
             steps {
                sh 'docker build -t app_pharmacie .'
                echo "Building application image"
             }
        }
	    
        // Build de l’image de la base de données
        stage("Build de l'image de la base de données") {
             steps {
                sh 'docker build -t db_pharmacie ./bdd/'
                echo "Building database image"
             }
        }
	    
        stage('Prepare Environement') {
            steps
            {
                script {
                    containerName = sh(returnStdout: true, script: "docker ps  -f 'name=phpmyadmin' --format '{{.Names}}'").trim()
                    containerNames = sh(returnStdout: true, script: "docker ps  -f 'name=php_pharma' --format '{{.Names}}'").trim()
                    containerNamess = sh(returnStdout: true, script: "docker ps  -f 'name=database' --format '{{.Names}}'").trim()
                    if(containerName == "phpmyadmin" || containerNames == "php" || containerNamess == "database")
                    {
                        sh 'docker rm php_pharma --force'
                        sh "echo 'Nettoyage environnement OK'"
                        sh 'docker rm database --force'
                        sh "echo 'Nettoyage environnement OK'"
                        sh 'docker rm phpmyadmin --force'
                        sh 'docker rm php --force'
                        sh "echo 'Nettoyage environnement OK'"
                    }
                    else
                    {
                        sh "echo 'Ennvironnement OK'"
                    }
                }
            }
         }
        // Déploiement des services via Docker Compose
        stage('Déploiement des services via docker-compose') {
             steps {
                sh 'docker-compose up -d'
             }
            post{
                success{
                    echo "Build image de l'application réussie."
                    echo "Build image de la base de données réussie."
                }
        }
        }
	    
        // Test de l’application avec curl et navigateur web
        stage('Test application') {
            steps {
               sh 'curl http://localhost:9000'
            }
        }
	    
        //Connexion à Github
        stage('Connexion à Docker Hub') {

			steps {
				sh 'echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin'
			}
		}
	//Tag des images
        stage('Tag des images') {

			steps {
				sh 'docker tag continuous-delivery-pharmacie_mysql:latest shadowteam123/test:latest'
                sh 'docker tag continuous-delivery-pharmacie_http:latest shadowteam123/test:latest'
          
			}
		}

        // Push des images Docker sur Docker Hub
		stage('Push des images docker sur Docker Hub') {

			steps {
				sh 'docker push shadowteam123/test:latest'
          
			}
            
		}
        
    }
    post {
        success {
            slackSend message:"A new version of pharmacie_app is succesful build - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)"
                }
        }
}
