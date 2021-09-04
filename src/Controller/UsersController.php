<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login','unauthorized','logout','add']);
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

        if (!$this->loggedIn && !in_array($action, ['login','unauthorized','logout','add'])) {
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
    
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $response = new authorizedAccess($user);
                $this->RequestHandler->renderAs($this, 'json');
                $this->log($response);
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
            } else {
                $response = new unauthorizedAccess('Your username or password is incorrect');
                $this->RequestHandler->renderAs($this, 'json');
                $this->log($response);
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                
            }
        }
    }

    public function logout()
    {
        $this->Auth->logout();
        $message = 'you are logged out';
        $response = new authorizedAccess($message);
                $this->RequestHandler->renderAs($this, 'json');
                $this->log($response);
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
    }

    
    public function index()
    {
        // $users = $this->paginate($this->Users);

        // $this->set(compact('users'));
        $response = new unauthorizedAccess('Unauthorized Access');
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($response);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->user['id'] != $id){
            $response = new unauthorizedAccess('Unauthorized Access');
            $this->RequestHandler->renderAs($this, 'json');
            $this->log($response);
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }

        $user = $this->Users->get($id, [
            'contain' => ['Rents'],
        ]);
        $response = new authorizedAccess($user);
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
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $response = new successfulRegister();
                $this->RequestHandler->renderAs($this, 'json');
                $this->log($response);
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
            } else {
                $response = new unauthorizedAccess('User already exists');
                $this->RequestHandler->renderAs($this, 'json');
                $this->log($response);
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
            }
        }
        
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($this->user['id'] != $id){
            $response = new unauthorizedAccess('Unauthorized Access');
            $this->RequestHandler->renderAs($this, 'json');
            $this->log($response);
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                // return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        
        $this->set('user', $user);
        $this->RequestHandler->renderAs($this, 'json');
        $this->set('_serialize', 'user');
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
