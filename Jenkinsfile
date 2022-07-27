pipeline {
    agent any

    // Docker credentails
    environment {
		DOCKERHUB_CREDENTIALS=credentials('dockerhub-jenkins')
	}

    // Récupération du code sur la branche delivery

    stages {
        // Déploiement des services via Docker Compose
        stage('Déploiement docker-compose') {
             steps {
                sh 'docker-compose up'
             }
        }
        post{
            success{
                echo "Build image de l'application réussie."
                echo "Build image de la base de données réussie."
            }
        }

        // Test de l’application avec curl et navigateur web
        stage('Test application') {
            steps {
               sh 'curl http://localhost:9000'
            }
        }

        
        stage('Login to Docker Hub') {

			steps {
				sh 'echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin'
			}
		}

        stage('Tag des images') {

			steps {
				sh 'docker tag -a shadowteam123/test:latest'
          
			}
		}

        // Push des images Docker sur Docker Hub
		stage('Push vers le repo Docker Hub') {

			steps {
				sh 'docker push shadowteam123/test:latest'
          
			}
		}
        
    }
}
