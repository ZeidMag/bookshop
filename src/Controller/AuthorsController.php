<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Authors Controller
 *
 * @property \App\Model\Table\AuthorsTable $Authors
 *
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthorsController extends AppController
{
    public function initialize(){

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
        $response = new unauthorizedAccess('Please login to ' . $this->actionTaken . ' an author');
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
        $authors = $this->paginate($this->Authors);
        $response = new authorizedAccess($authors);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * View method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => ['Books'],
        ]);

        $response = new authorizedAccess($author);
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
        $author = $this->Authors->newEntity();
        if ($this->request->is('post')) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('The author has been saved.'));

                // return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The author could not be saved. Please, try again.'));
            }
        }
        $authors = $this->paginate($this->Authors);
        $response = new authorizedAccess($authors);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => [],
        ]);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('The author has been saved.'));

                // return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The author could not be saved. Please, try again.'));
            }
        }

        $authors = $this->paginate($this->Authors);
        $response = new authorizedAccess($authors);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Delete method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $author = $this->Authors->get($id);
        if ($this->Authors->delete($author)) {
            $this->Flash->success(__('The author has been deleted.'));
        } else {
            $this->Flash->error(__('The author could not be deleted. Please, try again.'));
        }

        $authors = $this->paginate($this->Authors);
        $response = new authorizedAccess($authors);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
}
