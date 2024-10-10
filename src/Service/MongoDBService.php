<?php

namespace App\Service;

use App\Entity\Animal;
use MongoDB\Client;

class MongoDBService
{
    private $client;
    private $database;

    public function __construct()
    {
        $databaseName="zoo_db";
        $this->client = new Client("mongodb://localhost:27017/");
        $this->database = $this->client->$databaseName;
    }

    public function getCollection(string $collectionName)
    {
        return $this->database->$collectionName;
    }

    public function incrementConsultation(Animal $animalEntity)
    {
        $collection = $this->getCollection('animals'); // Adjust the database name as necessary

        // Find the animal document
        $animal = $collection->findOne(['name' => $animalEntity->getName()]);

        if ($animal) {
            // If found, increment the consultation count
            $collection->updateOne(
                ['name' => $animal['name']],
                ['$inc' => ['consultation_count' => 1]]
            );
        } else {
            // If not found, create a new entry
            $collection->insertOne([
                'id' => $animalEntity->getId(),
                'name' => $animalEntity->getName(),
                'race' => $animalEntity->getRace(),
                'consultation_count' => 1
            ]);
        }
    }

    public function getConsultationCount(string $animalName): int
    {
        $collection = $this->getCollection('animals');

        $animal = $collection->findOne(['name' => $animalName]);
        
        return $animal ? $animal['consultation_count'] : 0;
    }

    public function findAnimalsOrderedByConsultationCount(): array{
        $collection = $this->getCollection('animals');
        $animals = $collection->find([], [
            'sort' => ['consultation_count' => -1]  // -1 for descending order
        ]);
        return iterator_to_array($animals);
    }
}
