<?php
namespace App\Controller;

use App\Controller\AppController;


class MessagesController extends AppController
{
    public function index()
    {
		// this just throws you back
		return $this->redirect($this->referer());
    }
	
	public function add() {
		$message = $this->Messages->newEntity();
        if ($this->request->is('post')) {
            // get data from the form
            $message = $this->Messages->patchEntity($message, $this->request->data);  
            
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The workinghour has been saved.'));
				return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The workinghour could not be saved. Please, try again.'));
            }
        }
        
		$this->set(compact('message'));
        $this->set('_serialize', ['message']);
	}
	
	public function edit($id = null) {
		
	}
}