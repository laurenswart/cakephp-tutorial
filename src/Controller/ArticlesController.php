<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

class ArticlesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }
    
    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }
    
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            
            // L'�criture de 'user_id' en dur est temporaire et
            // sera supprim�e quand nous aurons mis en place l'authentification.
            $article->user_id = 1;
            
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Votre article a �t� sauvegard�.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter votre article.'));
        }
        $this->set('article', $article);
    }
    
    public function edit($slug)
    {
        $article = $this->Articles
        ->findBySlug($slug)
        ->firstOrFail();
        
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Votre article a �t� mis � jour.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de mettre � jour l\'article.'));
        }
        
        $this->set('article', $article);
    }
    
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('L\'article {0} a �t� supprim�.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }
}