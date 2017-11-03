<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use \Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Exception\NotFoundException;

/**
 * Animes Controller
 *
 * @property \App\Model\Table\AnimesTable $Animes
 *
 * @method \App\Model\Entity\Anime[] paginate($object = null, array $settings = [])
 */
class AnimeArticlesController extends AppController
{
    public function initialize()
    {
        $this->viewBuilder()->setLayout('anime_layout');

        parent::initialize();
        $this->loadModel('Animes');
    }

    public function index()
    {
        $result = $this->Animes->find('all');
        $animes = $this->paginate($result);
        $this->set(compact('animes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function image($id = null)
    {
        try {
            if (!isset($id)) {
                $this->Flash->error('アニメidを指定してください');
                return $this->redirect(['controller' => 'animeArticles', 'action' => 'index']);
            }

            $anime = $this->Animes->get($id);
        } catch(RecordNotFoundException $e) {
            $this->Flash->error('存在しないレコードです');
            return $this->redirect(['controller' => 'animeArticles', 'action' => 'index']);
        }
        if ($this->request->is('post')) {
            $anime = $this->Animes->patchEntity($anime, $this->request->getData());
            if ($this->Animes->save($anime)) {
                $this->Flash->success(__('保存に成功しました。'));

                return $this->redirect(['action' => 'image', $id]);
            }
            $errors = [];
            foreach($anime->errors() as $error) {
                $errors = Hash::extract($error, '{s}');
            }
            $this->set(compact('errors'));
            $this->Flash->error(__('正しくアプロードができませんでした。'));
        }

        $this->set(compact('anime'));
        $this->set('_serialize', ['anime']);
    }

}
