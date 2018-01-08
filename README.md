# crud-symfony-mongodb

A simple crud symfony - mongodb example.

PHP 5.6.30
Used Bundle with composer: "doctrine/mongodb-odm-bundle": "^3.0"
Used BUndle with Kernel: "new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),"
Global param used:  mongodb_server: "mongodb://localhost:27017"
Required Config:

doctrine_mongodb:
    connections:
        default:
            server: "%mongodb_server%"
            options: {}
    default_database: test_database
    document_managers:
        default:
            auto_mapping: true
