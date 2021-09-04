<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Rents Controller
 *
 * @property \App\Model\Table\RentsTable $Rents
 *
 * @method \App\Model\Entity\Rent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize(){

        parent::initialize();

       $this->Auth->allow(['unauthorized']);
    }

    public function isAuthorized($user)
    {
        if(!$user){
            return $this->redirect(['action' => 'unauthorized']);   
        }
        $this->user = $user;
        return true;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $action = $this->request->getParam('action');

        if (!$this->loggedIn && !in_array($action, ['unauthorized'])) {
            $this->actionTaken = $action;
            return $this->setAction('unauthorized');
        }
        return true;
    }

    public function unauthorized()
    {
        $response = new unauthorizedAccess('Please login to access ' . $this->actionTaken);
        $this->RequestHandler->renderAs($this, 'json');
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    // public function index(Query $query,array $options)
    public function index()
    {
        $this->paginate = [
            'conditions' => ['Users.id =' => $this->user['id']],
            'contain' => ['Users', 'Books'],
        ];
        $rents = $this->paginate();
        $response = new authorizedAccess($rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * View method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rent = $this->Rents->get($id, [
            'conditions' => ['Users.id =' => $this->user['id']],
            'contain' => ['Users', 'Books'],
        ]);

        $response = new authorizedAccess($rent);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rent = $this->Rents->newEntity();
        if ($this->request->is('post')) {
            $rent = $this->Rents->patchEntity($rent, $this->request->getData());
            if ($this->Rents->save($rent)) {
                $this->Flash->success(__('The rent has been saved.'));
                // return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rent could not be saved. Please, try again.'));
            }
        }
        // $users = $this->Rents->Users->find('list', ['limit' => 200]);
        // $books = $this->Rents->Books->find('list', ['limit' => 200]);

        $rents = $this->paginate($this->Rents);
        $response = new authorizedAccess($rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rent = $this->Rents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rent = $this->Rents->patchEntity($rent, $this->request->getData());
            if ($this->Rents->save($rent)) {
                $this->Flash->success(__('The rent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rent could not be saved. Please, try again.'));
        }

        $rents = $this->paginate($this->Rents);
        $response = new authorizedAccess($rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Delete method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rent = $this->Rents->get($id);
        if ($this->Rents->delete($rent)) {
            $this->Flash->success(__('The rent has been deleted.'));
        } else {
            $this->Flash->error(__('The rent could not be deleted. Please, try again.'));
        }

        $rents = $this->paginate($this->Rents);
        $response = new authorizedAccess($rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
}
