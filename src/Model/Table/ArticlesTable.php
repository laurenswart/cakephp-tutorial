<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
// la classe EventInterface
use Cake\Event\EventInterface;
// la classe Validator
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
    
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // On ne garde que le nombre de caractère correspondant à la longueur
            // maximum définie dans notre schéma
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
        
    // Ajouter la méthode suivante.
    public function validationDefault(Validator $validator): Validator
    {
        $validator
        ->notEmptyString('title')
        ->minLength('title', 10)
        ->maxLength('title', 255)
        
        ->notEmptyString('body')
        ->minLength('body', 10);
        
        return $validator;
    }
}
