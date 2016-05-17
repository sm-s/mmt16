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
				return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }
        
		$this->set(compact('comment'));
        $this->set('_serialize', ['comment']);
	}
	
	public function edit($id = null) {
		
	}
	
	public function delete($id = null) {
		
	}
}