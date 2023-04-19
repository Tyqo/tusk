<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PagesTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('tusk_pages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->hasMany('Tusk.Contents')
			->setForeignKey('page_id')
            ->setDependent(true);

		$this->hasOne('Tusk.Pages');
		$this->hasOne('Tusk.Layouts');
    }
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function slug(string $slug) {
		return $this->find()->where(["name" => $slug])->contain(['Contents' => ['Elements']])->first();
	}
	
	public function getChildren($parentId, $pages) {
		$children = [];

		foreach ($pages as $page) {
			if ($page['parent'] != $parentId) {
				continue;
			}
		
			$page['children'] = $this->getChildren($page['id'], $pages);
			$children[] = $page;
		}

		return $children;
	}
}