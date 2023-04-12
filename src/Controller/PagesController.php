<?php
declare(strict_types=1);

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
namespace Tusk\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Tusk\Controller\AppController as BaseController;

use Tusk\Model\Table\ContentsTable;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends BaseController {

	private $root = [0 => 'Root'];

	public function initialize(): void {
		parent::initialize();
		$this->Contents = new ContentsTable();
    }

    public function index() {
		$pages = $this->Pages->find('all');
		$this->set(['pages' => $pages]);
	}

	public function change(int $id = null) {
		$entry = $this->Pages->getEntry($id);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$page = $this->Pages->patchEntity($entry, $this->request->getData());
            
			if ($this->Pages->save($page)) {
				$this->Flash->success(__('The table has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The table could not be saved. Please, try again.'));
        }
		
		$filter = !empty($id) ? ['id !=' => $id] : Null;
		$layouts = $this->Pages->Layouts->find('list')->all();
		$pages = $this->Pages->find('list')->where($filter)->all();
		$pages = $this->root + $pages->toArray();

		$this->set([
			'entry' => $entry,
			'pages' => $pages,
			'layouts' => $layouts
		]);
	}

	public function edit(int $id) {
		$page = $this->Pages->getEntry($id);

		$this->set([
			'page' => $page,
		]);
	}

	public function addContent(int $id) {
		$page = $this->Pages->getEntry($id);
		$entry = $this->Contents->newEmptyEntity();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$content = $this->Contents->patchEntity($entry, $this->request->getData());
            
			if ($this->Pages->save($content)) {
				$this->Flash->success(__('The table has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The table could not be saved. Please, try again.'));
        }
		
		$this->set([
			'entry' => $entry,
			'page' => $page,
		]);
	}
}
