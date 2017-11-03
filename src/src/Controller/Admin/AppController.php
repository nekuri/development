<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Session\DatabaseSession;
use \Exception;
use Cake\Network\Exception\NotFoundException;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $helpers = [
        'Paginator' => [
            'className' => 'BootstrapUI.Paginator',
            'templates' => [
                'nextActive' => '<li class="page-item"><a rel="next" href="{{url}}" class="page-link">{{text}}</a></li>',
                'nextDisabled' => '',
                'prevActive' => '<li class="page-item"><a rel="prev" href="{{url}}" class="page-link">{{text}}</a></li>',
                'prevDisabled' => '',
                'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
                'current' => '<li class="page-item disabled"><a href="" class="page-link">{{text}}</a></li>',
                'first' => '<li class="first page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
                'last' => '<li class="last page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
            ],
        ],
        'Html' => [
            'className' => 'BootstrapUI.Html',
        ],
        'Form' => [
            'className' => 'BootstrapUI.Form',
        ]
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'animeArticles',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
            ]
        ]);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
