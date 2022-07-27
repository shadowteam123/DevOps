pipeline {
    agent any

    // Récupération du code sur la branche delivery
    // Build de l'image de l'application
    stages {
        // Déploiement des services via Docker Compose
        stage('Déploiement docker-compose') {
             steps {
                sh 'docker-compose up'
             }
        }
        // Test de l’application avec curl et navigateur web
        stage('Test application') {
            steps {
               sh 'curl http://localhost:9000'
            }
        }
        
    }
}
