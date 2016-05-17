<?php
namespace App\Controller;

use App\Controller\AppController;


class CommentsController extends AppController
{
    public function index()
    {
		// this just throws you back
		return $this->redirect($this->referer());
    }
	
	public function add() {
		$comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            // get data from the form
            $comment = $this->Comments->patchEntity($comment, $this->request->data);  
            
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
			return $this->redirect($this->referer());
        }
        
		$this->set(compact('comment'));
        $this->set('_serialize', ['comment']);
		return $this->redirect($this->referer());
	}
	
	public function edit($id = null) {
		$this->Flash->success(__('Editing is not available yet.'));
		$this->index();
	}
	
	public function delete($id = null) {	
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
	}
	
	public function isAuthorized($user) {
		// everyone can leave comments
		if ($this->request->action === 'add') {
			return True;
		}
		// if editing or deleting, you have to be the owner
		if ($this->request->action === 'edit' || $this->request->action === 'delete') {
			$query = $this->Comments
					->find()
					->select(['user_id'])
                    ->where(['id =' => $this->request->pass[0]])
                    ->toArray();

			if ($query[0]->user_id == $this->request->session()->read('Auth.User.id')) {
				return True;
			}
		}
		return parent::isAuthorized($user);
	}
}