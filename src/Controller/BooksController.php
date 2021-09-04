<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */



class BooksController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index','view','unauthorized']);
    }

    public function isAuthorized($user)
    {
        if(!$user){
            return $this->redirect(['action' => 'unauthorized']);   
        }
        return true;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $action = $this->request->getParam('action');

        if (!$this->loggedIn && !in_array($action, ['index','view','unauthorized'])) {
            $this->actionTaken = $action;
            return $this->setAction('unauthorized');
        }
        return true;
    }

    public function unauthorized()
    {
        $response = new unauthorizedAccess('Please login to ' . $this->actionTaken . ' a book');
        $this->RequestHandler->renderAs($this, 'json');
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Authors'],
            'limit' => 200
        ];

        $books = $this->paginate($this->Books);
        $response = new authorizedAccess($books);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['Authors', 'Rents'],
        ]);

        $response = new authorizedAccess($book);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    public function react(){
        $filePath = WWW_ROOT . '/react/asset-manifest.json';
        $file = new File($filePath);

        $manifest = json_decode($file->read());
        $file->close();
        $css = [];
        $js = [];
        foreach($manifest->entrypoints as $resource) {
               if (  preg_match('/\.css$/', $resource) === 1 ) {
                    $css[] = '/react/' . $resource;
               }
               if (  preg_match('/\.js$/', $resource) === 1 ) {
                $js[] = '/react/' . $resource;
           }
        }
        $this->set(compact('css', 'js'));
}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEntity();
        $ajax = $this->request->is('ajax');
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                !$ajax && $this->Flash->success(__('The book has been saved.'));
            }
            !$ajax && $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $authors = $this->Books->Authors->find('list', ['limit' => 200]);

        $this->paginate = [
            'contain' => ['Authors'],
        ];
        $books = $this->paginate($this->Books);
        $response = new authorizedAccess($books);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));
            }else {
                $this->Flash->error(__('The book could not be saved. Please, try again.'));
            }
        }

        $books = $this->paginate($this->Books);
        $response = new authorizedAccess($books);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        // return $this->redirect(['action' => 'index']);
        $books = $this->paginate($this->Books);
        $response = new authorizedAccess($books);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($books);
        $this->set(compact('books'));
        $this->set('_serialize', 'books');
    }
}
