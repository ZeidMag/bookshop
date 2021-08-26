<?php
namespace App\Controller;

use App\Controller\AppController;

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
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Books'],
        ];
        $rents = $this->paginate($this->Rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($rents);
        $this->set(compact('rents'));
        $this->set('_serialize', 'rents');
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
            'contain' => ['Users', 'Books'],
        ]);

        $this->set('rent', $rent);
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
        $users = $this->Rents->Users->find('list', ['limit' => 200]);
        $books = $this->Rents->Books->find('list', ['limit' => 200]);

        $rents = $this->paginate($this->Rents);
        $this->RequestHandler->renderAs($this, 'json');
        $this->log($rents);
        $this->set(compact('rents', 'users', 'books'));
        $this->set('_serialize', 'rents', 'users', 'books');
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
        $users = $this->Rents->Users->find('list', ['limit' => 200]);
        $books = $this->Rents->Books->find('list', ['limit' => 200]);
        $this->set(compact('rent', 'users', 'books'));
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

        return $this->redirect(['action' => 'index']);
    }
}
